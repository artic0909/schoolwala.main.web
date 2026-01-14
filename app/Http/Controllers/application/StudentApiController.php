<?php

namespace App\Http\Controllers\application;

use App\Models\Classes;
use App\Models\StudentProfile;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Video;
use App\Models\Subscribers;
use App\Models\Fees;
use App\Models\ContactUs;
use App\Models\WaverRequest;
use App\Models\PasswordReset;
use App\Models\StudentTest;
use App\Mail\EnquirySend;
use App\Mail\EnquiryRecieved;
use App\Mail\WaiverReceived;
use App\Mail\SubscriptionMailFromStudent;

class StudentApiController extends AppController
{
    // ===============================================================================================
    // HELPER: Check if student has active subscription for a class
    // ===============================================================================================
    private function hasActiveSubscription($studentId, $classId)
    {
        return Subscribers::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('status', 'active') // Strict status check
            ->whereDate('expiry_date', '>=', now()) // Ensure subscription hasn't expired
            ->exists();
    }

    // ===============================================================================================
    // PROFILE & AUTHENTICATION
    // ===============================================================================================

    /**
     * Get Student Profile.
     */
    public function getProfile(Request $request)
    {
        $student = $request->user();

        // Sync profile stats with actual test data (Self-healing)
        $totalScore = (int) StudentTest::where('student_id', $student->id)->sum('score');
        $totalTests = (int) StudentTest::where('student_id', $student->id)->count();

        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $student->id],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        // Always update to ensure latest data
        $profile->total_practise_test_score = $totalScore;
        $profile->no_practise_test = $totalTests;
        $profile->save();

        $class = Classes::find($student->class_id);

        return $this->sendResponse([
            'student' => $student,
            'profile' => $profile,
            'class_details' => $class
        ], 'Profile retrieved successfully.');
    }

    /**
     * Update Student Profile (Name, Image).
     */
    public function updateProfile(Request $request)
    {
        $student = $request->user();

        if ($request->has('student_name')) {
            $student->student_name = $request->student_name;
            $student->save();
        }

        $profile = StudentProfile::firstOrCreate(['student_id' => $student->id]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
            $profile->profile_icon = null;
        } elseif ($request->filled('profile_icon')) {
            $profile->profile_icon = $request->profile_icon;
            $profile->profile_image = null;
        }

        if ($request->has('interest_in')) {
            $profile->interest_in = json_encode($request->interest_in);
        }

        $profile->save();

        return $this->sendResponse($profile, 'Profile updated successfully.');
    }

    /**
     * Change Password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $student = $request->user();

        if (!Hash::check($request->current_password, $student->password)) {
            return $this->sendError('Invalid current password', [], 400);
        }

        $student->password = Hash::make($request->new_password);
        $student->save();

        return $this->sendResponse([], 'Password changed successfully.');
    }

    // ===============================================================================================
    // CLASS → SUBJECTS → CHAPTERS → VIDEOS HIERARCHY
    // ===============================================================================================

    /**
     * Get My Class with Subjects (Class-wise structure).
     * Returns the student's registered class with all subjects.
     */
    public function getMyClass(Request $request)
    {
        $student = $request->user();

        $class = Classes::with([
            'subjects' => function ($query) {
                $query->withCount('chapters');
            },
            'fees'
        ])
            ->find($student->class_id);

        if (!$class) {
            return $this->sendError('Class not found assigned to student.', [], 404);
        }

        // Check if student has active subscription
        $hasSubscription = $this->hasActiveSubscription($student->id, $class->id);

        // Add subscription status to response
        $class->has_active_subscription = $hasSubscription;

        return $this->sendResponse($class, 'Class with subjects retrieved successfully.');
    }

    /**
     * Get Subject with Chapters (Subject-wise structure).
     * Shows all chapters for a subject with lock status.
     * ALL chapters require active subscription.
     */
    public function getSubjectChapters(Request $request, $subjectId)
    {
        $student = $request->user();

        $subject = Subject::with([
            'chapters' => function ($q) {
                $q->withCount('videos')->orderBy('id', 'asc');
            }
        ])->find($subjectId);

        if (!$subject) {
            return $this->sendError('Subject not found.', [], 404);
        }

        // Check for active subscription
        $hasSubscription = $this->hasActiveSubscription($student->id, $subject->class_id);

        // Transform chapters to add lock status and index
        $chapters = $subject->chapters->map(function ($chapter, $index) use ($hasSubscription) {
            return [
                'id' => $chapter->id,
                'chapter_name' => $chapter->chapter_name,
                'chapter_description' => $chapter->chapter_description,
                'videos_count' => $chapter->videos_count,
                'is_locked' => !$hasSubscription, // ALL chapters locked if no subscription
                'chapter_index' => $index + 1
            ];
        });

        return $this->sendResponse([
            'subject' => [
                'id' => $subject->id,
                'subject_name' => $subject->subject_name,
                'subject_description' => $subject->subject_description,
                'class_id' => $subject->class_id
            ],
            'chapters' => $chapters,
            'has_subscription' => $hasSubscription,
            'total_chapters' => $chapters->count(),
            'unlocked_chapters' => $hasSubscription ? $chapters->count() : 0 // 0 unlocked if no sub
        ], 'Subject chapters retrieved successfully.');
    }

    /**
     * Get Chapter with Videos (Chapter-wise structure).
     * Only accessible if:
     * - Student has active subscription (for ALL chapters)
     */
    public function getChapterVideos(Request $request, $chapterId)
    {
        $student = $request->user();

        $chapter = Chapter::with(['videos', 'subject'])->find($chapterId);

        if (!$chapter) {
            return $this->sendError('Chapter not found.', [], 404);
        }

        // Check subscription
        $hasSubscription = $this->hasActiveSubscription($student->id, $chapter->subject->class_id);

        // Enforce strict access control for ALL chapters
        if (!$hasSubscription) {
            return $this->sendError(
                'This chapter is locked. Please subscribe to unlock course content.',
                [
                    'is_locked' => true,
                    'requires_subscription' => true
                ],
                403
            );
        }

        // Pre-fetch submitted tests for these videos
        $submittedVideoIds = [];
        if ($chapter->videos->isNotEmpty()) {
            $submittedVideoIds = StudentTest::where('student_id', $student->id)
                ->whereIn('video_id', $chapter->videos->pluck('id'))
                ->pluck('video_id')
                ->toArray();
        }

        // Return videos with additional info
        return $this->sendResponse([
            'chapter' => [
                'id' => $chapter->id,
                'chapter_name' => $chapter->chapter_name,
                'chapter_description' => $chapter->chapter_description,
                'subject_id' => $chapter->subject_id,
                'subject_name' => $chapter->subject->subject_name
            ],
            'videos' => $chapter->videos->map(function ($video) use ($submittedVideoIds) {
                return [
                    'id' => $video->id,
                    'video_title' => $video->video_title,
                    'video_description' => $video->video_description,
                    'video_link' => $video->video_link,
                    'video_thumbnail' => $video->video_thumbnail,
                    'note_link' => $video->note_link,
                    'duration' => $video->duration,
                    'likes' => $video->likes ?? 0,
                    'views' => $video->views ?? 0,
                    'has_practice_test' => !empty($video->questions),
                    'has_submitted_test' => in_array($video->id, $submittedVideoIds)
                ];
            }),
            'is_locked' => false,
            'is_first_chapter' => false, // Concept of free first chapter removed
        ], 'Chapter videos retrieved successfully.');
    }

    // ===============================================================================================
    // VIDEO INTERACTION
    // ===============================================================================================

    /**
     * Get Video Details (Play).
     * Check if video's chapter is accessible before showing details.
     */
    public function getVideoDetails(Request $request, $videoId)
    {
        $student = $request->user();

        $video = Video::with(['chapter.subject'])->find($videoId);

        if (!$video) {
            return $this->sendError('Video not found.', [], 404);
        }

        $chapter = $video->chapter;

        // Strict Subscription Check
        $hasSubscription = $this->hasActiveSubscription($student->id, $chapter->subject->class_id);

        if (!$hasSubscription) {
            return $this->sendError(
                'This video is locked. Please subscribe to access.',
                ['is_locked' => true],
                403
            );
        }

        $feedbacks = Feedback::where('video_id', $videoId)
            ->with('student')
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse([
            'video' => $video,
            'feedbacks' => $feedbacks,
            'chapter_info' => [
                'id' => $chapter->id,
                'name' => $chapter->chapter_name,
                'subject_name' => $chapter->subject->subject_name
            ]
        ], 'Video details retrieved.');
    }

    /**
     * Like a Video.
     */
    public function likeVideo(Request $request)
    {
        $request->validate(['video_id' => 'required|integer|exists:videos,id']);

        $video = Video::findOrFail($request->video_id);
        $video->increment('likes');

        return $this->sendResponse(['likes' => $video->likes], 'Video liked successfully.');
    }

    /**
     * Submit Feedback for Video.
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'video_id' => 'required|integer|exists:videos,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
        ]);

        $student = $request->user();

        $feedback = Feedback::create([
            'student_id' => $student->id,
            'video_id' => $request->video_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);

        return $this->sendResponse($feedback, 'Feedback submitted successfully.');
    }

    // ===============================================================================================
    // PRACTICE TEST
    // ===============================================================================================

    /**
     * Get Practice Test for a Video.
     */
    public function getPracticeTest(Request $request, $videoId)
    {
        $student = $request->user();
        $video = Video::with(['chapter.subject'])->findOrFail($videoId);

        // Check access
        $chapter = $video->chapter;
        $hasSubscription = $this->hasActiveSubscription($student->id, $chapter->subject->class_id);

        if (!$hasSubscription) {
            return $this->sendError('This test is locked. Please subscribe to access.', ['is_locked' => true], 403);
        }

        $forceJson = function ($data) {
            return is_string($data) ? json_decode($data, true) : $data;
        };

        $questions = $forceJson($video->questions);
        $answers = $forceJson($video->answers);

        if (!is_array($answers)) {
            $answers = array_map('trim', explode(',', $answers));
        }

        foreach ($answers as &$ans) {
            if (is_string($ans)) {
                $decoded = json_decode($ans, true);
                $ans = (json_last_error() === JSON_ERROR_NONE) ? $decoded : array_map('trim', explode(',', $ans));
            }
        }

        $submittedTest = StudentTest::where('student_id', $student->id)
            ->where('video_id', $videoId)
            ->first();

        return $this->sendResponse([
            'questions' => $questions,
            'options' => $answers,
            'submitted_test' => $submittedTest,
            'video_title' => $video->video_title
        ], 'Practice test retrieved.');
    }

    /**
     * Submit Practice Test.
     */
    public function submitPracticeTest(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'answers' => 'required|array',
        ]);

        $student = $request->user();
        $videoId = $request->video_id;
        $studentAnswers = $request->answers;

        $video = Video::findOrFail($videoId);

        $correctAnswers = is_string($video->correct_answers)
            ? json_decode($video->correct_answers, true)
            : $video->correct_answers;

        // Calculate score (2 marks per correct answer)
        $score = 0;
        foreach ($studentAnswers as $index => $answer) {
            if (isset($correctAnswers[$index]) && strtolower($answer) == strtolower($correctAnswers[$index])) {
                $score += 2;
            }
        }

        // Store or update student test
        $studentTest = StudentTest::updateOrCreate(
            ['student_id' => $student->id, 'video_id' => $videoId],
            ['student_answers' => $studentAnswers, 'score' => $score]
        );

        // Update student profile
        $studentProfile = StudentProfile::firstOrCreate(
            ['student_id' => $student->id],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        // Increment the number of tests and add the score
        $studentProfile->increment('no_practise_test'); // +1
        $studentProfile->increment('total_practise_test_score', $score); // + current score

        return $this->sendResponse([
            'score' => $score,
            'total_questions' => count($correctAnswers ?? []),
            'student_test' => $studentTest
        ], 'Test submitted successfully.');
    }

    // ===============================================================================================
    // SUBSCRIPTION & PAYMENTS
    // ===============================================================================================

    /**
     * Get Payment Info (Fees for student's class).
     */
    public function getPaymentInfo(Request $request)
    {
        $student = $request->user();

        $class = Classes::with('fees')->find($student->class_id);

        if (!$class) {
            return $this->sendError('Class not found.', [], 404);
        }

        $fees = $class->fees->first();

        if (!$fees) {
            return $this->sendError('No fees information available for this class.', [], 404);
        }

        // QR image is stored via public disk: storage/app/public/fees_qr/
        // Database path: 'fees_qr/image.png'
        // Access via storage symlink: public/storage/fees_qr/image.png
        // Generate full URL: https://domain.com/storage/fees_qr/image.png
        $fees->qrimage_url = $fees->qrimage
            ? asset('storage/' . $fees->qrimage)
            : null;

        \Log::info('QR Image Path: ' . $fees->qrimage);
        \Log::info('QR Image URL: ' . $fees->qrimage_url);

        $hasSubscription = $this->hasActiveSubscription($student->id, $class->id);

        $currentSubscription = Subscribers::where('student_id', $student->id)
            ->where('class_id', $class->id)
            ->orderBy('subscription_date', 'desc')
            ->first();

        return $this->sendResponse([
            'class' => [
                'id' => $class->id,
                'name' => $class->name,
            ],
            'fees' => [
                'id' => $fees->id,
                'amount' => $fees->amount,
                'qrimage_url' => $fees->qrimage_url,
            ],
            'has_active_subscription' => $hasSubscription,
            'current_subscription' => $currentSubscription,
        ], 'Payment information retrieved.');
    }


    /**
     * Store Payment / Upload Receipt.
     */
    public function storePayment(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'fees_id' => 'required|exists:fees,id',
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $student = $request->user();

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '_' . $student->id . '.' . $file->getClientOriginalExtension();
            $receiptPath = $file->storeAs('receipts', $filename, 'public');
        }

        $existingSubscriber = Subscribers::where('student_id', $student->id)
            ->where('class_id', $request->class_id)
            ->where('fees_id', $request->fees_id)
            ->first();

        if ($existingSubscriber) {
            $existingSubscriber->update([
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'status' => 'pending'
            ]);
            $message = 'Payment receipt updated successfully! Waiting for admin verification.';
        } else {
            Subscribers::create([
                'student_id' => $student->id,
                'class_id' => $request->class_id,
                'fees_id' => $request->fees_id,
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'expiry_date' => now()->addMonth(),
                'status' => 'pending'
            ]);
            $message = 'Payment submitted successfully! Waiting for admin verification.';

            $fee = Fees::find($request->fees_id);
            Mail::to('saklindeveloper@gmail.com')
                ->cc($student->email)
                ->send(new SubscriptionMailFromStudent([
                            'student_name' => $request->student_name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'class_id' => $request->class_id,
                            'fees_id' => $request->fees_id,
                            'amount' => $fee->amount,
                            'receipt' => $receiptPath
                        ]));
        }

        return $this->sendResponse([], $message);
    }

    // ===============================================================================================
    // PASSWORD RESET
    // ===============================================================================================

    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return $this->sendError('Email not found!', [], 404);
        }

        $otp = rand(100000, 999999);
        PasswordReset::updateOrCreate(
            ['email' => $student->email],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(10)]
        );

        Mail::raw("Your OTP is: {$otp}", function ($message) use ($student) {
            $message->to($student->email)->subject('Password Reset OTP');
        });

        return $this->sendResponse([], 'OTP sent to your email!');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || $record->expires_at->isPast()) {
            return $this->sendError('Invalid or expired OTP!', [], 400);
        }

        return $this->sendResponse([], 'OTP verified successfully.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || $record->expires_at->isPast()) {
            return $this->sendError('Invalid or expired OTP.', [], 400);
        }

        $student = Student::where('email', $request->email)->firstOrFail();
        $student->update(['password' => Hash::make($request->password)]);

        $record->delete();

        return $this->sendResponse([], 'Password reset successfully. Please login.');
    }

    // ===============================================================================================
    // FORMS & REQUESTS
    // ===============================================================================================

    public function contactUsSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            ContactUs::create($validated);

            Mail::to('saklindeveloper@gmail.com')->send(new EnquirySend($validated));
            Mail::to($validated['email'])->send(new EnquiryRecieved($validated));

            return $this->sendResponse([], 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function waverRequestSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'p_name' => 'required|string|max:255',
                'c_name' => 'required|string|max:255',
                'c_age' => 'required|integer',
                'email' => 'required|email|max:255',
                'mobile' => 'required|string|max:15',
                'address' => 'required|string',
            ]);

            WaverRequest::create($validated);
            Mail::to('saklindeveloper@gmail.com')->send(new WaiverReceived($validated));

            return $this->sendResponse([], 'Your waiver request has been submitted successfully!');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }
}
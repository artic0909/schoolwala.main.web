<?php

namespace App\Http\Controllers\application;

use App\Models\Classes;
use App\Models\StudentProfile;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;

class StudentApiController extends AppController
{
    /**
     * Get Student Profile.
     */
    public function getProfile(Request $request)
    {
        $student = $request->user();
        
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $student->id],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

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
        
        // Handle basic info update
        if ($request->has('student_name')) {
            $student->student_name = $request->student_name;
            $student->save();
        }

        // Handle Profile Image/Icon
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

    /**
     * Get My Class Content (Subjects).
     */
    public function getMyClass(Request $request)
    {
        $student = $request->user();
        $class = Classes::with(['subjects'])->find($student->class_id);

        if (!$class) {
             return $this->sendError('Class not found assigned to student.', [], 404);
        }

        return $this->sendResponse($class, 'Class curriculum retrieved.');
    }

    /**
     * Get Chapters for a Subject.
     */
    public function getSubjectChapters($subjectId)
    {
        $subject = \App\Models\Subject::with('chapters')->find($subjectId);

        if (!$subject) {
            return $this->sendError('Subject not found.', [], 404);
        }

        return $this->sendResponse($subject, 'Subject chapters retrieved.');
    }

    /**
     * Get Chapter Videos.
     */
    public function getChapterVideos($chapterId)
    {
        $chapter = \App\Models\Chapter::with('videos')->find($chapterId);

        if (!$chapter) {
            return $this->sendError('Chapter not found.', [], 404);
        }

        return $this->sendResponse($chapter, 'Chapter videos retrieved.');
    }

    // ===============================================================================================
    // AUTHENTICATION & PASSWORD RECOVERY
    // ===============================================================================================

    /**
     * Send OTP for Password Reset.
     */
    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $student = \App\Models\Student::where('email', $request->email)->first();

        if (!$student) {
            return $this->sendError('Email not found!', [], 404);
        }

        $otp = rand(100000, 999999);
        \App\Models\PasswordReset::updateOrCreate(
            ['email' => $student->email],
            ['otp' => $otp, 'expires_at' => \Illuminate\Support\Carbon::now()->addMinutes(10)]
        );

        Mail::raw("Your OTP is: {$otp}", function ($message) use ($student) {
            $message->to($student->email)->subject('Password Reset OTP');
        });

        return $this->sendResponse([], 'OTP sent to your email!');
    }

    /**
     * Verify OTP.
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = \App\Models\PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return $this->sendError('Invalid OTP!', [], 400);
        }

        if ($record->expires_at->isPast()) {
            return $this->sendError('OTP has expired!', [], 400);
        }

        return $this->sendResponse([], 'OTP verified successfully.');
    }

    /**
     * Reset Password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Re-verify OTP to ensure security
        $record = \App\Models\PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || $record->expires_at->isPast()) {
             return $this->sendError('Invalid or expired OTP.', [], 400);
        }

        $student = \App\Models\Student::where('email', $request->email)->firstOrFail();
        $student->update(['password' => Hash::make($request->password)]);

        $record->delete(); // Consume OTP

        return $this->sendResponse([], 'Password reset successfully. Please login.');
    }

    // ===============================================================================================
    // FORMS & REQUESTS
    // ===============================================================================================

    /**
     * Submit Contact Us Query.
     */
    public function contactUsSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            \App\Models\ContactUs::create($validated);

            Mail::to('saklindeveloper@gmail.com')->send(new \App\Mail\EnquirySend($validated));
            Mail::to($validated['email'])->send(new \App\Mail\EnquiryRecieved($validated));

            return $this->sendResponse([], 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Submit Waver Request.
     */
    public function waverRequestSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'p_name'   => 'required|string|max:255',
                'c_name'   => 'required|string|max:255',
                'c_age'    => 'required|integer',
                'email'    => 'required|email|max:255',
                'mobile'   => 'required|string|max:15',
                'address'  => 'required|string',
            ]);

            \App\Models\WaverRequest::create($validated);
            Mail::to('saklindeveloper@gmail.com')->send(new \App\Mail\WaiverReceived($validated));
            
            return $this->sendResponse([], 'Your waiver request has been submitted successfully!');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    // ===============================================================================================
    // SUBSCRIPTION & PAYMENTS
    // ===============================================================================================

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
            'subject_id' => 'required|exists:subjects,id',
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $student = $request->user();

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '_' . $student->id . '.' . $file->getClientOriginalExtension();
            $receiptPath = $file->storeAs('receipts', $filename, 'public');
        }

        $existingSubscriber = \App\Models\Subscribers::where('student_id', $student->id)
            ->where('class_id', $request->class_id)
            ->where('fees_id', $request->fees_id)
            ->first();

        if ($existingSubscriber) {
            $existingSubscriber->update([
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'status' => 'pending'
            ]);
            $message = 'Payment receipt updated successfully!';
        } else {
            \App\Models\Subscribers::create([
                'student_id' => $student->id,
                'class_id' => $request->class_id,
                'fees_id' => $request->fees_id,
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'expiry_date' => now()->addMonth(),
                'status' => 'pending'
            ]);
            $message = 'Payment submitted successfully!';

            $fee = \App\Models\Fees::find($request->fees_id);
            Mail::to('saklindeveloper@gmail.com')
            ->cc($student->email)
            ->send(new \App\Mail\SubscriptionMailFromStudent([
                'student_name' => $request->student_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'class_id' => $request->class_id,
                'fees_id' => $request->fees_id,
                'amount' => $fee->amount,
                'subject_id' => $request->subject_id,
                'receipt' => $receiptPath
            ]));
        }

        return $this->sendResponse([], $message);
    }

    // ===============================================================================================
    // VIDEO INTERACTION
    // ===============================================================================================

    /**
     * Get Video Details (Play).
     */
    public function getVideoDetails($chapterId, $videoId)
    {
        $video = \App\Models\Video::where('chapter_id', $chapterId)->findOrFail($videoId);
        
        $feedbacks = Feedback::where('video_id', $videoId)
            ->with('student')
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse([
            'video' => $video,
            'feedbacks' => $feedbacks
        ], 'Video details retrieved.');
    }

    /**
     * Like a Video.
     */
    public function likeVideo(Request $request)
    {
        $request->validate(['video_id' => 'required|integer|exists:videos,id']);
        
        $video = \App\Models\Video::findOrFail($request->video_id);
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
    public function getPracticeTest($videoId)
    {
        $video = \App\Models\Video::findOrFail($videoId);
        $student = request()->user();

        // Helper to safe decode JSON
        $forceJson = function($data) {
            if (is_string($data)) return json_decode($data, true);
            return $data;
        };

        $questions = $forceJson($video->questions);
        $answers = $forceJson($video->answers);

        if (!is_array($answers)) {
            $answers = array_map('trim', explode(',', $answers));
        }

        foreach ($answers as &$ans) {
           if (is_string($ans)) {
               $decoded = json_decode($ans, true);
               if (json_last_error() === JSON_ERROR_NONE) $ans = $decoded;
               else $ans = array_map('trim', explode(',', $ans));
           }
        }

        $submittedTest = \App\Models\StudentTest::where('student_id', $student->id)
            ->where('video_id', $videoId)
            ->first();

        return $this->sendResponse([
            'questions' => $questions,
            'options' => $answers,
            'submitted_test' => $submittedTest
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

        $video = \App\Models\Video::findOrFail($videoId);

        $correctAnswers = is_string($video->correct_answers)
            ? json_decode($video->correct_answers, true)
            : $video->correct_answers;

        $score = 0;
        foreach ($studentAnswers as $index => $answer) {
            if (isset($correctAnswers[$index]) && strtolower($answer) == strtolower($correctAnswers[$index])) {
                $score += 2;
            }
        }

        $studentTest = \App\Models\StudentTest::updateOrCreate(
            ['student_id' => $student->id, 'video_id' => $videoId],
            ['student_answers' => $studentAnswers, 'score' => $score]
        );

        $studentProfile = StudentProfile::firstOrCreate(
            ['student_id' => $student->id],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        $studentProfile->increment('no_practise_test');
        $studentProfile->increment('total_practise_test_score', $score);

        return $this->sendResponse([
            'score' => $score,
            'total_questions' => count($correctAnswers ?? []),
            'student_test' => $studentTest
        ], 'Test submitted successfully.');
    }
}

<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryRecieved;
use App\Mail\EnquirySend;
use App\Mail\Registration;
use App\Mail\SubscriptionMail;
use App\Mail\SubscriptionMailFromStudent;
use App\Mail\WaiverReceived;
use App\Models\AboutUs;
use App\Models\Chapter;
use App\Models\Classes;
use App\Models\ClassFAQ;
use App\Models\ContactUs;
use App\Models\Faculty;
use App\Models\FAQ;
use App\Models\Feedback;
use App\Models\PasswordReset;
use App\Models\Story;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\StudentTest;
use App\Models\Subject;
use App\Models\Subscribers;
use App\Models\Video;
use App\Models\WaverRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    public function loginView()
    {

        return view('student-login');
    }

    public function login(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed!');
        }

        // Check if student exists
        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Student not found!');
        }

        // Verify password
        if (!Hash::check($request->password, $student->password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid credentials!');
        }

        Auth::guard('student')->login($student);

        return redirect()->intended(route('student.home'))
            ->with('success', 'Login successful!');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.home')->with('success', 'Logout successful!');
    }

    // Forget Password ===============================================================================================================================>
    // Step 1: Show Forget Password Form
    public function forgetPassView()
    {
        return view('forget-password');
    }

    // Step 1: Handle Forget Password Request
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Email not found!');
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Delete old OTPs for this email
        PasswordReset::where('email', $student->email)->delete();

        // Save new OTP in DB
        PasswordReset::create([
            'email' => $student->email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10), // valid for 10 minutes
        ]);

        // Store email in session
        session(['reset_email' => $student->email]);


        // Send OTP via email
        Mail::raw("Your OTP is: {$otp}", function ($message) use ($student) {
            $message->to($student->email)
                ->subject('Password Reset OTP');
        });

        return redirect()->route('student.verify-otp-view')
            ->with('success', 'OTP sent to your email!')
            ->withInput(['email' => $student->email]);
    }




    // Step 2: Show Verify OTP Form
    public function verifyOTPView()
    {
        return view('verify-otp', ['email' => session('reset_email')]);
    }

    // Step 2: Handle OTP Verification
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return redirect()->back()->with('error', 'Invalid OTP!');
        }

        if ($record->expires_at->isPast()) {
            return redirect()->back()->with('error', 'OTP has expired!');
        }

        // OTP verified → Redirect to update password
        return redirect()->route('student.update-pass-view')
            ->with('success', 'OTP verified!')
            ->withInput(['email' => $request->email]);
    }




    // Step 3: Show Update Password Form
    public function updatePassView()
    {
        return view('update-password', ['email' => session('reset_email')]);
    }

    // Step 3: Handle Update Password Request
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found!');
        }

        // Update password
        $student->update([
            'password' => Hash::make($request->password),
        ]);

        // Remove OTP record after successful reset
        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('student.student-login')
            ->with('success', 'Password updated successfully! Please login.');
    }
    // Forget Password ===============================================================================================================================>


    public function registerView()
    {

        $classes = Classes::all();

        return view('student-register', compact('classes'));
    }

    public function register(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'class_id'      => 'required|integer|exists:classes,id',
                'student_name'  => 'required|string|max:255',
                'parent_name'   => 'required|string|max:255',
                'email'         => 'required|email|unique:students,email',
                'mobile'        => 'required|string|max:15',
                'age'           => 'required|integer',
                'password'      => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed!');
            }

            // ----- AUTO GENERATE STUDENT ID -----
            $year   = date('y'); // last 2 digits of year (e.g., 25 for 2025)
            $prefix = "SW";

            // Get class name (e.g., "Class 8" → "CLASS8")
            $class = Classes::findOrFail($request->class_id);
            $className = strtoupper(str_replace(' ', '', $class->name));

            // Find last student for this class
            $lastStudent = Student::where('class_id', $request->class_id)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastStudent && preg_match('/-(\d+)$/', $lastStudent->student_id, $matches)) {
                $lastNumber = (int) $matches[1];
            } else {
                $lastNumber = 0;
            }

            // Increment & pad number (01, 02, 03…)
            $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

            $studentId = "{$year}-{$prefix}-{$className}-{$nextNumber}";

            // ----- CREATE STUDENT -----
            $student = Student::create([
                'class_id'     => $request->class_id,
                'student_id'   => $studentId,
                'student_name' => $request->student_name,
                'parent_name'  => $request->parent_name,
                'email'        => $request->email,
                'mobile'       => $request->mobile,
                'age'          => $request->age,
                'password'     => Hash::make($request->password),
            ]);

            // MAIL TO STUDENT
            Mail::to($student->email)->send(new Registration($student));


            return redirect()->route('student.student-login')
                ->with('success', 'Student registered successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Profile View ====================================================================>
    public function studentProfileView()
    {
        $studentId = auth()->guard('student')->user()->id;

        $student = auth()->guard('student')->user();

        $class = Classes::with(['subjects.chapters'])
            ->where('id', $student->class_id)
            ->firstOrFail();


        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        $interests = $profile->interest_in ? json_decode($profile->interest_in, true) : [];

        return view('my-profile', compact('profile', 'class', 'interests'));
    }

    public function studentProfileUpdateView()
    {

        $student = auth()->guard('student')->user();

        $class = Classes::with(['subjects.chapters'])
            ->where('id', $student->class_id)
            ->firstOrFail();

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );



        return view('my-update-profile', compact('class', 'profile'));
    }

    public function studentProfileImageOrIconUpdate(Request $request)
    {
        $student = auth()->guard('student')->user();

        $profile = StudentProfile::firstOrCreate([
            'student_id' => $student->id
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
            $profile->profile_icon = null;
        } elseif ($request->filled('profile_icon')) {
            $profile->profile_icon = $request->profile_icon;
            $profile->profile_image = null;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function studentProfileNameUpdate(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer|exists:students,id',
            'student_name' => 'required|string|max:255',
        ]);

        $student = Student::find($request->id);
        $student->student_name = $request->student_name;
        $student->save();

        return redirect()->back()->with('success', 'Name updated successfully!');
    }

    public function studentProfileInterestUpdate(Request $request, $studentId)
    {
        $request->validate([
            'interest_in' => 'required|array',
            'interest_in.*' => 'string|max:255',
        ]);

        $student = StudentProfile::findOrFail($studentId);

        $student->interest_in = json_encode($request->interest_in);

        $student->save();

        return redirect()->back()->with('success', 'Interests updated successfully!');
    }

    public function studentProfilePasswordUpdate(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:students,email',
            'password' => [
                'required',
                'string',
                'min:8',             // Minimum 8 characters
                'confirmed',         // Must match password_confirmation
                // 'regex:/[a-z]/',     // At least one lowercase letter
                // 'regex:/[A-Z]/',     // At least one uppercase letter
                // 'regex:/[0-9]/',     // At least one digit
                // 'regex:/[@$!%*#?&]/' // At least one special character
            ],
        ]);

        // If validation fails, send as 'error'
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errors);
        }

        try {
            // Find student by email
            $student = Student::where('email', $request->email)->firstOrFail();

            // Update password
            $student->password = Hash::make($request->password);
            $student->save();

            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    // Profile View ====================================================================>











    // Home Page ================================================================================================================================>
    public function homeView()
    {
        // Fetch class, story, and faculty data (common for both)
        $classIds = Chapter::select('class_id')->distinct()->pluck('class_id');
        $classes = Classes::whereIn('id', $classIds)->get();
        $stories = Story::with('storyTag')->get();
        $faculties = Faculty::all();

        // Check if student is logged in
        if (auth()->guard('student')->check()) {
            $studentId = auth()->guard('student')->user()->id;

            $profile = StudentProfile::firstOrCreate(
                ['student_id' => $studentId],
                ['no_practise_test' => 0, 'total_practise_test_score' => 0]
            );

            // Logged-in student view (includes profile)
            return view('home', compact('profile', 'classes', 'stories', 'faculties'));
        }

        // Guest view (no profile)
        return view('home', compact('classes', 'stories', 'faculties'));
    }


    // Contact Us Page ===============================================================================================================================>
    public function contactUsView()
    {
        $classes = Classes::all();

        $faqs = FAQ::all();

        $abouts = AboutUs::all();

        if (auth()->guard('student')->check()) {
            $studentId = auth()->guard('student')->user()->id;

            $profile = StudentProfile::firstOrCreate(
                ['student_id' => $studentId],
                ['no_practise_test' => 0, 'total_practise_test_score' => 0]
            );

            return view('contact-us', compact('profile', 'classes', 'faqs', 'abouts'));
        } else {
            return view('contact-us', compact('classes', 'faqs', 'abouts'));
        }
    }

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

            // Mail to admin
            Mail::to('team.schoolwala@gmail.com')->send(new EnquirySend($validated));

            // Mail to email
            Mail::to($validated['email'])->send(new EnquiryRecieved($validated));


            return back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function waverRequestSubmit(Request $request)
    {
        try {
            // Validate input fields
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'p_name'   => 'required|string|max:255',
                'c_name'   => 'required|string|max:255',
                'c_age'    => 'required|integer',
                'email'    => 'required|email|max:255',
                'mobile'   => 'required|string|max:15',
                'address'  => 'required|string',
            ]);

            WaverRequest::create($validated);
            // Mail to admin
            Mail::to('team.schoolwala@gmail.com')->send(new WaiverReceived($validated));
            
            return back()->with('success', 'Your waiver request has been submitted successfully!');
        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }




    // About Us Page ===============================================================================================================================>
    public function aboutUsView()
    {
        $abouts = AboutUs::all();
        $faculties = Faculty::all();

        if (auth()->guard('student')->check()) {
            $studentId = auth()->guard('student')->user()->id;

            $profile = StudentProfile::firstOrCreate(
                ['student_id' => $studentId],
                ['no_practise_test' => 0, 'total_practise_test_score' => 0]
            );

            return view('about-us', compact('profile', 'abouts', 'faculties'));
        } else {
            return view('about-us', compact('abouts', 'faculties'));
        }
    }


    // Privacy Policy Page ===============================================================================================================================>
    public function privacyPolicyView()
    {

        if (auth()->guard('student')->check()) {
            $studentId = auth()->guard('student')->user()->id;

            $profile = StudentProfile::firstOrCreate(
                ['student_id' => $studentId],
                ['no_practise_test' => 0, 'total_practise_test_score' => 0]
            );

            return view('privacy-policy', compact('profile'));
        } else {
            return view('privacy-policy');
        }
    }





    // School Tuition Page ===============================================================================================================================>
    public function schoolTuitionView()
    {
        $classIds = Chapter::select('class_id')->distinct()->pluck('class_id');
        $classes = Classes::whereIn('id', $classIds)->get();

        if (auth()->guard('student')->check()) {
            $studentId = auth()->guard('student')->user()->id;

            $profile = StudentProfile::firstOrCreate(
                ['student_id' => $studentId],
                ['no_practise_test' => 0, 'total_practise_test_score' => 0]
            );

            // Authenticated student view
            return view('school-tuition', compact('classes', 'profile'));
        }

        // Guest view (no profile)
        return view('school-tuition', compact('classes'));
    }


    // API endpoint for class-wise subjects + chapters + description + faqs
    public function getClassCurriculum($classId)
    {
        $class = Classes::with([
            'subjects.chapters' => function ($q) use ($classId) {
                $q->where('class_id', $classId);
            },
            'faqs'
        ])->findOrFail($classId);

        return response()->json($class);
    }
    // School Tuition Page ===============================================================================================================================>


    // My Class Page ==============================================================================================================================>
    public function myClassView()
    {
        // Use 'student' guard
        $student = auth()->guard('student')->user();

        $class = Classes::with(['subjects.chapters'])
            ->where('id', $student->class_id)
            ->firstOrFail();

        $faqs = ClassFAQ::where('class_id', $student->class_id)->get();

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('my-class', compact('class', 'faqs', 'profile'));
    }

    public function myClassContent($classId, $subjectId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('my-class-content', compact('class', 'subject', 'profile'));
    }

    public function myPayment($classId, $subjectId, $chapterId = null)
    {
        $student = auth()->guard('student')->user();

        $class = Classes::with(['subjects.chapters.videos', 'fees'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);

        if (!$subject) {
            abort(404, 'Subject not found');
        }

        // Get chapter if chapterId is provided
        $chapter = null;
        if ($chapterId) {
            $chapter = $subject->chapters->find($chapterId);
        }

        // Fix: Get the FIRST fee record, not the collection
        $fees = $class->fees->first(); // Changed from $class->fees

        if (!$fees) {
            return redirect()->back()->with('error', 'No fees information available for this class.');
        }

        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $student->id],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('subscription.payment', compact('class', 'subject', 'profile', 'student', 'fees', 'chapter'));
    }

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

        $student = auth()->guard('student')->user();

        // Handle file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '_' . $student->id . '.' . $file->getClientOriginalExtension();
            $receiptPath = $file->storeAs('receipts', $filename, 'public');
        }

        // Check if subscriber already exists
        $existingSubscriber = Subscribers::where('student_id', $student->id)
            ->where('class_id', $request->class_id)
            ->where('fees_id', $request->fees_id)
            ->first();

        if ($existingSubscriber) {
            // Update existing subscriber
            $existingSubscriber->update([
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'status' => 'pending' // Pending admin verification
            ]);

            $message = 'Payment receipt updated successfully! Your subscription will be activated after admin verification.';
        } else {
            // Create new subscriber record
            Subscribers::create([
                'student_id' => $student->id,
                'class_id' => $request->class_id,
                'fees_id' => $request->fees_id,
                'reciptimage' => $receiptPath,
                'subscription_date' => now(),
                'expiry_date' => now()->addMonth(),
                'status' => 'pending'
            ]);

            $message = 'Payment submitted successfully! Your subscription will be activated after admin verification.';

            // Send email to admin
            $fee = \App\Models\Fees::find($request->fees_id);
            Mail::to('saklindeveloper@gmail.com')
            ->cc($student->email)
            ->send(new SubscriptionMailFromStudent([
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

        return redirect()->route('student.my-class-content', [
            'classId' => $request->class_id,
            'subjectId' => $request->subject_id
        ])->with('success', $message);
    }

    public function myChapterVideos($classId, $subjectId, $chapterId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);
        $chapter = $subject->chapters->find($chapterId);

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('my-chapter-videos', compact('class', 'subject', 'chapter', 'profile'));
    }

    public function myVideoPlay($classId, $subjectId, $chapterId, $videoId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);
        $chapter = $subject->chapters->find($chapterId);
        $video = $chapter->videos->find($videoId);

        $feedbacks = Feedback::where('video_id', $videoId)
            ->with('student')
            ->orderBy('id', 'desc')
            ->get();

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );


        return view('my-video-play', compact('class', 'subject', 'chapter', 'video', 'feedbacks', 'profile'));
    }

    public function myVideoPracticeTest($classId, $subjectId, $chapterId, $videoId)
    {
        $studentId = auth()->guard('student')->id(); // Get logged-in student via student guard

        $class = \App\Models\Classes::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $chapter = \App\Models\Chapter::findOrFail($chapterId);
        $video = \App\Models\Video::findOrFail($videoId);

        // Decode safely
        $questions = is_string($video->questions)
            ? json_decode($video->questions, true)
            : $video->questions;

        $answers = is_string($video->answers)
            ? json_decode($video->answers, true)
            : $video->answers;

        $correctAnswers = is_string($video->correct_answers)
            ? json_decode($video->correct_answers, true)
            : $video->correct_answers;

        // Handle cases where answers may be comma-separated strings
        if (!is_array($answers)) {
            $answers = array_map('trim', explode(',', $answers));
        }

        // Normalize each question’s answers to arrays
        foreach ($answers as &$ans) {
            if (is_string($ans)) {
                $decoded = json_decode($ans, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $ans = $decoded;
                } else {
                    $ans = array_map('trim', explode(',', $ans));
                }
            }
        }

        // Fetch already submitted test for this student & video
        $submittedTest = \App\Models\StudentTest::where('student_id', $studentId)
            ->where('video_id', $videoId)
            ->first();

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('my-video-practice-test', compact(
            'class',
            'subject',
            'chapter',
            'video',
            'questions',
            'answers',
            'correctAnswers',
            'submittedTest',
            'studentId',
            'profile'
        ));
    }

    public function  myVideoPracticeTestResult($classId, $subjectId, $chapterId, $videoId)
    {
        $studentId = auth()->guard('student')->id(); // Get logged-in student via student guard

        $class = \App\Models\Classes::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $chapter = \App\Models\Chapter::findOrFail($chapterId);
        $video = \App\Models\Video::findOrFail($videoId);

        // Decode safely
        $questions = is_string($video->questions)
            ? json_decode($video->questions, true)
            : $video->questions;

        $answers = is_string($video->answers)
            ? json_decode($video->answers, true)
            : $video->answers;

        $correctAnswers = is_string($video->correct_answers)
            ? json_decode($video->correct_answers, true)
            : $video->correct_answers;

        // Handle cases where answers may be comma-separated strings
        if (!is_array($answers)) {
            $answers = array_map('trim', explode(',', $answers));
        }

        // Normalize each question’s answers to arrays
        foreach ($answers as &$ans) {
            if (is_string($ans)) {
                $decoded = json_decode($ans, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $ans = $decoded;
                } else {
                    $ans = array_map('trim', explode(',', $ans));
                }
            }
        }

        // Fetch already submitted test for this student & video
        $submittedTest = \App\Models\StudentTest::where('student_id', $studentId)
            ->where('video_id', $videoId)
            ->first();

        $studentId = auth()->guard('student')->user()->id;
        $profile = StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        return view('my-video-test-result', compact(
            'class',
            'subject',
            'chapter',
            'video',
            'questions',
            'answers',
            'correctAnswers',
            'submittedTest',
            'studentId',
            'profile'
        ));
    }


    public function myVideoPracticeTestSubmit(Request $request, $studentId, $videoId)
    {
        // Validate input
        $request->validate([
            'answers' => 'required|array',
        ]);

        $studentAnswers = $request->input('answers');

        // Fetch video and correct answers
        $video = \App\Models\Video::findOrFail($videoId);

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
        $studentTest = \App\Models\StudentTest::updateOrCreate(
            [
                'student_id' => $studentId,
                'video_id' => $videoId,
            ],
            [
                'student_answers' => $studentAnswers,
                'score' => $score,
            ]
        );

        // Update student profile
        $studentProfile = \App\Models\StudentProfile::firstOrCreate(
            ['student_id' => $studentId],
            ['no_practise_test' => 0, 'total_practise_test_score' => 0]
        );

        // Increment the number of tests and add the score
        $studentProfile->increment('no_practise_test'); // +1
        $studentProfile->increment('total_practise_test_score', $score); // + current score

        return response()->json([
            'status' => 'success',
            'score' => $score,
            'message' => 'Test submitted successfully',
            'student_test' => $studentTest
        ]);
    }


    public function myVideoPlayFeedbackSubmit(Request $request)
    {

        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'video_id' => 'required|integer|exists:videos,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
        ]);

        $studentId = $request->input('student_id');
        $videoId = $request->input('video_id');
        $rating = $request->input('rating');
        $feedback = $request->input('feedback');

        $video = Video::findOrFail($videoId);

        Feedback::create([
            'student_id' => $studentId,
            'video_id' => $videoId,
            'rating' => $rating,
            'feedback' => $feedback,
        ]);

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    public function myVideoLikesSubmit(Request $request)
    {
        $request->validate([
            'video_id' => 'required|integer|exists:videos,id',
        ]);

        $videoId = $request->input('video_id');
        $video = Video::findOrFail($videoId);

        // Increment likes by 1
        $video->increment('likes');

        return redirect()->back()->with('success', 'Thank you dear for your like! 💖');
    }












    // My Class Page ==============================================================================================================================>
}

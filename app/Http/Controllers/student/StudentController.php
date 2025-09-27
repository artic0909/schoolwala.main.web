<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Classes;
use App\Models\ClassFAQ;
use App\Models\PasswordReset;
use App\Models\Student;
use App\Models\Subject;
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
            Student::create([
                'class_id'     => $request->class_id,
                'student_id'   => $studentId,
                'student_name' => $request->student_name,
                'parent_name'  => $request->parent_name,
                'email'        => $request->email,
                'mobile'       => $request->mobile,
                'age'          => $request->age,
                'password'     => Hash::make($request->password),
            ]);

            return redirect()->route('student.student-login')
                ->with('success', 'Student registered successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Profile View
    public function studentProfileView()
    {
        return view('my-profile');
    }





    // Home Page ================================================================================================================================>



    // School Tuition Page ===============================================================================================================================>
    public function schoolTuitionView()
    {
        $classIds = Chapter::select('class_id')->distinct()->pluck('class_id');
        $classes = Classes::whereIn('id', $classIds)->get();

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

        return view('my-class', compact('class', 'faqs'));
    }

    public function myClassContent($classId, $subjectId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);


        return view('my-class-content', compact('class', 'subject'));
    }

    public function myChapterVideos($classId, $subjectId, $chapterId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);
        $chapter = $subject->chapters->find($chapterId);

        return view('my-chapter-videos', compact('class', 'subject', 'chapter'));
    }

    public function myVideoPlay($classId, $subjectId, $chapterId, $videoId)
    {
        $class = Classes::with(['subjects.chapters.videos'])
            ->where('id', $classId)
            ->firstOrFail();

        $subject = $class->subjects->find($subjectId);
        $chapter = $subject->chapters->find($chapterId);
        $video = $chapter->videos->find($videoId);

        return view('my-video-play', compact('class', 'subject', 'chapter', 'video'));
    }

    // My Class Page ==============================================================================================================================>
}

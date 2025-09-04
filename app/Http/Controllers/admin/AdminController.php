<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Chapter;
use App\Models\Classes;
use App\Models\ClassFAQ;
use App\Models\Subject;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    // Auth Start =========================================================================================================================>
    public function adminRegisterView()
    {

        return view('admin.admin-register');
    }

    public function adminRegister(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ], [

            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password and confirm password do not match.',
        ]);

        Admin::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        return redirect()->route('admin.admin-login')->with('success', 'Registration successful, please login.');
    }

    public function adminLoginView()
    {

        return view('admin.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email or Username is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Try login with email
        if (Auth::guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.admin-dashboard')->with('success', 'Login successful!');
        }


        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function adminLogout(Request $request)
    {

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.admin-login')->with('success', 'Logout successful!');
    }

    public function adminProfileView()
    {

        return view('admin.admin-profile');
    }

    public function adminProfileUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.admin-profile')->with('success', 'Profile updated successfully!');
    }

    public function adminForgetPassView()
    {

        return view('admin.admin-forget-password');
    }
    public function adminForgetOtpVerifyView()
    {

        return view('admin.admin-forget-verify-otp');
    }

    public function adminPageErrorView()
    {

        return view('admin.page-error');
    }
    // Auth End ===========================================================================================================================>


    // Dashboard Start =========================================================================================================================>
    public function adminDashboardView()
    {

        return view('admin.admin-dashboard');
    }
    // Dashboard End ==========================================================================================================================>


    // SEO Start =========================================================================================================================>
    public function adminSeoHomePageView()
    {

        return view('admin.admin-seo-home-page');
    }

    public function adminSeoSchoolTuitionView()
    {

        return view('admin.admin-seo-school-tuition');
    }

    public function adminSeoMyClassView()
    {

        return view('admin.admin-seo-my-class');
    }

    public function adminSeoContactView()
    {

        return view('admin.admin-seo-contact');
    }

    public function adminSeoAboutusView()
    {

        return view('admin.admin-seo-aboutus');
    }

    public function adminSeoPrivacyPolicyView()
    {

        return view('admin.admin-seo-privacy-policy');
    }

    // SEO End ==========================================================================================================================>

    // Front Page Start =========================================================================================================================>
    public function adminUploadFacultyView()
    {

        return view('admin.admin-upload-faculties');
    }

    public function adminAboutusView()
    {

        return view('admin.admin-aboutus');
    }

    public function adminStoryTagsView()
    {

        return view('admin.admin-story-tags');
    }

    public function adminStoriesView()
    {

        return view('admin.admin-stories');
    }

    public function adminFaqView()
    {

        return view('admin.admin-faq');
    }
    // Front Page End ==========================================================================================================================>

    // Course Related Start =========================================================================================================================>
    public function adminClassesView()
    {
        $classes = Classes::all();

        return view('admin.admin-classes', compact('classes'));
    }


    public function addClass(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:classes,name',
                'description' => 'required|string|max:255',
            ]);

            $class = new Classes();
            $class->name = $request->name;
            $class->description = $request->description;
            $class->slug = Str::slug($request->name);
            $class->save();

            return redirect()->route('admin.admin-classes')
                ->with('success', 'Class created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-classes')
                ->with('error', 'Failed to create class: ' . $e->getMessage());
        }
    }


    public function updateClass(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:classes,name,' . $id,
                'description' => 'required|string|max:255',
            ]);

            $class = Classes::findOrFail($id);
            $class->name = $request->name;
            $class->description = $request->description;
            $class->slug = Str::slug($request->name);
            $class->save();

            return redirect()->route('admin.admin-classes')
                ->with('success', 'Class updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-classes')
                ->with('error', 'Failed to update class: ' . $e->getMessage());
        }
    }


    public function deleteClass($id)
    {
        try {
            $class = Classes::findOrFail($id);
            $class->delete();

            return redirect()->route('admin.admin-classes')
                ->with('success', 'Class deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-classes')
                ->with('error', 'Failed to delete class: ' . $e->getMessage());
        }
    }






    public function adminClassFaqsView()
    {
        $classes = Classes::all();
        $classFaqs = ClassFAQ::with('class')->get();
        return view('admin.admin-class-faqs', compact('classes', 'classFaqs'));
    }

    public function addClassFaq(Request $request)
    {
        try {
            $request->validate([
                'class_id'  => 'required|exists:classes,id',
                'question'  => 'required|string|max:500',
                'answer'    => 'required|string|max:2000',
            ]);

            $faq = new ClassFAQ();
            $faq->class_id = $request->class_id;
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->save();

            return redirect()->back()->with('success', 'FAQ added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add FAQ: ' . $e->getMessage());
        }
    }

    public function updateClassFaq(Request $request, $id)
    {
        try {
            $request->validate([
                'class_id'  => 'required|exists:classes,id',
                'question'  => 'required|string|max:500',
                'answer'    => 'required|string|max:2000',
            ]);

            $faq = ClassFAQ::findOrFail($id);
            $faq->class_id = $request->class_id;
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->save();

            return redirect()->back()->with('success', 'FAQ updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update FAQ: ' . $e->getMessage());
        }
    }

    public function deleteClassFaq($id)
    {
        try {
            $faq = ClassFAQ::findOrFail($id);
            $faq->delete();

            return redirect()->back()->with('success', 'FAQ deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete FAQ: ' . $e->getMessage());
        }
    }






    public function adminSubjectsView()
    {
        $classes = Classes::all();
        $subjects = Subject::with('class')->get();
        return view('admin.admin-subjects', compact('classes', 'subjects'));
    }

    public function addSubject(Request $request)
    {
        try {
            $request->validate([
                'class_id'     => 'required|exists:classes,id',
                'name'         => 'required|string|max:255',
                'bg_color_txt' => 'required|string|max:50',
                'icon_txt'     => 'required|string|max:100',
            ]);

            $subject = new Subject();
            $subject->class_id     = $request->class_id;
            $subject->name         = $request->name;
            $subject->bg_color_txt = $request->bg_color_txt;
            $subject->icon_txt     = $request->icon_txt;
            $subject->slug         = Str::slug($request->name);
            $subject->save();

            return redirect()->back()->with('success', 'Subject added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add subject: ' . $e->getMessage());
        }
    }

    public function updateSubject(Request $request, $id)
    {
        try {
            $request->validate([
                'class_id'     => 'required|exists:classes,id',
                'name'         => 'required|string|max:255',
                'bg_color_txt' => 'required|string|max:50',
                'icon_txt'     => 'required|string|max:100',
            ]);

            $subject = Subject::findOrFail($id);
            $subject->class_id     = $request->class_id;
            $subject->name         = $request->name;
            $subject->bg_color_txt = $request->bg_color_txt;
            $subject->icon_txt     = $request->icon_txt;
            $subject->slug         = Str::slug($request->name);
            $subject->save();

            return redirect()->back()->with('success', 'Subject updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update subject: ' . $e->getMessage());
        }
    }

    public function deleteSubject($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return redirect()->back()->with('success', 'Subject deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete subject: ' . $e->getMessage());
        }
    }





    public function adminChaptersView()
    {
        $classes = Classes::all();
        $subjects = Subject::with('class')->get();
        $chapters = Chapter::with('subject')->get();

        return view('admin.admin-chapters', compact('classes', 'subjects', 'chapters'));
    }

    public function getSubjects($class_id)
    {
        $subjects = Subject::where('class_id', $class_id)->get();
        return response()->json($subjects);
    }


    public function addChapter(Request $request)
    {
        try {
            $request->validate([
                'class_id'   => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'name'       => 'required|string|max:255|unique:chapters,name',
            ]);

            $chapter = new Chapter();
            $chapter->class_id   = $request->class_id;
            $chapter->subject_id = $request->subject_id;
            $chapter->name       = $request->name;
            $chapter->slug       = Str::slug($request->name);
            $chapter->save();

            return redirect()->back()->with('success', 'Chapter added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add chapter: ' . $e->getMessage());
        }
    }

    public function updateChapter(Request $request, $id)
    {
        try {
            $request->validate([
                'class_id'   => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'name'       => 'required|string|max:255|unique:chapters,name,' . $id,
            ]);

            $chapter = Chapter::findOrFail($id);
            $chapter->class_id   = $request->class_id;
            $chapter->subject_id = $request->subject_id;
            $chapter->name       = $request->name;
            $chapter->slug       = Str::slug($request->name);
            $chapter->save();

            return redirect()->back()->with('success', 'Chapter updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update chapter: ' . $e->getMessage());
        }
    }

    public function deleteChapter($id)
    {
        try {
            $chapter = Chapter::findOrFail($id);
            $chapter->delete();

            return redirect()->back()->with('success', 'Chapter deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete chapter: ' . $e->getMessage());
        }
    }





    public function adminVideosView()
    {
        $classes = Classes::all();
        $subjects = Subject::with('class')->get();
        $chapters = Chapter::with('subject')->get();
        $videos = Video::with('class', 'subject', 'chapter')->get();
        return view('admin.admin-videos', compact('classes', 'subjects', 'chapters', 'videos'));
    }

    public function getChapters($subjectId)
    {
        $chapters = Chapter::where('subject_id', $subjectId)->get();
        return response()->json($chapters);
    }

    public function addVideo(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
            'video_title' => 'required|string|max:255',
            'video_type' => 'required|in:paid,free',
            'video_link' => 'nullable|url',
            'video_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Generate slug
            $slug = Str::slug($request->video_title);

            $thumbnail = null;
            if ($request->hasFile('video_thumbnail')) {
                $thumbnail = $request->file('video_thumbnail')->store('thumbnails', 'public');
            }

            // Save video
            Video::create([
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'chapter_id' => $request->chapter_id,
                'video_title' => $request->video_title,
                'slug' => $slug,
                'video_type' => $request->video_type,
                'video_link' => $request->video_link,
                'video_description' => $request->video_description,
                'video_thumbnail' => $thumbnail,
                'questions' => $request->questions ? json_encode($request->questions) : null,
                'answers' => $request->answers ? json_encode($request->answers) : null,
                'correct_answers' => $request->correct_answers ? json_encode($request->correct_answers) : null,
            ]);

            return redirect()->back()->with('success', 'Video added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function updateVideo(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        // update normal video fields if present
        $video->video_title = $request->video_title ?? $video->video_title;
        $video->video_type = $request->video_type ?? $video->video_type;
        $video->video_link = $request->video_link ?? $video->video_link;
        $video->video_description = $request->video_description ?? $video->video_description;

        // update practice test if provided
        if ($request->has('questions')) {
            $video->questions = json_encode(array_values($request->questions));
            $video->answers = json_encode(array_values($request->answers));
            $video->correct_answers = json_encode(array_values($request->correct_answers));
        }

        $video->save();

        return redirect()->back()->with('success', 'Video updated successfully!');
    }


    public function putPracticeTestOnVideoID(Request $request, $id) {}


    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully'], 200);
    }

    public function adminVideoFeedbacksView()
    {

        return view('admin.admin-video-feedbacks');
    }
    // Course Related End ==========================================================================================================================>

    // Students Related Start =========================================================================================================================>
    public function adminStudentsView()
    {

        return view('admin.admin-students');
    }

    public function adminTuitionFeesView()
    {

        return view('admin.admin-tuition-fees');
    }

    public function adminFeesReportView()
    {

        return view('admin.admin-fees-report');
    }
    // Students Related End ==========================================================================================================================>

    // Enquiry Start =========================================================================================================================>
    public function adminEnquiryView()
    {

        return view('admin.admin-enquiry');
    }
    // Enquiry End ==========================================================================================================================>

    // Waver Start =========================================================================================================================>
    public function adminWaverProfilesView()
    {

        return view('admin.admin-waver-profiles');
    }

    public function adminWaverRequestView()
    {

        return view('admin.admin-wavers-request');
    }
    // Waver End ==========================================================================================================================>

}

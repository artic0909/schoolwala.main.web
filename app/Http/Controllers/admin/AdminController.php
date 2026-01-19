<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Mail\SubscriptionActivateInactiveMail;
use App\Mail\WaiverAcceptMail;
use App\Mail\WaiverMailBack;
use App\Mail\WaiverRejectMail;
use App\Models\AboutUs;
use App\Models\Admin;
use App\Models\Chapter;
use App\Models\Classes;
use App\Models\ClassFAQ;
use App\Models\ContactUs;
use App\Models\Faculty;
use App\Models\FAQ;
use App\Models\Feedback;
use App\Models\Fees;
use App\Models\Story;
use App\Models\StoryTag;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Subscribers;
use App\Models\Video;
use App\Models\WaverRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

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

        $classes = Classes::all();
        $faculties = Faculty::all();

        return view('admin.admin-upload-faculties', compact('classes', 'faculties'));
    }

    public function adminAddFaculty(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:faculties,email',
            'mobile' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_fac' => 'nullable|string',
            'assigned_classes' => 'required|array',
            'assigned_classes.*' => 'exists:classes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check the form.');
        }

        try {

            $month = date('m');
            $year = date('y');
            $prefix = "{$month}{$year}-SW-FAC-";


            $lastFaculty = Faculty::where('fac_id', 'like', "{$prefix}%")
                ->orderBy('id', 'desc')
                ->first();

            if ($lastFaculty) {
                $lastNumber = (int) Str::afterLast($lastFaculty->fac_id, '-');
                $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '01';
            }

            $facId = $prefix . $nextNumber;


            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('faculties', 'public');
            }

            Faculty::create([
                'fac_id' => $facId,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'about_fac' => $request->about_fac,
                'image' => $imagePath,
                'assigned_classes' => $request->assigned_classes,
            ]);

            return redirect()->back()->with('success', 'Faculty added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEditFaculty(Request $request)
    {
        $request->validate([
            'fac_id' => 'exists:faculties,id',
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'mobile' => 'string|max:20',
            'assigned_classes' => 'nullable|array',
            'assigned_classes.*' => 'exists:classes,id',
            'about_fac' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        try {
            $faculty = Faculty::findOrFail($request->fac_id);

            $faculty->name = $request->name;
            $faculty->email = $request->email;
            $faculty->mobile = $request->mobile;
            $faculty->about_fac = $request->about_fac;
            $faculty->assigned_classes = $request->assigned_classes ?? [];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('faculties', 'public');
                $faculty->image = $imagePath;
            }


            $faculty->save();

            return back()->with('success', 'Faculty updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function adminDeleteFaculty($id)
    {

        try {
            $faculty = Faculty::findOrFail($id);
            $faculty->delete();
            return back()->with('success', 'Faculty deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }






    public function adminAboutusView()
    {

        $aboutus = AboutUs::first();

        return view('admin.admin-aboutus', compact('aboutus'));
    }

    public function adminAddAboutus(Request $request)
    {

        try {
            $request->validate([
                'happy_kids' => 'required|string',
                'fun_lessons' => 'required|string',
                'satisfaction' => 'required|string',
                'cm_email' => 'required|email',
                'cm_mobile' => 'required|string',
                'cm_address' => 'required|string',
                'our_story' => 'required|string',
                'our_vision' => 'required|string',
                'bold_message' => 'required|string',
            ]);

            AboutUs::create([
                'happy_kids' => $request->happy_kids,
                'fun_lessons' => $request->fun_lessons,
                'satisfaction' => $request->satisfaction,
                'cm_email' => $request->cm_email,
                'cm_mobile' => $request->cm_mobile,
                'cm_address' => $request->cm_address,
                'our_story' => $request->our_story,
                'our_vision' => $request->our_vision,
                'bold_message' => $request->bold_message,
            ]);

            return redirect()->back()->with('success', 'About Us added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEditAboutus(Request $request)
    {

        $request->validate([
            'happy_kids' => 'required|string',
            'fun_lessons' => 'required|string',
            'satisfaction' => 'required|string',
            'cm_email' => 'required|email',
            'cm_mobile' => 'required|string',
            'cm_address' => 'required|string',
            'our_story' => 'required|string',
            'our_vision' => 'required|string',
            'bold_message' => 'required|string',
        ]);

        try {
            $aboutus = AboutUs::first();
            $aboutus->happy_kids = $request->happy_kids;
            $aboutus->fun_lessons = $request->fun_lessons;
            $aboutus->satisfaction = $request->satisfaction;
            $aboutus->cm_email = $request->cm_email;
            $aboutus->cm_mobile = $request->cm_mobile;
            $aboutus->cm_address = $request->cm_address;
            $aboutus->our_story = $request->our_story;
            $aboutus->our_vision = $request->our_vision;
            $aboutus->bold_message = $request->bold_message;
            $aboutus->save();

            return redirect()->back()->with('success', 'About Us updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminDeleteAboutus(Request $request)
    {

        try {
            $aboutus = AboutUs::findOrFail($request->id);
            $aboutus->delete();
            return redirect()->back()->with('success', 'About Us deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }






    public function adminStoryTagsView()
    {
        $tags = StoryTag::all();

        return view('admin.admin-story-tags', compact('tags'));
    }

    public function adminAddStoryTags(Request $request)
    {
        // Implementation for adding story tags
        try {
            $request->validate([
                'tag_name' => 'required|string|max:255|unique:story_tags,tag_name',
            ]);

            $tag = new StoryTag();
            $tag->tag_name = $request->tag_name;
            $tag->slug = Str::slug($request->tag_name);
            $tag->save();

            return redirect()->route('admin.admin-story-tags')
                ->with('success', 'Story Tag created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-story-tags')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEditStoryTags(Request $request)
    {
        $request->validate([
            'tag_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('story_tags', 'tag_name')->ignore($request->id),
            ],
        ]);

        try {
            $tag = StoryTag::findOrFail($request->id);
            $tag->tag_name = $request->tag_name;
            $tag->slug = Str::slug($request->tag_name);
            $tag->save();

            return redirect()->route('admin.admin-story-tags')
                ->with('success', 'Story Tag updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-story-tags')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminDeleteStoryTags(Request $request)
    {
        // Implementation for deleting story tags
        try {
            $tag = StoryTag::findOrFail($request->id);
            $tag->delete();
            return redirect()->route('admin.admin-story-tags')
                ->with('success', 'Story Tag deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-story-tags')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }






    public function adminStoriesView()
    {
        $classes = Classes::all();
        $tags = StoryTag::all();
        $stories = Story::with('class', 'storyTag')->get();

        return view('admin.admin-stories', compact('classes', 'tags', 'stories'));
    }

    public function adminAddStory(Request $request)
    {
        try {
            $request->validate([
                'class_id' => 'required|exists:classes,id',
                'story_tag_id' => 'required|exists:story_tags,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'name' => 'required|string',
                'feedback' => 'required|string',
            ]);

            $story = new Story();
            $story->class_id = $request->class_id;
            $story->story_tag_id = $request->story_tag_id;
            $story->name = $request->name;
            $story->feedback = $request->feedback;

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('stories', 'public');

                $story->image = $imagePath;
            }


            $story->save();

            return redirect()->route('admin.admin-stories')
                ->with('success', 'Story created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-stories')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }


    public function adminEditStory(Request $request, $id)
    {
        try {
            $request->validate([
                'class_id' => 'required|exists:classes,id',
                'story_tag_id' => 'required|exists:story_tags,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'name' => 'required|string',
                'feedback' => 'required|string',
            ]);

            $story = Story::findOrFail($id);

            $story->class_id = $request->class_id;
            $story->story_tag_id = $request->story_tag_id;
            $story->name = $request->name;
            $story->feedback = $request->feedback;

            // handle image upload
            if ($request->hasFile('image')) {
                // delete old file if exists
                if (!empty($story->image) && Storage::disk('public')->exists($story->image)) {
                    Storage::disk('public')->delete($story->image);
                }

                // store new file
                $imagePath = $request->file('image')->store('stories', 'public');
                $story->image = $imagePath;
            }

            $story->save();

            return redirect()->route('admin.admin-stories')
                ->with('success', 'Story updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-stories')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminDeleteStory(Request $request, $id)
    {
        try {
            $story = Story::findOrFail($id);
            $story->delete();
            return redirect()->route('admin.admin-stories')
                ->with('success', 'Story deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-stories')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }






    public function adminFaqView()
    {
        $faqs = FAQ::all();

        return view('admin.admin-faq', compact('faqs'));
    }

    public function adminAddFaq(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required|string|max:500',
                'answer' => 'required|string',
            ]);

            $faq = new FAQ();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->slug = Str::slug(substr($request->question, 0, 50)) . '-' . uniqid();
            $faq->save();

            return redirect()->route('admin.admin-faq')
                ->with('success', 'FAQ added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-faq')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEditFaq(Request $request, $id)
    {
        try {
            $request->validate([
                'question' => 'required|string|max:500',
                'answer' => 'required|string',
            ]);

            $faq = FAQ::findOrFail($id);
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->slug = Str::slug(substr($request->question, 0, 50)) . '-' . uniqid();
            $faq->save();

            return redirect()->route('admin.admin-faq')
                ->with('success', 'FAQ updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-faq')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminDeleteFaq($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();

            return redirect()->route('admin.admin-faq')
                ->with('success', 'FAQ deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.admin-faq')
                ->with('error', 'Something went wrong. ' . $e->getMessage());
        }
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
                'class_id' => 'required|exists:classes,id',
                'question' => 'required|string|max:500',
                'answer' => 'required|string|max:2000',
            ]);

            $faq = new ClassFAQ();
            $faq->class_id = $request->class_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
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
                'class_id' => 'required|exists:classes,id',
                'question' => 'required|string|max:500',
                'answer' => 'required|string|max:2000',
            ]);

            $faq = ClassFAQ::findOrFail($id);
            $faq->class_id = $request->class_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
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
                'class_id' => 'required|exists:classes,id',
                'name' => 'required|string|max:255',
                'bg_color_txt' => 'required|string|max:50',
                'icon_txt' => 'required|string|max:100',
            ]);

            $subject = new Subject();
            $subject->class_id = $request->class_id;
            $subject->name = $request->name;
            $subject->bg_color_txt = $request->bg_color_txt;
            $subject->icon_txt = $request->icon_txt;
            $subject->slug = Str::slug($request->name);
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
                'class_id' => 'required|exists:classes,id',
                'name' => 'required|string|max:255',
                'bg_color_txt' => 'required|string|max:50',
                'icon_txt' => 'required|string|max:100',
            ]);

            $subject = Subject::findOrFail($id);
            $subject->class_id = $request->class_id;
            $subject->name = $request->name;
            $subject->bg_color_txt = $request->bg_color_txt;
            $subject->icon_txt = $request->icon_txt;
            $subject->slug = Str::slug($request->name);
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
                'class_id' => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'name' => 'required|string|max:255',
            ]);

            $chapter = new Chapter();
            $chapter->class_id = $request->class_id;
            $chapter->subject_id = $request->subject_id;
            $chapter->name = $request->name;
            $chapter->slug = Str::slug($request->name);
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
                'class_id' => 'required|exists:classes,id',
                'subject_id' => 'required|exists:subjects,id',
                'name' => 'required|string|max:255',
            ]);

            $chapter = Chapter::findOrFail($id);
            $chapter->class_id = $request->class_id;
            $chapter->subject_id = $request->subject_id;
            $chapter->name = $request->name;
            $chapter->slug = Str::slug($request->name);
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





    public function adminVideosView(Request $request)
    {
        $classes = Classes::all();

        $classId = $request->input('class');
        $subjectId = $request->input('subject');
        $chapterId = $request->input('chapter');

        $query = Video::with('class', 'subject', 'chapter');

        if ($classId) {
            $query->where('class_id', $classId);
        }
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        if ($chapterId) {
            $query->where('chapter_id', $chapterId);
        }

        $videos = $query->orderBy('id', 'desc')->paginate(10);
        $videos->appends($request->all());

        $subjects = $classId ? Subject::where('class_id', $classId)->get() : collect();
        $chapters = $subjectId ? Chapter::where('subject_id', $subjectId)->get() : collect();

        return view('admin.admin-videos', compact('classes', 'subjects', 'chapters', 'videos', 'classId', 'subjectId', 'chapterId'));
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
            // 'note_link' => 'nullable|url',
            // 'duration' => 'required|string|max:255',
            // 'views' => 'required|string|max:255',
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
                'note_link' => $request->note_link,
                'duration' => $request->duration,
                'views' => $request->views,
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
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
            'video_title' => 'required|string|max:255',
            'video_type' => 'required|in:paid,free',
            'video_link' => 'nullable|url',
            'video_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'note_link' => 'nullable|url',
        ]);

        try {
            $video = Video::findOrFail($id);

            $slug = Str::slug($request->video_title);

            // Handle thumbnail upload or keep old one
            $thumbnail = $video->video_thumbnail;
            if ($request->hasFile('video_thumbnail')) {

                // Delete old thumbnail if exists
                if ($video->video_thumbnail && file_exists(public_path('storage/' . $video->video_thumbnail))) {
                    unlink(public_path('storage/' . $video->video_thumbnail));
                }

                $thumbnail = $request->file('video_thumbnail')->store('thumbnails', 'public');
            }

            // Build base update array
            $updateData = [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'chapter_id' => $request->chapter_id,
                'video_title' => $request->video_title,
                'slug' => $slug,
                'video_type' => $request->video_type,
                'video_link' => $request->video_link,
                'note_link' => $request->note_link,
                'duration' => $request->duration,
                'views' => $request->views,
                'video_description' => $request->video_description,
                'video_thumbnail' => $thumbnail,
            ];

            // Only update these if they exist in request
            if ($request->has('questions')) {
                $updateData['questions'] = json_encode($request->questions);
            }
            if ($request->has('answers')) {
                $updateData['answers'] = json_encode($request->answers);
            }
            if ($request->has('correct_answers')) {
                $updateData['correct_answers'] = json_encode($request->correct_answers);
            }

            // Update video record
            $video->update($updateData);

            return redirect()->back()->with('success', 'Video updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }




    public function putPracticeTestOnVideoID(Request $request, $id)
    {
        // Validate
        $request->validate([
            'questions' => 'array',
            'answers' => 'array',
            'correct_answers' => 'array',
        ]);

        // Find video
        $video = Video::findOrFail($id);

        // Convert to JSON (removing empty values)
        $questions = array_filter($request->questions ?? []);
        $answers = array_filter($request->answers ?? []);
        $correct = array_filter($request->correct_answers ?? []);

        // Save as JSON
        $video->questions = json_encode(array_values($questions));
        $video->answers = json_encode(array_values($answers));
        $video->correct_answers = json_encode(array_values($correct));

        $video->save();

        return back()->with('success', 'Practice test saved successfully!');
    }


    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->back()->with('success', 'Video deleted successfully!');
    }

    public function adminVideoFeedbacksView()
    {

        $videoFeedbacks = Feedback::with('video.class', 'video.subject', 'video.chapter', 'student')->orderBy('id', 'desc')->paginate(8);

        return view('admin.admin-video-feedbacks', compact('videoFeedbacks'));
    }

    public function editVideoFeedback(Request $request, $id)
    {
        $request->validate([
            'rating' => 'nullable|string',
            'feedback' => 'nullable|string',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->rating = $request->rating;
        $feedback->feedback = $request->feedback;
        $feedback->save();
        return redirect()->back()->with('success', 'Feedback updated successfully!');
    }

    public function deleteVideoFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }
    // Course Related End ==========================================================================================================================>

    // Students Related Start =========================================================================================================================>
    public function adminStudentsView(Request $request)
    {

        $classes = Classes::all();
        $classId = $request->input('class_id');
        $query = Student::with('classes')->orderBy('id', 'desc');

        if (!empty($classId)) {
            $query->where('class_id', $classId);
        }

        $students = $query->paginate(8);
        $students->appends($request->all());

        return view('admin.admin-students', compact('students', 'classes', 'classId'));
    }

    public function adminAddStudent(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|in:regular,waiver',
                'parent_name' => 'required|string|max:255',
                'student_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'mobile' => 'required|string|max:20',
                'age' => 'required|string|max:3',
                'class_id' => 'required|exists:classes,id',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // ----- AUTO GENERATE STUDENT ID -----
            $year = date('y'); // e.g., "25" for 2025
            $prefix = "SW";

            // Get class name (e.g., "Class 8" → "CLASS8")
            $class = Classes::findOrFail($request->class_id);
            $className = strtoupper(str_replace(' ', '', $class->name));

            // Find the last student for this class
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

            // ----- SAVE STUDENT -----
            $student = new Student();
            $student->type = $request->type;
            $student->parent_name = $request->parent_name;
            $student->student_name = $request->student_name;
            $student->email = $request->email;
            $student->mobile = $request->mobile;
            $student->age = $request->age;
            $student->class_id = $request->class_id;
            $student->student_id = $studentId;
            $student->password = Hash::make($request->password);
            $student->save();

            return redirect()->back()->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEditStudent(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => 'required|in:regular,waiver',
                'parent_name' => 'required|string|max:255',
                'student_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $id,
                'mobile' => 'required|string|max:20',
                'age' => 'required|string|max:3',
                'class_id' => 'required|exists:classes,id',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $student = Student::findOrFail($id);

            // Check if class_id changed
            if ($student->class_id != $request->class_id) {
                // ----- AUTO GENERATE STUDENT ID ----- 
                $year = date('y'); // e.g., "25" for 2025
                $prefix = "SW";

                $class = Classes::findOrFail($request->class_id);
                $className = strtoupper(str_replace(' ', '', $class->name));

                $lastStudent = Student::where('class_id', $request->class_id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastStudent && preg_match('/-(\d+)$/', $lastStudent->student_id, $matches)) {
                    $lastNumber = (int) $matches[1];
                } else {
                    $lastNumber = 0;
                }

                $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

                $student->student_id = "{$year}-{$prefix}-{$className}-{$nextNumber}";
            }

            // ----- UPDATE STUDENT ----- 
            $student->type = $request->type;
            $student->parent_name = $request->parent_name;
            $student->student_name = $request->student_name;
            $student->email = $request->email;
            $student->mobile = $request->mobile;
            $student->age = $request->age;
            $student->class_id = $request->class_id;

            if (!empty($request->password)) {
                $student->password = Hash::make($request->password);
            }

            $student->save();

            return redirect()->back()->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminDeleteStudent($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->back()->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminStudentTypeChangeIntoWaiver(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->type === 'regular') {
                $student->type = 'waiver';
                $student->save();

                return redirect()->back()->with('success', 'Student type changed to waiver successfully!');
            } else {
                return redirect()->back()->with('error', 'Only regular students can be changed to waiver.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminStudentTypeChangeIntoRegular(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->type === 'waiver') {
                $student->type = 'regular';
                $student->save();

                return redirect()->back()->with('success', 'Student type changed to regular successfully!');
            } else {
                return redirect()->back()->with('error', 'Only waiver students can be changed to regular.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminTuitionFeesView()
    {
        $classes = Classes::all();

        $feeses = Fees::with('class')->get();

        return view('admin.admin-tuition-fees', compact('classes', 'feeses'));
    }

    public function adminTuitionFeesAdd(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric',
            'qrimage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $qrimagePath = null;
        if ($request->hasFile('qrimage')) {
            $qrimagePath = $request->file('qrimage')->store('fees_qr', 'public');
        }

        Fees::create([
            'class_id' => $request->class_id,
            'amount' => $request->amount,
            'qrimage' => $qrimagePath,
        ]);

        return back()->with('success', 'Fees added successfully');
    }

    public function adminTuitionFeesUpdate(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric',
            'qrimage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fees = Fees::findOrFail($id);

        if ($request->hasFile('qrimage')) {
            // Delete old image
            if ($fees->qrimage && Storage::disk('public')->exists($fees->qrimage)) {
                Storage::disk('public')->delete($fees->qrimage);
            }

            $fees->qrimage = $request->file('qrimage')->store('fees_qr', 'public');
        }

        $fees->class_id = $request->class_id;
        $fees->amount = $request->amount;
        $fees->save();

        return back()->with('success', 'Fees updated successfully');
    }


    public function adminTuitionFeesDelete($id)
    {
        try {
            $fees = Fees::findOrFail($id);

            // Delete QR image if exists
            if ($fees->qrimage && file_exists(public_path($fees->qrimage))) {
                unlink(public_path($fees->qrimage));
            }

            $fees->delete();
            return redirect()->back()->with('success', 'Tuition fees deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }



    public function adminFeesReportView(Request $request)
    {
        $classes = Classes::all();

        // Get filters from request
        $classId = $request->input('class_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status');

        // Build query with relationships
        $query = Subscribers::with(['student', 'class', 'fees'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($fromDate) {
            $query->whereDate('subscription_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('subscription_date', '<=', $toDate);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $subscribers = $query->paginate(15);

        return view('admin.admin-fees-report', compact('classes', 'subscribers', 'classId', 'fromDate', 'toDate', 'status'));
    }

    // In acceptFees method
    public function acceptFees($id)
    {
        $subscriber = \App\Models\Subscribers::findOrFail($id);

        $subscriber->update([
            'status' => 'active',
            'expiry_date' => now()->addMonth()
        ]);

        // Send acceptance email
        Mail::to($subscriber->student->email)->send(new SubscriptionActivateInactiveMail([
            'status' => 'active',
            'student_name' => $subscriber->student->name,
            'class_name' => $subscriber->class->name,
            'class_id' => $subscriber->class_id,
            'subject_id' => $subscriber->subject_id,
            'subscription_date' => $subscriber->subscription_date,
            'expiry_date' => $subscriber->expiry_date
        ]));

        return redirect()->back()->with('success', 'Payment accepted successfully! Student subscription is now active.');
    }

    // In rejectFees method
    public function rejectFees($id)
    {
        $subscriber = \App\Models\Subscribers::findOrFail($id);

        $subscriber->update([
            'status' => 'inactive'
        ]);

        // Send rejection email
        Mail::to($subscriber->student->email)->send(new SubscriptionActivateInactiveMail([
            'status' => 'inactive',
            'student_name' => $subscriber->student->name,
            'class_name' => $subscriber->class->name,
            'class_id' => $subscriber->class_id,
            'subject_id' => $subscriber->subject_id,
            'subscription_date' => $subscriber->subscription_date
        ]));

        return redirect()->back()->with('success', 'Payment rejected successfully!');
    }

    public function exportFeesReport(Request $request)
    {
        $classId = $request->input('class_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status');

        // Build query
        $query = Subscribers::with(['student', 'class', 'fees']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($fromDate) {
            $query->whereDate('subscription_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('subscription_date', '<=', $toDate);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $subscribers = $query->get();

        // Create CSV
        $filename = 'fees_report_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Add headers
        fputcsv($output, ['SL', 'Student ID', 'Student Name', 'Email', 'Phone', 'Class', 'Amount', 'Subscription Date', 'Expiry Date', 'Status']);

        // Add data
        foreach ($subscribers as $index => $subscriber) {
            fputcsv($output, [
                $index + 1,
                $subscriber->student->student_id ?? 'N/A',
                $subscriber->student->student_name ?? 'N/A',
                $subscriber->student->email ?? 'N/A',
                $subscriber->student->mobile ?? 'N/A',
                $subscriber->class->name ?? 'N/A',
                number_format($subscriber->fees->amount ?? 0, 2),
                $subscriber->subscription_date ? date('d-m-Y', strtotime($subscriber->subscription_date)) : 'N/A',
                $subscriber->expiry_date ? date('d-m-Y', strtotime($subscriber->expiry_date)) : 'N/A',
                ucfirst($subscriber->status)
            ]);
        }

        fclose($output);
        exit;
    }
    // Students Related End ==========================================================================================================================>

    // Enquiry Start =========================================================================================================================>
    public function adminEnquiryView()
    {

        $enquiries = ContactUs::orderBy('id', 'desc')->paginate(8);

        return view('admin.admin-enquiry', compact('enquiries'));
    }

    public function adminEnquiryReply(Request $request, $id)
    {
        try {
            $request->validate([
                'reply' => 'required|string',
            ]);

            $enquiry = ContactUs::findOrFail($id);
            $enquiry->reply = $request->reply;
            $enquiry->save();

            return redirect()->back()->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function adminEnquiryDelete($id)
    {
        try {
            $enquiry = ContactUs::findOrFail($id);
            $enquiry->delete();
            return redirect()->back()->with('success', 'Enquiry deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }
    // Enquiry End ==========================================================================================================================>

    // Waver Start =========================================================================================================================>
    public function adminWaverProfilesView()
    {

        return view('admin.admin-waver-profiles');
    }

    public function adminWaverRequestView()
    {

        $waverRequests = WaverRequest::with('class')->orderBy('id', 'desc')->paginate(8);

        return view('admin.admin-wavers-request', compact('waverRequests'));
    }

    public function adminWaiverMailBack($id)
    {
        $waiver = WaverRequest::findOrFail($id);

        $data = [
            'p_name' => $waiver->p_name,
            'c_name' => $waiver->c_name,
            'email' => $waiver->email,
            'messageContent' => 'We have reviewed your waiver request and it has been approved!',
        ];

        // Send mail
        Mail::to($waiver->email)->send(new WaiverMailBack($data));

        // Update mail_status after sending mail
        $waiver->update(['mail_status' => 1]);

        return back()->with('success', 'Waiver mail sent successfully to parent!');
    }


    public function adminWaiverAccept(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:4',
        ]);

        $waiver = WaverRequest::findOrFail($id);

        $data = [
            'email' => $waiver->email,
            'p_name' => $waiver->p_name,
            'c_name' => $waiver->c_name,
            'class_name' => Classes::find($waiver->class_id)->name ?? 'Unknown Class',
            'password' => $request->password,
        ];

        Mail::to($waiver->email)->send(new WaiverAcceptMail($data));

        // Update status after sending mail
        $waiver->update(['status' => 'accepted']);

        return back()->with('success', 'Waiver acceptance email sent successfully!');
    }


    public function adminWaiverReject(Request $request, $id)
    {
        $waiver = WaverRequest::findOrFail($id);

        $data = [
            'p_name' => $waiver->p_name,
            'c_name' => $waiver->c_name,
            'email' => $waiver->email,
        ];

        Mail::to($waiver->email)->send(new WaiverRejectMail($data));

        $waiver->update(['status' => 'rejected']);

        return back()->with('success', 'Waiver rejection email sent successfully!');
    }

    public function adminWaverRequestDelete($id)
    {
        try {
            $waverRequest = WaverRequest::findOrFail($id);
            $waverRequest->delete();
            return redirect()->back()->with('success', 'Waver request deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }
    // Waver End ==========================================================================================================================>




}

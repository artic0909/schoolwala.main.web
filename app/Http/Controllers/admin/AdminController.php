<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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

        return view('admin.admin-classes');
    }

    public function adminClassFaqsView()
    {

        return view('admin.admin-class-faqs');
    }

    public function adminSubjectsView()
    {

        return view('admin.admin-subjects');
    }

    public function adminChaptersView()
    {

        return view('admin.admin-chapters');
    }

    public function adminVideosView()
    {

        return view('admin.admin-videos');
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

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboardView()
    {

        return view('admin.admin-dashboard');
    }


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

}

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


    // SEO Routes Start =========================================================================================================================>
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

    // SEO Routes End ==========================================================================================================================>

    // Front Page Routes Start =========================================================================================================================>
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
    // Front Page Routes End ==========================================================================================================================>

    // Course Related Routes Start =========================================================================================================================>
    public function adminClassesView()
    {

        return view('admin.admin-classes');
    }
    // Course Related Routes End ==========================================================================================================================>

}

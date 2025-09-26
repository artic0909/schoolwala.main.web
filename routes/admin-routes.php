<?php

use App\Http\Controllers\admin\AdminController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


// Page Not Found
Route::get('/admin-page-not-found', [AdminController::class, 'adminPageErrorView'])->name('admin.page-error');



// Auth Routes Start =========================================================================================================================>
// Route::get('/admin-register', [AdminController::class, 'adminRegisterView'])->name('admin.admin-register');
// Route::post('/admin-register', [AdminController::class, 'adminRegister'])->name('admin.admin-register.store');

Route::get('/admin-login', [AdminController::class, 'adminLoginView'])->name('admin.admin-login');
Route::post('/admin-login', [AdminController::class, 'adminLogin'])->name('admin.admin-login.verify');

Route::get('/admin-forget-password', [AdminController::class, 'adminForgetPassView'])->name('admin.admin-forget-password');
Route::get('/admin-forget-verify-otp', [AdminController::class, 'adminForgetOtpVerifyView'])->name('admin.admin-forget-verify-otp');
// Auth Routes End ==========================================================================================================================>


// Admins Guard Routes Start =========================================================================================================================>
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {

        // Dashboard Start =============================>
        Route::get('/admin-dashboard', [AdminController::class, 'adminDashboardView'])->name('admin.admin-dashboard');
        // Dashboard End ==============================>

        // Logout Start =============================>
        Route::get('/admin-logout', [AdminController::class, 'adminLogout'])->name('admin.admin-logout');
        // Logout End ==============================>

        // Admin Profile Routes Start =============================>
        Route::get('/admin-profile', [AdminController::class, 'adminProfileView'])->name('admin.admin-profile');
        Route::put('/admin-profile', [AdminController::class, 'adminProfileUpdate'])->name('admin.admin-profile-update');
        // Admin Profile Routes End ==============================>



        // Course Related Routes Start =========================================================================================================================>
        Route::get('/admin-classes', [AdminController::class, 'adminClassesView'])->name('admin.admin-classes');
        Route::post('/admin-classes', [AdminController::class, 'addClass'])->name('admin.admin-classes.store');
        Route::put('/admin-class/{id}', [AdminController::class, 'updateClass'])->name('admin.admin-class.update');
        Route::delete('/admin-class/{id}', [AdminController::class, 'deleteClass'])->name('admin.admin-class.delete');


        Route::get('/admin-class-faqs', [AdminController::class, 'adminClassFaqsView'])->name('admin.admin-class-faqs');
        Route::post('/admin-class-faqs', [AdminController::class, 'addClassFaq'])->name('admin.admin-class-faqs.store');
        Route::put('/admin-class-faqs/{id}', [AdminController::class, 'updateClassFaq'])->name('admin.admin-class-faqs.update');
        Route::delete('/admin-class-faqs/{id}', [AdminController::class, 'deleteClassFaq'])->name('admin.admin-class-faqs.delete');


        Route::get('/admin-subjects', [AdminController::class, 'adminSubjectsView'])->name('admin.admin-subjects');
        Route::post('/admin-subjects', [AdminController::class, 'addSubject'])->name('admin.admin-subjects.store');
        Route::put('/admin-subjects/{id}', [AdminController::class, 'updateSubject'])->name('admin.admin-subjects.update');
        Route::delete('/admin-subjects/{id}', [AdminController::class, 'deleteSubject'])->name('admin.admin-subjects.delete');


        Route::get('/admin-chapters', [AdminController::class, 'adminChaptersView'])->name('admin.admin-chapters');
        // just for AJAX
        Route::get('/get-subjects/{class_id}', [AdminController::class, 'getSubjects'])->name('admin.get-subjects');
        Route::post('/admin-chapters', [AdminController::class, 'addChapter'])->name('admin.admin-chapters.store');
        Route::put('/admin-chapters/{id}', [AdminController::class, 'updateChapter'])->name('admin.admin-chapters.update');
        Route::delete('/admin-chapters/{id}', [AdminController::class, 'deleteChapter'])->name('admin.admin-chapters.delete');


        Route::get('/admin-videos', [AdminController::class, 'adminVideosView'])->name('admin.admin-videos');
        // just for AJAX
        Route::get('/get-chapters/{subjectId}', [AdminController::class, 'getChapters'])->name('admin.get-chapters');
        Route::post('/admin-videos', [AdminController::class, 'addVideo'])->name('admin.admin-videos.store');
        Route::put('/admin-videos/{id}', [AdminController::class, 'updateVideo'])->name('admin.admin-videos.update');
        Route::delete('/admin-videos/{id}', [AdminController::class, 'deleteVideo'])->name('admin.admin-videos.delete');

        // Practice Test
        Route::put('/admin-videos/{id}/practice-test', [AdminController::class, 'putPracticeTestOnVideoID'])->name('admin.admin-videos.practice-test.update');

        Route::get('/admin-video-feedbacks', [AdminController::class, 'adminVideoFeedbacksView'])->name('admin.admin-video-feedbacks');
        // Course Related Routes End ==========================================================================================================================>





        // Front Page Routes Start =========================================================================================================================>
        Route::get('/admin-upload-faculty', [AdminController::class, 'adminUploadFacultyView'])->name('admin.admin-upload-faculties');
        Route::post('/admin-upload-faculty', [AdminController::class, 'adminAddFaculty'])->name('admin.admin-upload-faculties.store');
        Route::put('/admin-upload-faculty', [AdminController::class, 'adminEditFaculty'])->name('admin.admin-upload-faculties.update');
        Route::delete('/admin-upload-faculty/{id}', [AdminController::class, 'adminDeleteFaculty'])->name('admin.admin-upload-faculties.delete');


        Route::get('/admin-aboutus', [AdminController::class, 'adminAboutusView'])->name('admin.admin-aboutus');
        Route::post('/admin-aboutus', [AdminController::class, 'adminAddAboutus'])->name('admin.admin-aboutus.store');
        Route::put('/admin-aboutus', [AdminController::class, 'adminEditAboutus'])->name('admin.admin-aboutus.update');
        Route::delete('/admin-aboutus', [AdminController::class, 'adminDeleteAboutus'])->name('admin.admin-aboutus.delete');


        Route::get('/admin-story-tags', [AdminController::class, 'adminStoryTagsView'])->name('admin.admin-story-tags');
        Route::post('/admin-story-tags', [AdminController::class, 'adminAddStoryTags'])->name('admin.admin-story-tags.store');
        Route::put('/admin-story-tags/edit/{id}', [AdminController::class, 'adminEditStoryTags'])->name('admin.admin-story-tags.update');
        Route::delete('/admin-story-tags/{id}', [AdminController::class, 'adminDeleteStoryTags'])->name('admin.admin-story-tags.delete');


        Route::get('/admin-stories', [AdminController::class, 'adminStoriesView'])->name('admin.admin-stories');
        Route::post('/admin-stories', [AdminController::class, 'adminAddStory'])->name('admin.admin-stories.store');
        Route::put('/admin-stories/{id}', [AdminController::class, 'adminEditStory'])->name('admin.admin-stories.update');
        Route::delete('/admin-stories/{id}', [AdminController::class, 'adminDeleteStory'])->name('admin.admin-stories.delete');



        Route::get('/admin-faq', [AdminController::class, 'adminFaqView'])->name('admin.admin-faq');
        Route::post('/admin-faq', [AdminController::class, 'adminAddFaq'])->name('admin.admin-faq.store');
        Route::put('/admin-faq/{id}', [AdminController::class, 'adminEditFaq'])->name('admin.admin-faq.update');
        Route::delete('/admin-faq/{id}', [AdminController::class, 'adminDeleteFaq'])->name('admin.admin-faq.delete');
        // Front Page Routes End ==========================================================================================================================>






        // Students Related Route Start =========================================================================================================================>
        Route::get('/admin-students', [AdminController::class, 'adminStudentsView'])->name('admin.admin-students');
        Route::get('/admin-tuition-fees', [AdminController::class, 'adminTuitionFeesView'])->name('admin.admin-tuition-fees');
        Route::get('/admin-fees-report', [AdminController::class, 'adminFeesReportView'])->name('admin.admin-fees-report');
        // Students Related Route End ==========================================================================================================================>



        // Waver Routes Start =========================================================================================================================>
        Route::get('/admin-waver-profiles', [AdminController::class, 'adminWaverProfilesView'])->name('admin.admin-waver-profiles');
        Route::get('/admin-wavers-request', [AdminController::class, 'adminWaverRequestView'])->name('admin.admin-wavers-request');
        // Waver Routes End ==========================================================================================================================>

    });
});
// Admins Guard Routes End ==========================================================================================================================>




// SEO Routes Start =========================================================================================================================>
Route::get('/admin-seo-home-page', [AdminController::class, 'adminSeoHomePageView'])->name('admin.admin-seo-home-page');
Route::get('/admin-seo-school-tuition', [AdminController::class, 'adminSeoSchoolTuitionView'])->name('admin.admin-seo-school-tuition');
Route::get('/admin-seo-my-class', [AdminController::class, 'adminSeoMyClassView'])->name('admin.admin-seo-my-class');
Route::get('/admin-seo-contact', [AdminController::class, 'adminSeoContactView'])->name('admin.admin-seo-contact');
Route::get('/admin-seo-aboutus', [AdminController::class, 'adminSeoAboutusView'])->name('admin.admin-seo-aboutus');
Route::get('/admin-seo-privacy-policy', [AdminController::class, 'adminSeoPrivacyPolicyView'])->name('admin.admin-seo-privacy-policy');
// SEO Routes End ==========================================================================================================================>





// Enquiry Routes Start =========================================================================================================================>
Route::get('/admin-enquiry', [AdminController::class, 'adminEnquiryView'])->name('admin.admin-enquiry');
// Enquiry Routes End ==========================================================================================================================>

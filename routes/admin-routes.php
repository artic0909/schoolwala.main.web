<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/admin-dashboard', [AdminController::class, 'adminDashboardView'])->name('admin.admin-dashboard');

// SEO Routes Start =========================================================================================================================>
Route::get('/admin-seo-home-page', [AdminController::class, 'adminSeoHomePageView'])->name('admin.admin-seo-home-page');
Route::get('/admin-seo-school-tuition', [AdminController::class, 'adminSeoSchoolTuitionView'])->name('admin.admin-seo-school-tuition');
Route::get('/admin-seo-my-class', [AdminController::class, 'adminSeoMyClassView'])->name('admin.admin-seo-my-class');
Route::get('/admin-seo-contact', [AdminController::class, 'adminSeoContactView'])->name('admin.admin-seo-contact');
Route::get('/admin-seo-aboutus', [AdminController::class, 'adminSeoAboutusView'])->name('admin.admin-seo-aboutus');
Route::get('/admin-seo-privacy-policy', [AdminController::class, 'adminSeoPrivacyPolicyView'])->name('admin.admin-seo-privacy-policy');
// SEO Routes End ==========================================================================================================================>

// Front Page Routes Start =========================================================================================================================>
Route::get('/admin-upload-faculty', [AdminController::class, 'adminUploadFacultyView'])->name('admin.admin-upload-faculties');
Route::get('/admin-aboutus', [AdminController::class, 'adminAboutusView'])->name('admin.admin-aboutus');
Route::get('/admin-story-tags', [AdminController::class, 'adminStoryTagsView'])->name('admin.admin-story-tags');
Route::get('/admin-stories', [AdminController::class, 'adminStoriesView'])->name('admin.admin-stories');
Route::get('/admin-faq', [AdminController::class, 'adminFaqView'])->name('admin.admin-faq');
// Front Page Routes End ==========================================================================================================================>
<?php

use App\Http\Controllers\application\AuthController;
use App\Http\Controllers\application\StudentApiController;
use App\Http\Controllers\application\CommonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ===============================================================================================
// PUBLIC ROUTES
// ===============================================================================================

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Common Data
Route::get('/classes', [CommonController::class, 'getClasses']);
Route::get('/stories', [CommonController::class, 'getStories']);
Route::get('/faculties', [CommonController::class, 'getFaculties']);
Route::get('/faqs', [CommonController::class, 'getFAQs']);
Route::get('/about-us', [CommonController::class, 'getAboutUs']);

// Public Forms
Route::post('/contact-us', [StudentApiController::class, 'contactUsSubmit']);
Route::post('/waver-request', [StudentApiController::class, 'waverRequestSubmit']);

// Password Reset
Route::post('/password/forgot', [StudentApiController::class, 'sendOTP']);
Route::post('/password/verify-otp', [StudentApiController::class, 'verifyOTP']);
Route::post('/password/reset', [StudentApiController::class, 'resetPassword']);

// ===============================================================================================
// PROTECTED ROUTES (Require Authentication)
// ===============================================================================================

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    // -----------------------------------------------
    // Authentication
    // -----------------------------------------------
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // -----------------------------------------------
    // Student Profile Management
    // -----------------------------------------------
    Route::prefix('student')->group(function () {
        Route::get('/profile', [StudentApiController::class, 'getProfile']);
        Route::post('/profile/update', [StudentApiController::class, 'updateProfile']);
        Route::post('/change-password', [StudentApiController::class, 'changePassword']);
    });

    // -----------------------------------------------
    // CLASS → SUBJECTS → CHAPTERS → VIDEOS Hierarchy
    // -----------------------------------------------
    Route::prefix('student')->group(function () {
        
        // 1. Get student's registered class with all subjects
        Route::get('/my-class', [StudentApiController::class, 'getMyClass']);
        
        // 2. Get chapters for a specific subject (with lock status)
        Route::get('/subject/{subjectId}/chapters', [StudentApiController::class, 'getSubjectChapters']);
        
        // 3. Get videos for a specific chapter (access control applied)
        Route::get('/chapter/{chapterId}/videos', [StudentApiController::class, 'getChapterVideos']);
        
    });

    // -----------------------------------------------
    // Video Interaction
    // -----------------------------------------------
    Route::prefix('student/video')->group(function () {
        
        // Get video details with feedbacks
        Route::get('/{videoId}', [StudentApiController::class, 'getVideoDetails']);
        
        // Like a video
        Route::post('/like', [StudentApiController::class, 'likeVideo']);
        
        // Submit feedback
        Route::post('/feedback', [StudentApiController::class, 'submitFeedback']);
        
    });

    // -----------------------------------------------
    // Practice Test
    // -----------------------------------------------
    Route::prefix('student/video')->group(function () {
        
        // Get practice test questions
        Route::get('/{videoId}/test', [StudentApiController::class, 'getPracticeTest']);
        
        // Submit test answers
        Route::post('/test/submit', [StudentApiController::class, 'submitPracticeTest']);
        
    });

    // -----------------------------------------------
    // Subscription & Payment
    // -----------------------------------------------
    Route::prefix('student/payment')->group(function () {
        
        // Get payment/fees information
        Route::get('/info', [StudentApiController::class, 'getPaymentInfo']);
        
        // Submit payment receipt
        Route::post('/store', [StudentApiController::class, 'storePayment']);
        
    });
});
<?php

use App\Http\Controllers\application\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/classes', [App\Http\Controllers\application\CommonController::class, 'getClasses']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Student specific routes
    Route::get('/student/profile', [App\Http\Controllers\application\StudentApiController::class, 'getProfile']);
    Route::post('/student/profile/update', [App\Http\Controllers\application\StudentApiController::class, 'updateProfile']);
    Route::post('/student/change-password', [App\Http\Controllers\application\StudentApiController::class, 'changePassword']);
    
    Route::get('/student/my-class', [App\Http\Controllers\application\StudentApiController::class, 'getMyClass']);
    Route::get('/student/subject/{subjectId}/chapters', [App\Http\Controllers\application\StudentApiController::class, 'getSubjectChapters']);
    Route::get('/student/chapter/{chapterId}/videos', [App\Http\Controllers\application\StudentApiController::class, 'getChapterVideos']);
    
    // Video Interaction
    Route::get('/student/video/{chapterId}/{videoId}', [App\Http\Controllers\application\StudentApiController::class, 'getVideoDetails']);
    Route::post('/student/video/like', [App\Http\Controllers\application\StudentApiController::class, 'likeVideo']);
    Route::post('/student/video/feedback', [App\Http\Controllers\application\StudentApiController::class, 'submitFeedback']);

    // Practice Test
    Route::get('/student/video/{videoId}/test', [App\Http\Controllers\application\StudentApiController::class, 'getPracticeTest']);
    Route::post('/student/video/test/submit', [App\Http\Controllers\application\StudentApiController::class, 'submitPracticeTest']);

    // Payment
    Route::post('/student/payment/store', [App\Http\Controllers\application\StudentApiController::class, 'storePayment']);
});

// Common Data Routes (Creating a group or just listing them)
Route::get('/stories', [App\Http\Controllers\application\CommonController::class, 'getStories']);
Route::get('/faculties', [App\Http\Controllers\application\CommonController::class, 'getFaculties']);
Route::get('/faqs', [App\Http\Controllers\application\CommonController::class, 'getFAQs']);
Route::get('/about-us', [App\Http\Controllers\application\CommonController::class, 'getAboutUs']);

// Forms (Public or Protected? Usually public for contact/waver if non-student can access, but WaverRequest in controller didn't seem to enforce auth in submit method, though the view might. Let's make them public or auth based on user preference. `waverRequestSubmit` in `StudentController` validation doesn't check auth, just email. But usually these are for visitors too. ContactUs is definitely public. Waver seems public too.)
Route::post('/contact-us', [App\Http\Controllers\application\StudentApiController::class, 'contactUsSubmit']);
Route::post('/waver-request', [App\Http\Controllers\application\StudentApiController::class, 'waverRequestSubmit']);

// Password Reset (Public)
Route::post('/password/forgot', [App\Http\Controllers\application\StudentApiController::class, 'sendOTP']);
Route::post('/password/verify-otp', [App\Http\Controllers\application\StudentApiController::class, 'verifyOTP']);
Route::post('/password/reset', [App\Http\Controllers\application\StudentApiController::class, 'resetPassword']);

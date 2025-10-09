<?php

use App\Http\Controllers\student\StudentController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;



Route::get('/student-login', [StudentController::class, 'LoginView'])->name('student.student-login');
Route::post('/student-login', [StudentController::class, 'login'])->name('student.student-login.verify');

// Forget password flow
Route::get('/forget-password', [StudentController::class, 'forgetPassView'])->name('student.forget-pass-view');
Route::post('/forget-password', [StudentController::class, 'sendOTP'])->name('student.send-otp');

Route::get('/verify-otp', [StudentController::class, 'verifyOTPView'])->name('student.verify-otp-view');
Route::post('/verify-otp', [StudentController::class, 'verifyOTP'])->name('student.verify-otp');

Route::get('/update-password', [StudentController::class, 'updatePassView'])->name('student.update-pass-view');
Route::post('/update-password', [StudentController::class, 'updatePassword'])->name('student.update-password');
// Forget password flow


Route::get('/student-register', [StudentController::class, 'registerView'])->name('student.student-register');
Route::post('/student-register', [StudentController::class, 'register'])->name('student.student-register.store');

// School Tuition Page
Route::get('/school-tuitions', [StudentController::class, 'schoolTuitionView'])->name('student.school-tuitions');
Route::get('/get-class-curriculum/{classId}', [StudentController::class, 'getClassCurriculum']);







// Student Guard Routes Start =========================================================================================================================>
Route::prefix('student')->group(function () {
    Route::middleware('auth:student')->group(function () {


        Route::get('/student-dashboard', [StudentController::class, 'studentDashboardView'])->name('student.student-dashboard');
        Route::get('/student-logout', [StudentController::class, 'logout'])->name('student.student-logout');

        // Route::get('/', function () {
        //     return view('home');
        // })->name('student.home');

        // Home Page
        Route::get('/', [StudentController::class, 'homeView'])->name('student.home');





        // Profile View
        Route::get('/student-profile', [StudentController::class, 'studentProfileView'])->name('student.student-profile');
        Route::get('/my-profile-update', [StudentController::class, 'studentProfileUpdateView'])->name('student.student-profile.update.view');
        Route::post('/my-profile/image/update', [StudentController::class, 'studentProfileImageOrIconUpdate'])->name('student.profile-image.update');
        Route::post('/my-profile-update', [StudentController::class, 'studentProfileNameUpdate'])->name('student.profile-name.update');
        Route::post('/my-profile-update/interest/{studentId}', [StudentController::class, 'studentProfileInterestUpdate'])->name('student.profile-interest.update');
        Route::post('/my-profile-update/password', [StudentController::class, 'studentProfilePasswordUpdate'])->name('student.profile-password.update');

        // My Class Page
        Route::get('/my-class', [StudentController::class, 'myClassView'])->name('student.my-class');

        // My Class Content
        Route::get('/my-class-content/{classId}/{subjectId}', [StudentController::class, 'myClassContent'])->name('student.my-class-content');

        // My Chapter Videos
        Route::get('/my-chapter-videos/{classId}/{subjectId}/{chapterId}', [StudentController::class, 'myChapterVideos'])->name('student.my-chapter-videos');

        // My Video Play
        Route::get('/my-video-play/{classId}/{subjectId}/{chapterId}/{videoId}', [StudentController::class, 'myVideoPlay'])->name('student.my-video-play');
        Route::post('/my-video-play', [StudentController::class, 'myVideoPlayFeedbackSubmit'])->name('student.my-video-play.submit');
        Route::post('/my-video-play/like', [StudentController::class, 'myVideoLikesSubmit'])->name('student.my-video-play.like.submit');



        // My Video Practice Test
        Route::get('/my-video-practice-test/{classId}/{subjectId}/{chapterId}/{videoId}', [StudentController::class, 'myVideoPracticeTest'])->name('student.my-video-practice-test');
        Route::post('/my-video-practice-test/submit/{studentId}/{videoId}', [StudentController::class, 'myVideoPracticeTestSubmit'])->name('student.myVideoPracticeTest.submit');
        Route::get('/my-video-practice-test-result/{classId}/{subjectId}/{chapterId}/{videoId}', [StudentController::class, 'myVideoPracticeTestResult'])->name('student.my-video-practice-test.result');
    });
});
// Admins Guard Routes End ==========================================================================================================================>
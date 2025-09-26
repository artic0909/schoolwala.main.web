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


// Student Guard Routes Start =========================================================================================================================>
Route::prefix('student')->group(function () {
    Route::middleware('auth:student')->group(function () {


        Route::get('/student-dashboard', [StudentController::class, 'studentDashboardView'])->name('student.student-dashboard');
        Route::get('/student-logout', [StudentController::class, 'logout'])->name('student.student-logout');

        Route::get('/', function () {
            return view('home');
        })->name('student.home');





        // Profile View
        Route::get('/student-profile', [StudentController::class, 'studentProfileView'])->name('student.student-profile');
    });
});
// Admins Guard Routes End ==========================================================================================================================>
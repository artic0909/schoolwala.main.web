<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

// Page Not Found
Route::get('/page-not-found', function () {
    return view('page-error');
})->name('page-error');

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/school-tuitions', function () {
//     return view('school-tuition');
// })->name('school-tuition');

// Route::get('/my-class', function () {
//     return view('my-class');
// })->name('my-class');

// Route::get('/my-class-content', function () {
//     return view('my-class-content');
// })->name('my-class-content');

// Route::get('/my-chapter-videos', function () {
//     return view('my-chapter-videos');
// })->name('my-chapter-videos');

// Route::get('/my-video-play', function () {
//     return view('my-video-play');
// })->name('my-video-play');

Route::get('/my-video-practice-test', function () {
    return view('my-video-practice-test');
})->name('my-video-practice-test');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Route::view('/', 'home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';

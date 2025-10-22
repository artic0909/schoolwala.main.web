<?php

use App\Http\Controllers\admin\AdminController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

// Subscribers Guard Routes Start =========================================================================================================================>
Route::prefix('subscriber')->group(function () {
    Route::middleware('auth:subscriber')->group(function () {
        
    });
});
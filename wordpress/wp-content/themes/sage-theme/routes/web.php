<?php

use App\Http\Controllers\LiveScoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/live-score-dashboard', [LiveScoreController::class, 'index'])->name('home');

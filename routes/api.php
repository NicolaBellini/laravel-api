<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\pageController;
use App\Http\Controllers\api\leadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/projects', [pageController::class, 'index']);
Route::get('/project-detail/{slug}', [pageController::class, 'getProjectBySlug']);



Route::get('/technologies', [pageController::class, 'technologies']);

Route::get('/types', [pageController::class, 'types']);

// rotta email
Route::post('/send-mail', [leadController::class, 'store']);

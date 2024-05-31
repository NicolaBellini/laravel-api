<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\guest\pageController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\projectController;
use App\Http\Controllers\admin\technologyController;
use Database\Seeders\ProjectsSeeder;
use App\Http\Controllers\admin\typeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[pageController::class, 'index'])->name('home');

// auth va minuscolo
Route::middleware(['auth', 'verified'])
    ->prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [adminController::class, 'index'])->name('home');
    Route::resource('projects', projectController::class);
    Route::resource('technology', technologyController::class)->except([
        'create','show','edit'
    ]);
     Route::resource('type', typeController::class)->except([
        'create','show','edit'
    ]);
    Route::get('/projectsType', [typeController::class, 'projectsType'])->name('projectsType');
    Route::get('orderBy/{direction}/{column}', [projectController::class, 'orderBy'])->name('orderBy');
    Route::get('projects_by_type/{type}', [typeController::class, 'getTypeProjects'])->name('projects_by_type');
});



// Route::middleware(['auth','verified'])->group(function(){
//     Route::get('/home',[ProjectController::class, 'index'])->name('projects');
// });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

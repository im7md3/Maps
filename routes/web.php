<?php

use App\Models\Place;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);
 
    return redirect()->back();
})->name('language');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'places'=>Place::orderBy('view_count','desc')->take(3)->get(),
        'url'=> asset(""),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('places', App\Http\Controllers\PlaceController::class);
Route::resource('reviews', App\Http\Controllers\ReviewController::class);
Route::resource('reports', App\Http\Controllers\ContactController::class);

Route::post('/autocomplete',[App\Http\Controllers\SearchController::class,'index'])->name('autocomplete');
Route::get('/search',[App\Http\Controllers\SearchController::class,'view'])->name('search');
Route::post('/like',[App\Http\Controllers\LikeController::class,'toggleLike'])->name('like');
Route::post('/bookmark',[App\Http\Controllers\BookmarkController::class,'toggleMark'])->name('bookmark');
Route::get('/bookmarks',[App\Http\Controllers\BookmarkController::class,'index'])->name('bookmark.index');
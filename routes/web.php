<?php

// Import the necessary classes from Laravel and your application's controllers.
// 'Route' is the facade used to define routes in Laravel.
// 'AdminLoginController' and 'HomeController' are the controllers that will handle requests to the admin routes.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;

use App\Http\Controllers\admin\CategoryController; 
use App\Http\Controllers\admin\TempImagesController; 
use App\Http\Controllers\admin\SubGenreController; 
use App\Http\Controllers\FrontController; 

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and are all assigned 
| to the "web" middleware group, meaning they have access to session state, 
| CSRF protection, and more.
|
*/

// Define a route for the root URL ('/'). When accessed, it returns the 'welcome' view.
//Route::get('/', function () {
 //   return view('welcome');
//});
Route::get('/',[FrontController::class,'index'])->name('front.home');

// Define a route for the admin login page. When accessed, it calls the 'index' method of the 'AdminLoginController'.
// The route is named 'admin.login' for easy reference in the application.
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin.login');

// Group the routes that share the same 'admin' prefix (e.g., '/admin/dashboard').
// This makes the routes cleaner and more organized.
Route::group(['prefix' => 'admin'], function () {

    // Group the routes that are accessible only to guests (unauthenticated users).
    // These routes use the 'admin.guest' middleware to ensure that only users who are not logged in can access them.
    Route::group(['middleware' => 'admin.guest'], function() {

        // Define a GET route for the admin login page. This is a duplicate of the earlier route,
        // ensuring that the admin login page can be accessed within the 'admin' prefix.
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        
        // Define a POST route for authenticating the admin. When the login form is submitted,
        // it calls the 'authenticate' method of the 'AdminLoginController'.
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    // Group the routes that require the admin to be authenticated (logged in).
    // These routes use the 'admin.auth' middleware to ensure that only logged-in admins can access them.
    Route::group(['middleware' => 'admin.auth'], function() {

        // Define a route for the admin dashboard. When accessed, it calls the 'index' method of the 'HomeController'.
        // The route is named 'admin.dashboard' for easy reference in the application.
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        
        // Define a route for logging out the admin. When accessed, it calls the 'logout' method of the 'HomeController'.
        // The route is named 'admin.logout' for easy reference in the application.
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //Category Routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        //Sub Genre Routes
        Route::get('/sub-genre', [SubGenreController::class, 'index'])->name('sub-genre.index');
        Route::get('/sub-genre/create', [SubGenreController::class, 'create'])->name('sub-genre.create');
        Route::post('/sub-genre', [SubGenreController::class, 'store'])->name('sub-genre.store');
        Route::get('/sub-genre/{subgenre}/edit', [SubGenreController::class, 'edit'])->name('sub-genre.edit');
        Route::put('/sub-genre/{subgenre}', [SubGenreController::class, 'update'])->name('sub-genre.update');
        Route::delete('/sub-genre/{subgenre}', [SubGenreController::class, 'destroy'])->name('sub-genre.delete');


        //temp-images.create
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');



       Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
              'status' => true,
              'slug' => $slug
            ]);
        })->name('getSlug'); 

    });
});

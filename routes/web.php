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
use App\Http\Controllers\BookController; 
use App\Http\Controllers\BookImageController; 
use App\Http\Controllers\BookSubGenreController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
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
Route::get('/shop/{categorySlug?}/{subGenreSlug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/book/{slug}',[ShopController::class,'book'])->name('front.book');
Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('front.addToCart');
Route::post('/update-cart',[CartController::class,'updateCart'])->name('front.updateCart');
Route::post('/delete-item',[CartController::class,'deleteItem'])->name('front.deleteItem.cart');
Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class,'processCheckout'])->name('front.processCheckout');


//Route::get('/login',[AuthController::class,'login'])->name('account.login');

//Authentication Routes
Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function() {
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register',[AuthController::class,'register'])->name('account.register');
        Route::post('/process-register',[AuthController::class,'processRegister'])->name('account.processRegister');

    });

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::post('/books',[BookController::class,'store'])->name('books.store');
        Route::get('/product', [AuthController::class, 'product'])->name('account.product');
        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');

    });
});
         //Book Routes
         Route::get('/books',[BookController::class,'index'])->name('books.index');
         Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
         Route::get('/book-subgenres', [BookSubGenreController::class, 'index'])->name('book-subgenres.index');
         Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
         Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');

         Route::post('/book-images/update',[BookImageController::class,'update'])->name('book-images.update');
         Route::delete('/book-images',[BookImageController::class,'destroy'])->name('book-images.destroy');
         Route::delete('/books/{book}',[BookController::class,'destroy'])->name('books.delete');
         Route::get('/get-books',[BookController::class,'getBooks'])->name('books.getBooks');




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
        Route::post('upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');



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

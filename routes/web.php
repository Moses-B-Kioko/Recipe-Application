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
use App\Http\Controllers\ShippingController; 
use App\Http\Controllers\BookImageController; 
use App\Http\Controllers\BookSubGenreController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\PusherController; 
use App\Http\Controllers\admin\UserController; 
use App\Http\Controllers\admin\PageController; 
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\SellerController;
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

//Route::get('/test', function () {
  //  orderEmail(10);
//});
Route::get('/message', 'App\Http\Controllers\PusherController@index');
Route::post('/broadcast', 'App\Http\Controllers\PusherController@broadcast');
Route::post('/receive', 'App\Http\Controllers\PusherController@receive');



Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subGenreSlug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/book/{slug}',[ShopController::class,'book'])->name('front.book');
Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('front.addToCart');
Route::post('/update-cart',[CartController::class,'updateCart'])->name('front.updateCart');
Route::post('/delete-item',[CartController::class,'deleteItem'])->name('front.deleteItem.cart');
Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class,'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}',[CartController::class,'thankyou'])->name('front.thankyou');
Route::post('/get-order-summery',[CartController::class,'getOrderSummery'])->name('front.getOrderSummery');
Route::get('/page/{slug}',[FrontController::class,'page'])->name('front.page');
Route::post('/send-contact-email',[FrontController::class,'sendContactEmail'])->name('front.sendContactEmail');


Route::get('/forgot-password',[AuthController::class,'forgetPassword'])->name('front.forgotPassword');
Route::post('/process-forgot-password',[AuthController::class,'processForgotPassword'])->name('front.processForgotPassword');
Route::get('/reset-password/{token}',[AuthController::class,'resetPassword'])->name('front.resetPassword');
Route::post('/process-reset-password',[AuthController::class,'processResetPassword'])->name('front.processResetPassword');
Route::post('/save-rating/{bookId}',[ShopController::class,'saveRating'])->name('front.saveRating');

//Wishlist Routes
Route::post('/add-to-wishlist',[FrontController::class,'addToWishlist'])->name('front.addToWishlist');

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
        Route::post('/update-buyer-profile', [AuthController::class, 'updateBuyerProfile'])->name('account.updateBuyerProfile');
        Route::post('/update-buyer-address', [AuthController::class, 'updateBuyerAddress'])->name('account.updateBuyerAddress');
        
        Route::get('/seller-change-password', [AuthController::class, 'sellerShowChangePasswordForm'])->name('account.sellerShowChangePasswordForm');
        Route::post('/seller-process-change-password', [AuthController::class, 'sellerChangePassword'])->name('account.sellerChangePassword');


        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('account.changePassword');
        Route::post('/process-change-password', [AuthController::class, 'changePassword'])->name('account.processChangePassword');

        Route::get('/sellerProfile', [AuthController::class, 'sellerProfile'])->name('account.sellerProfile');
        Route::post('/update-profile', [AuthController::class, 'updateSellerProfile'])->name('account.updateSellerProfile');
        Route::post('/update-address', [AuthController::class, 'updateAddress'])->name('account.updateAddress');
        Route::get('/my-orders', [AuthController::class, 'orders'])->name('account.orders');
        Route::get('/my-wishlist', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::post('/remove-book-from-wishlist', [AuthController::class, 'removeBookFromWishlist'])->name('account.removeBookFromWishlist');
        Route::get('/order-detail/{orderId}', [AuthController::class, 'orderDetails'])->name('account.orderDetails');
        Route::post('/books',[BookController::class,'store'])->name('books.store');
        Route::get('/product', [AuthController::class, 'product'])->name('account.product');
        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');

    });
});

// Route for authenticated users to upload temporary images (admin and sellers)
Route::group(['middleware' => 'auth'], function () {
    Route::post('upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');
});

/*Route::prefix('seller')->name('seller.')->group(function(){
    Route::middleware([])->group(function(){
        Route::controller([])->group(function(){
            Route::get('/login','login')->name('login');
            Route::get('/register','register')->name('register'); 
        });
    });

    Route::middleware([])->group(function(){
        Route::controller(SellerController::class)->group(function(){
            Route::get('/','home')->name('home');
        });
    });
});*/
Route::middleware(['auth:seller'])->group(function () {   
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
        });
         //Shipping Routes
         Route::get('/shipping/create',[ShippingController::class,'create'])->name('shipping.create');
         Route::post('/shipping',[ShippingController::class,'store'])->name('shipping.store');
         Route::get('/shipping/{id}',[ShippingController::class,'edit'])->name('shipping.edit');
         Route::put('/shipping/{id}',[ShippingController::class,'update'])->name('shipping.update');
         Route::delete('/shipping/{id}',[ShippingController::class,'destroy'])->name('shipping.delete');





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
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index');
        
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

        //User Routes
        Route::get('/users',[UserController::class,'index'])->name('users.index');
        Route::get('/users/create',[UserController::class,'create'])->name('users.create');
        Route::post('/users',[UserController::class,'store'])->name('users.store');
        Route::get('/users/{user}/edit',[UserController::class,'edit'])->name('users.edit');
        Route::put('/users/{user}',[UserController::class,'update'])->name('users.update');
        Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');

        //Page Routes
        Route::get('/pages',[PageController::class,'index'])->name('pages.index');
        Route::get('/pages/create',[PageController::class,'create'])->name('pages.create');
        Route::post('/pages',[PageController::class,'store'])->name('pages.store');
        Route::get('/pages/{page}/edit',[PageController::class,'edit'])->name('pages.edit');
        Route::put('/pages/{page}',[PageController::class,'update'])->name('pages.update');
        Route::delete('/pages/{page}',[PageController::class,'destroy'])->name('pages.destroy');

        //Dashboard Routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        //Admin Orders Routes
        Route::get('/admin-orders',[OrderController::class,'adminIndex'])->name('orders.adminIndex');
        Route::get('/admin-orders/{id}',[OrderController::class,'adminDetail'])->name('orders.adminDetail');

        //Admin Book Routes
        Route::get('/admin-books',[BookController::class,'adminIndex'])->name('books.adminIndex');
        Route::get('/ratings',[BookController::class,'bookRatings'])->name('books.bookRatings');
        Route::get('/change-rating-status',[BookController::class,'changeRatingStatus'])->name('books.changeRatingStatus');

        //Settings routes
        Route::get('/change-password',[SettingController::class,'showChangePasswordForm'])->name('admin.showChangePasswordForm');
        Route::post('/process-change-password',[SettingController::class,'processchangePassword'])->name('admin.processchangePassword');






        

    });
});

//Order Routes
Route::get('/orders',[OrderController::class,'index'])->name('orders.index');
Route::get('/orders/{id}',[OrderController::class,'detail'])->name('orders.detail');
Route::post('/order/change-status/{id}',[OrderController::class,'changeOrderStatusForm'])->name('orders.changeOrderStatusForm');
Route::post('/order/send-email/{id}',[OrderController::class,'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');

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

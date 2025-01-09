<?php

// Declare the namespace for the controller class, indicating that this class is located 
// in the 'App\Http\Controllers\admin' directory.
namespace App\Http\Controllers\admin;

// Import the necessary classes from the Laravel framework.
// 'Controller' is the base controller class from which all controllers in Laravel inherit.
// 'Request' is used to handle incoming HTTP requests.
// 'Auth' is used to manage authentication.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempImage;


class HomeController extends Controller
{
    /**
     * Show the home page for the admin panel.
     *
     * This method retrieves the currently authenticated admin user and displays a welcome message 
     * with a logout link.
     */
    public function index(){
        return view('dashboard.index');
        // Retrieve the currently authenticated admin user.
        //$admin = Auth::guard('admin')->user();
        
        // Output a welcome message with the admin's name and a logout link.
        //echo 'Welcome ' . $admin->name . ' <a href="' . route('admin.logout') . '">Logout</a>';

        


    }

    /**
     * Log the admin user out of the application.
     *
     * This method logs out the currently authenticated admin user and redirects them to the admin login page.
     */
    public function logout() {
        // Log out the currently authenticated admin user.
        Auth::guard('admin')->logout();
        
        // Redirect the user to the admin login page.
        return redirect()->route('admin.login');
    }
}

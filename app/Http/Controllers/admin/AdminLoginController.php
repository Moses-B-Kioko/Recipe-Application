<?php

// This declares the namespace for the AdminLoginController class, indicating that this controller is
// located in the 'admin' folder inside the 'App\Http\Controllers' directory.
namespace App\Http\Controllers\admin;

// Import the necessary classes. These are being brought in from the Laravel framework:
// Controller: The base controller class.
// Request: Handles HTTP requests.
// Auth: Handles authentication.
// Validator: Handles validation of form inputs.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    // This function displays the admin login page.
    public function index() {
        return view('admin.login');
    }

    // This function handles the login logic when an admin submits the login form.
    public function authenticate(Request $request){

        // Validate the incoming request, ensuring that the 'email' and 'password' fields are filled out correctly.
        // The 'email' field is required and must be in a valid email format.
        // The 'password' field is required.
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if the validation passed.
        if($validator->passes()) {
            // If validation is successful, attempt to authenticate the admin using the provided credentials.
            // The 'attempt' method checks the email and password, and 'remember' keeps the admin logged in.
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => 
            $request->password], $request->get('remember'))){

                // Get the currently authenticated admin user.
                $admin = Auth::guard('admin')->user();

                // Check if the admin has the correct role (role 2) to access the dashboard.
                if ($admin->role == 2) {
                    // If the role is valid, redirect the admin to the dashboard.
                    return redirect()->route('dashboard.index');
                }else {
                    // If the role is not valid, log out the admin and redirect them to the login page
                    // with an error message indicating they are not authorized to access the admin panel.
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to 
                    access admin panel.');
                }
            } else {
                // If authentication fails (incorrect email or password), redirect back to the login page
                // with an error message indicating the credentials are incorrect.
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is
                 incorrect');
            }
        }else {
            // If validation fails, redirect back to the login page with the validation errors and
            // retain the 'email' field input, so the user doesn't have to re-enter it.
            return redirect()->route('admin.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        return view('front.account.login');
    }

    public function register() {
        return view('front.account.register');
    }

    public function processRegister(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Create new user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        // Flash a success message
        session()->flash('success', 'You have been registered successfully.');

        return response()->json([
            'status' => true
        ]);
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $user = Auth::user(); // You don't need to use a guard again if Auth::attempt succeeded
                
                if ($user->role == 1) {
                    // Redirect to profile for authorized user
                    return redirect()->route('account.profile'); 
                } else {
                    // Log out unauthorized users
                    Auth::logout();
                    return redirect()->route('account.login')->with('error', 'You are not authorized to access this panel.');
                }
            } else {
                return redirect()->route('account.login')
                          ->withInput($request->only('email'))
                          ->with('error', 'Either email or password is incorrect.');
            }
            

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }


    public function profile() {
        $data = [];
        $genres = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $genres; // Correct assignment
        return view('front.account.profile', $data);
    }

    public function index(Request $request) {
        
        if( !empty($request->category_id)) {
            // Fetch the sub-genres based on the category_id
            $subCategories = SubGenre::where('category_id', $request->category_id)
                ->orderBy('name', 'ASC')
                ->get();
    
            return response()->json([
                'status' => true,
                'subCategories' => $subCategories
            ]);
        } else {
            return response()->json([
                'status' => false,
                'subCategories' => []
            ]);
        }
    }
    

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login')
        ->with('success', 'You successfully logged out!');
    }
    public function product() {
        return view('front.account.product');
    }
}

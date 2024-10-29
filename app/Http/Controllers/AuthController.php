<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\County;
use App\Models\SubCounty;
use App\Models\towns;
use App\Models\Seller;
use App\Models\Wishlist;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;

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
            'password' => 'required|min:5|confirmed',
            //'shop_name' => 'required|string|min:3', // Add any additional fields needed for sellers
        ]);
    
        if ($validator->passes()) {
            // Create new user
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
    
            // Create seller record
            $seller = new Seller; // Assuming you have a Seller model
            $seller->user_id = $user->id; // Assuming you have a user_id column in the sellers table
            //$seller->shop_name = $request->shop_name; // Adjust according to your seller fields
            // Set any other seller-related fields here
            $seller->save();
    
            session()->flash('success', 'You have been registered successfully.');
    
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $user = Auth::user(); // You don't need to use a guard again if Auth::attempt succeeded

                if(session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }
                
                if ($user->role == 1) {
                    // Redirect to books for authorized user
                    return redirect()->route('books.create'); 
                } else if($user->role == 3) {
                    return redirect()->route('account.sellerProfile'); 
                }
                 else {
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
        //$data = [];
        //$genres = Category::orderBy('name', 'ASC')->get();
        //$data['categories'] = $genres; // Correct assignment
        $userId= Auth::user()->id;

        $counties = County::orderBy('name','ASC')->get();
        $sub_counties = SubCounty::orderBy('name','ASC')->get();
        $towns = Towns::orderBy('name','ASC')->get();

        $user = User::where('id',$userId)->first();

        $address = CustomerAddress::where('user_id',$userId)->first();
        return view('front.account.profile',[
            'user' => $user,
            'counties' => $counties,
            'address' => $address,
            'sub_counties' => $sub_counties,
            'towns' => $towns
        ]);
    }

    public function updateBuyerProfile(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,except,id',
            'phone' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            session()->flash('success','Profile Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateBuyerAddress(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'county_id' => 'required',
            'sub_county_id' => 'required',
            'town_id' => 'required',
            'mobile' => 'required',
            'address' => 'required|min:5',
        ]);

        if ($validator->passes()) {
            /*$user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save(); */

            CustomerAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'county_id' => $request->county_id,
                    'sub_county_id' => $request->sub_county_id,
                    'town_id' => $request->town_id,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                ]
            );

            session()->flash('success','Address Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function sellerProfile() {
        //$data = [];
        //$genres = Category::orderBy('name', 'ASC')->get();
        //$data['categories'] = $genres; // Correct assignment
        $userId= Auth::user()->id;

        $counties = County::orderBy('name','ASC')->get();
        $sub_counties = SubCounty::orderBy('name','ASC')->get();
        $towns = Towns::orderBy('name','ASC')->get();

        $user = User::where('id',$userId)->first();

        $address = CustomerAddress::where('user_id',$userId)->first();
        return view('front.account.sellerProfile',[
            'user' => $user,
            'counties' => $counties,
            'address' => $address,
            'sub_counties' => $sub_counties,
            'towns' => $towns
        ]);
    }

    public function updateSellerProfile(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,except,id',
            'phone' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            session()->flash('success','Profile Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateAddress(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'county_id' => 'required',
            'sub_county_id' => 'required',
            'town_id' => 'required',
            'mobile' => 'required',
            'address' => 'required|min:5',
        ]);

        if ($validator->passes()) {
            /*$user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save(); */

            CustomerAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'county_id' => $request->county_id,
                    'sub_county_id' => $request->sub_county_id,
                    'town_id' => $request->town_id,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                ]
            );

            session()->flash('success','Address Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
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
        session()->invalidate();
        return redirect()->route('account.login')
        ->with('success', 'You successfully logged out!');
    }
    public function product() {
        return view('front.account.product');
    }

    public function orders() {

        $data = [];

        $user = Auth::user();

        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();

        $data['orders'] = $orders;

        return view('front.account.order', $data);
    }

    public function orderDetails($id) {
        $data = [];
        $user = Auth::user();

        $order = Order::where('user_id',$user->id)->where('id', $id)->first();
        $data['order'] = $order;
        $orderItems = OrderItem::where('order_id',$id)->get();
        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id',$id)->get()->count();
        $data['orderItemsCount'] = $orderItemsCount;
        return view('front.account.order-detail', $data);

    }

    public function sellerShowChangePasswordForm() {
        return view('front.account.seller-change-password');
    }

    public function sellerChangePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',            
        ]);

        if ($validator->passes()) {

            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if (Hash::check(!$request->old_password,$user->password)){
                session()->flash('error','Your old password is incorrect, please try again.');

                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success','Your have successfully changed your password.');

                return response()->json([
                    'status' => true,
                ]);
            //dd($user);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function showChangePasswordForm() {
        return view('front.account.change-password');
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',            
        ]);

        if ($validator->passes()) {

            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if (Hash::check(!$request->old_password,$user->password)){
                session()->flash('error','Your old password is incorrect, please try again.');

                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success','Your have successfully changed your password.');

                return response()->json([
                    'status' => true,
                ]);
            //dd($user);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function forgetPassword() {
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);

        if($validator->fails()) {
            return redirect()->route('front.forgetPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(60);

        \DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        //Send Email Here

        $user = User::where('email', $request->email)->first();

        $formData = [
            'token' => $token,
            'user' => $user,
            'mailSubject' => 'You have requested to reset your password'
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($formData));

        return redirect()->route('front.forgotPassword')->with('success','Please check your inbox to reset your password');

    }

    public function resetPassword($token) {
        $tokenExist = \DB::table('password_reset_tokens')->where('token',$token)->first();

        if($tokenExist == null) {
            return redirect()->route('front.forgotPassword')->with('error','Invalid request');
        }

        return view('front.account.reset-password',[
            'token' => $token
        ]);
    }

    public function processResetPassword(Request $request) {
        $token = $request->token;

        $tokenObj = \DB::table('password_reset_tokens')->where('token',$token)->first();

        if($tokenObj == null) {
            return redirect()->route('front.forgotPassword')->with('error','Invalid request');
        }

        $user = User::where('email',$tokenObj->email)->first();

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ]);

        if($validator->fails()) {
            return redirect()->route('front.resetPassword',$token)->withErrors($validator);
        }

        User::where('id',$user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        \DB::table('password_reset_tokens')->where('email',$user->email)->delete();


        return redirect()->route('account.login')->with('success','You have successfully updated your password.');



    }

    public function wishlist() {
        $wishlists = Wishlist::where('user_id',Auth::user()->id)->with('book')->get();
        $data = [];
        $data['wishlists'] = $wishlists;
        return view('front.account.wishlist',$data);
    }

    public function removeBookFromWishlist(Request $request) {
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('book_id',$request->id)->first();
        if ($wishlist == null) {
            session()->flash('error', 'Book already removed');
            return response()->json([
                    'status' => false,
            ]);
        } else {
            Wishlist::where('user_id', Auth::user()->id)->where('book_id',$request->id)->delete();
            session()->flash('success', 'Book removed successfully.');
            return response()->json([
                    'status' => true,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\County;
use App\Models\SubCounty;
use App\Models\towns;
use App\Models\CustomerAddress;
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

        if ($validator->passes()) {
            // Create new user
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
        
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
                    return redirect()->route('account.profile'); 
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
        return view('front.account.profile');
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
}

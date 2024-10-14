<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Book;
use App\Models\County;
use App\Models\SubCounty;
use App\Models\Towns;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        $book = Book::with('book_images')->find($request->id);


        if ($book == null) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ]);
        }

        if (Cart::count() > 0) {
            //echo "Book already in cart";
            // Books found in cart
            // Check if thos book already in the cart
            // Return as message that book already added in your cart
            // If book not found in the cart, then add book in cart

            $cartContent = Cart::content();
            $bookAlreadyExists = false;

            foreach ($cartContent as $item) {
                if($item->id == $book->id) {
                   $bookAlreadyExists = true;
                }
            }

            if($bookAlreadyExists == false) {
                Cart::add($book->id, $book->title, 1, $book->price, ['bookImages' => (!empty
                ($book->book_images)) ? $book->book_images->first() : '']);

                $status = true;
                $message = '<strong>'.$book->title.'</strong> added in your cart successully.';
                session()->flash('success', $message);

            } else {
                $status = false;
                $message = $book->title.'already added in cart';
            }

        } else {
            Cart::add($book->id, $book->title, 1, $book->price, ['bookImages' => (!empty($book->book_images)) ? $book->book_images->first() : '']);
            $status = true;
            $message = '<strong>'.$book->title.'</strong> added in your cart successully.';
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);

    }

    public function cart() {
        $cartContent = Cart::content();
        //dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    } 

    public function updateCart(Request $request) {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $book = Book::find($itemInfo->id);
        //Check qty available in stock

        if ($book->track_qty == 'Yes') {
            if ($qty <= $book->qty ) {
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $status = true;
                session()->flash('success', $message);

            } else {
                 $message = 'Requested qty('.$qty.') not available in stock.';
                 $status = false;
                 session()->flash('error', $message);

            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Cart updated successfully';
            $status = true;
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request) {

        $itemInfo = Cart::get($request->rowId);

        if ($itemInfo == null) {
            $errorMessage = 'Item not found in cart';
            session()->flash('error', $errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Item removed from cart successfully.';
        session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        
    }

    public function checkout() {

        //--if cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        //--if user is not logged in then redirect to login page
        if (Auth::check() == false) {
            if(!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('account.login');
        }

        session()->forget('url.intended');

        $counties = County::orderBy('name', 'ASC')->get(); // Make sure the model also references the correct table
        $sub_counties = SubCounty::orderBy('name', 'ASC')->get(); 
        $towns = Towns::orderBy('name', 'ASC')->get(); 


        return view('front.checkout',[
            'counties' => $counties,
            'sub_counties' => $sub_counties,
            'towns' => $towns,
        ]);


        
    }

    public function processCheckout(Request $request) {

        //Step - 1 Apply Validation

        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required',
            'county' => 'required',
            'sub_county' => 'required',
            'town' => 'required',
            'mobile' => 'required',
            'address' => 'required|min:30',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        //Step - 2 save user address
        //$customerAddress = CustomerAddress::find();

        $user = Auth::user();


        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
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
    }
}


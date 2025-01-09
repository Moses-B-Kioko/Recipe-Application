<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail; 
use App\Mail\ContactEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;



class FrontController extends Controller
{
    public function index() {

        $books = Book::where('is_featured', 'Yes')
                ->orderBy('id','DESC')
                ->take(8)
                ->where('status',1)->get();
        $data['featuredBooks'] = $books;

        $latestBooks = Book::orderBy('id','DESC')
                ->where('status',1)
                ->take(8)->get();
        $data['latestBooks'] = $latestBooks;
        return view('front.home', $data);
    }

    public function page($slug) {
        $page = Page::where('slug',$slug)->first();
        if ($page == null) {
            abort(404);
        }
        return view('front.page',[
            'page' => $page
        ]);
        //dd($page);
    }

    public function sendContactEmail(Request $request) {
       $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10'
        ]);

        if ($validator->passes()) {

            //Send email here
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'You have received a contact email'
            ];

            $admin = User::where('id', 2)->first();

            Mail::to($admin->email)->send(new ContactEmail($mailData));

            session()->flash('success','Thanks for contacting us, we will get back to you soon');
            return response()->json([
                'status' => true,
            ]);

        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function addToWishlist(Request $request) {
        if(Auth::check()==false) {

            session(['url.intended' => url()->previous()]);

            return response()->json([
                'status' => false
            ]);
        }

        

        $book = Book::where('id',$request->id)->first();

        if ($book == null) {
            return response()->json([
                'status' => true,
                'message' => '<div class="alert-danger"> Book not found. </div>'
            ]);
        }

        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'book_id' => $request->id,
            ],
            [
                'user_id' => Auth::user()->id,
                'book_id' => $request->id,
            ]
        );

        /*$wishlist = new Wishlist;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->book_id = $request->id;
        $wishlist->save();*/
        

        return response()->json([
            'status' => true,
            'message' => '<div class="alert-success"><strong>"'.$book->title.'"</strong> added in your wishlist </div>'
        ]);
    }

    public function addBookToSellerAccount(Request $request) {

    }
}

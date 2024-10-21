<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Page;


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
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\SubGenre;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index (Request $request, $categorySlug = null, $subGenreSlug = null) {
        $categorySelected = '';
        $subGenreSelected = '';

        $categories = Category::orderBy('name', 'ASC')->with('sub_genre')->where('status',1)->get();

        $books = Book::where('status',1);

        //Apply filters here
        if(!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $books = $books->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        if(!empty($subGenreSlug )) {
            $subGenre = SubGenre::where('slug', $subGenreSlug)->first();
            $books = $books->where('sub_genre_id',$subGenre->id);
            $subGenreSelected = $subGenre->id;
        }

        if ($request->get('price_max') !='' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {
                $books = $books->whereBetween('price',[intval($request->get('price_min')), 1000000 ]);  
            } else {
                $books = $books->whereBetween('price',[intval($request->get('price_min')),intval
                ($request->get('price_max'))]);  
            }

        }
        
        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                $books = $books->orderBy('id', 'DESC');
            } else if($request->get('sort') == 'price_asc') {
                $books = $books->orderBy('price', 'ASC');
            } else {
                $books = $books->orderBy('price', 'DESC');
            }
        } else {
            $books = $books->orderBy('id', 'DESC');
        }

        $books = $books->paginate(6);

        $data['categories'] = $categories;
        $data['books'] = $books;
        $data['categorySelected'] = $categorySelected;
        $data['subGenreSelected'] = $subGenreSelected;
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 1000 : $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        
        return view('front.shop', $data);
    }

    public function book($slug) {
        $book = Book::where('slug', $slug)->with('book_images')->first();
        if($book == null) {
            abort(404);
        }

        $relatedBooks = [];
        // Fetch related books
        if($book->related_books != '') {
            $bookArray = explode(',',$book->related_books);
            $relatedBooks = Book::whereIn('id',$bookArray)->get();
        }

        $data['book'] = $book;
        $data['relatedBooks'] = $relatedBooks;
        return view('front.book', $data);

    }
}

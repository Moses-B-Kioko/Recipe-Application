<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\SubGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BookRating;


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

        if (!empty($request->get('search'))) {
            $books = $books->where('title','like','%'.$request->get('search').'%');  
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
        $book = Book::where('slug', $slug)
        ->withCount('book_ratings')
        ->withSum('book_ratings','rating')
        ->with(['book_images','book_ratings'])->first();

        if($book == null) {
            abort(404);
        }


        $relatedBooks = [];
        // Fetch related books
        if($book->related_books != '') {
            $bookArray = explode(',',$book->related_books);
            $relatedBooks = Book::whereIn('id',$bookArray)->where('status',1)->get();
        }

        $data['book'] = $book;
        $data['relatedBooks'] = $relatedBooks;

        //Rating Calculation
        // "book_ratings_count" => 2
        //"book_ratings_sum_rating" => 6.0
        $avgRating = '0.00';
        $avgRatingPer = 0;
        if ($book->book_ratings_count > 0) {
            $avgRating = number_format(($book->book_ratings_sum_rating/$book->book_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;


        return view('front.book', $data);

    }

    public function saveRating($id, Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required|min:10',
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $count = BookRating::where('email',$request->email)->count();
        if ($count > 0) {
            session()->flash('error','You already rated this book.');
            return response()->json([
                'status' => true,
            ]);
        }

        $bookRating = new BookRating;
        $bookRating->book_id = $id;
        $bookRating->username = $request->name;
        $bookRating->email = $request->email;
        $bookRating->comment = $request->comment;
        $bookRating->rating = $request->rating;
        $bookRating->status = 0;
        $bookRating->save();

        session()->flash('success','Thanks for your rating.');

        return response()->json([
            'status' => true,
            'message' => 'Thanks for your rating.'
        ]);
    }
}

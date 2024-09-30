<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubGenre;


class BookSubGenreController extends Controller
{
    public function index(Request $request) {
        if( !empty($request->category_id)) {
                    SubGenre::where('category_id',$request->category_id)
                ->orderBy('name', 'ASC')
                ->get();

                return response()->json([
                    'status' => true,
                    'subGenres' => $subGenres
                ]);
        } else {
            return response()->json([
                'status' => true,
                'subGenres' => []
            ]);
        }
    }
}

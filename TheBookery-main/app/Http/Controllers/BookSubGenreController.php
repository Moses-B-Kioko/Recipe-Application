<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubGenre;


class BookSubGenreController extends Controller
{

    public function index (Request $request) {
        if (!empty($request->category_id)) {
            // Fetch the sub-genres based on the category_id
            $subCategories = SubGenre::where('category_id', $request->category_id)
                ->orderBy('name', 'ASC')
                ->get();
    
            return response()->json([
                'status' => true,
                'subGenres' => $subCategories // Return correct variable
            ]);
        } else {
            return response()->json([
                'status' => false,
                'subGenres' => []
            ]);
        }
    }
    
    
}

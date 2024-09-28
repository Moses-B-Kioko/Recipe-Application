<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {
       // $products = Product::where('is_featured', 'Yes')->where('status',1)->get();
        //$data['featuredProducts'] = $products;
        return view('front.home');
    }
}

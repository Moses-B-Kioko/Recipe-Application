<?php

use App\Models\Category;

function getGenres(){
    return Category::orderBy('name', 'ASC')
    ->with('sub_genre')
    ->orderBy('id','DESC')
    ->where('status',1)
    ->where('showHome', 'Yes')
    ->get();
}
?>
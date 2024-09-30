<?php

use App\Models\Category;

function getGenres(){
    return Category::orderBy('name', 'ASC')
    ->with('sub_genre')
    ->where('status',1)
    ->where('showHome', 'Yes')
    ->get();
}
function getGenre(){
    return Category::orderBy('name', 'ASC');
}
?>
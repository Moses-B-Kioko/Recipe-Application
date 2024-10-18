<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubGenre;
class Category extends Model
{
    use HasFactory;


    public function sub_genre(){
        return $this->hasMany(SubGenre::class);
    }
}

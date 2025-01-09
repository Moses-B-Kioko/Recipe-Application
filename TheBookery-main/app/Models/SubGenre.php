<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGenre extends Model
{
    use HasFactory;
    protected $table = 'sub_genres';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

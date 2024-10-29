<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'book_id'];

    public function book() {
        return $this->belongsTo(Book::class);
    }
}

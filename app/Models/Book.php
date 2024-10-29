<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seller;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    public function book_images() {
        return $this->hasMany(BookImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subGenre()
    {
        return $this->belongsTo(SubGenre::class);
    }

    protected $fillable = ['title', 'author', 'price', 'genre', 'sub_genre', 'condition', 'quantity', 'status', 'seller_id'];

    public function seller() {
        return $this->belongsTo(User::class, 'user_id');  // Link book to the seller (User model)
    }

    public function book_ratings() {
        return $this->hasMany(BookRating::class)->where('status',1);
    }

    // Define the relationship to the Seller model
    /*public function seller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }*/



}

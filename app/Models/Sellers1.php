<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellers1 extends Model
{
    use HasFactory;
    protected $table = 'sellers1'; // Correct the table name here if needed

    public $fillable = ['user_id','book_id',];

    public function book() {
        return $this->belongsTo(Book::class);
    }
}

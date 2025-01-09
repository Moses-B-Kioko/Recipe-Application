<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function book()
{
    return $this->belongsTo(Book::class);
}


 // This relationship helps track which seller's books are in the order
 public function books() {
    return $this->hasManyThrough(Book::class, OrderItem::class);
}

public function user() {
    return $this->belongsTo(User::class);  // Assuming the relationship is with the User model
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellers2 extends Model
{
    use HasFactory;
    protected $table = 'sellers2'; // Correct the table name here if needed

    public $fillable = ['user_id','order_id',];

    public function order()
{
    return $this->hasOne(Order::class);
}
}

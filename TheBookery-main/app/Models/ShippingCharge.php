<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;
    protected $table = 'shipping_charges'; // Specify the table name if different from conventions
    protected $fillable = ['county_id', 'amount']; // Add fillable attributes if necessary
}

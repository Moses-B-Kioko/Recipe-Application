<?php

use App\Models\Category;
use App\Models\BookImage;
use App\Models\Order;
use App\Mail\OrderEmail;
use App\Models\County;
use Illuminate\Support\Facades\Mail;

function getGenres(){
    return Category::orderBy('name', 'ASC')
    ->with('sub_genre')
    ->orderBy('id','DESC')
    ->where('status',1)
    ->where('showHome', 'Yes')
    ->get();
}

function getBookImage($bookId){
    return BookImage::where('book_id',$bookId)->first();
}

function orderEmail($orderId, $userType="customer") {
    $order = Order::where('id',$orderId)->with('items')->first();

    if ($userType == 'customer') {
        $subject = 'Thanks for your order';
        $email = $order->email;
    } else {
        $subject = 'You have received an order';
        $email =env('ADMIN_EMAIL');

    }


    $mailData = [
        'subject' => $subject,
        'order' => $order,
        'userType' => $userType
    ];

    Mail::to($email)->send(new orderEmail($mailData));
    //dd($order);
}

function getCountyInfo ($id) {
    return County::where('id',$id)->first();
}
?>
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\County;
use App\Models\ShippingCharge;
use App\Models\User;
use App\Models\TempImage; // Import TempImage model
use Carbon\Carbon; 
use Illuminate\Support\Facades\File;



class DashboardController extends Controller
{
    public function index() {
        // Fetch total sales (grand_total) grouped by date
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Extract book date and total
        $labels = $salesData->pluck('date');
        $values = $salesData->pluck('total');

        // Get the top-selling books by joining the books table
        $topSellingBooks = OrderItem::join('books', 'order_items.book_id', '=', 'books.id')
            ->select('books.title', DB::raw('SUM(order_items.qty) as total_sales'))
            ->groupBy('books.title')
            ->orderBy('total_sales', 'desc')
            ->limit(10) // Adjust as necessary
            ->get();

        // Extract book titles and sales values
        $bookLabels = $topSellingBooks->pluck('title');
        $bookValues = $topSellingBooks->pluck('total_sales');

        // Get sales by category by joining categories and books tables
        $salesByCategory = OrderItem::join('books', 'order_items.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.qty) as total_sales'))
            ->groupBy('categories.name')
            ->orderBy('total_sales', 'desc')
            ->get();

        // Extract category names and sales values
        $categoryLabels = $salesByCategory->pluck('name');
        $categoryValues = $salesByCategory->pluck('total_sales');

         // Fetch average shipping cost per county
         $shippingCosts = ShippingCharge::join('county', 'shipping_charges.county_id', '=', 'county.id')
         ->select('county.name', DB::raw('AVG(shipping_charges.amount) as avg_shipping_cost'))
         ->groupBy('county.name')
         ->orderBy('avg_shipping_cost', 'desc')
         ->get();

     $countyLabels = $shippingCosts->pluck('name');
     $countyValues = $shippingCosts->pluck('avg_shipping_cost');

     //Cards
     $totalSales = Order::sum('grand_total');
     $totalOrders = Order::count();
     $totalUsers = User::count();
     $bestCategory = OrderItem::join('books', 'order_items.book_id', '=', 'books.id')
    ->join('categories', 'books.category_id', '=', 'categories.id')
    ->select('categories.name', DB::raw('SUM(order_items.qty) as total_sales'))
    ->groupBy('categories.name')
    ->orderBy('total_sales', 'DESC')
    ->first(); // Get the top category only

//echo $bestCategory->name; // Output only the category name

    //Delete temp images here

    $dayBeforeToday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
    $tempImages = TempImage::where('created_at','<=',$dayBeforeToday)->get();

    foreach ($tempImages as $tempImage) {
         $path = public_path('/temp/'.$tempImage->name);
         $thumbPath = public_path('/temp/thumb/'.$tempImage->name);

         //Delete Main Image
         if (File::exists($path)) {
            File::delete($path);
         }

        //Delete Thumb Image
         if (File::exists($thumbPath)) {
            File::delete($thumbPath);
         }

         TempImage::where('id',$tempImage->id)->delete();
        
        //
    }

     // Get revenue by county (total grand_total by county)
     $revenueByCounty = Order::join('county', 'orders.county_id', '=', 'county.id')
     ->select('county.name as county_name', DB::raw('SUM(orders.grand_total) as total_revenue'))
     ->groupBy('county.id', 'county.name')
     ->orderByDesc('total_revenue')
     ->get();

    // Prepare labels and data for the chart
    $countyLabels = $revenueByCounty->pluck('county_name');
    $countyRevenue = $revenueByCounty->pluck('total_revenue');



        return view('admin.dashboard', compact('labels', 'values', 'bookLabels', 'bookValues', 'categoryLabels', 'categoryValues', 'countyLabels', 'countyValues', 'countyRevenue','totalSales','totalOrders','bestCategory','totalUsers'));
    }
}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToSellers1Table extends Migration
{
    public function up()
    {
        Schema::table('sellers1', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('book_id'); // Place after book_id
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); // Set foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('sellers1', function (Blueprint $table) {
            $table->dropForeign(['order_id']); // Drop foreign key
            $table->dropColumn('order_id'); // Drop order_id column
        });
    }
}

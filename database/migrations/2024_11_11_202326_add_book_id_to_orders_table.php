<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->nullable()->after('user_id'); // Replace 'id' with the column after which you want this to appear
            
            // If 'book_id' is a foreign key referencing 'books' table
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });
    }    
};

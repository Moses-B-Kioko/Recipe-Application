<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    Schema::table('books', function (Blueprint $table) {
        $table->dropForeign(['seller_id']); // Drop the foreign key constraint
        $table->dropColumn('seller_id');    // Drop the seller_id column
    });
    }
};

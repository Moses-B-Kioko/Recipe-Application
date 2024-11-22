<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBooksTableForeignKey extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Drop the existing foreign key and column if needed
            $table->dropForeign(['seller_id']); // Drop the old foreign key
            // Ensure the `seller_id` column still exists
            // If the column doesn't exist, uncomment the line below:
            // $table->unsignedBigInteger('seller_id')->nullable()->change();
            
            // Add the new foreign key referencing the `users` table
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['seller_id']);
            
            // Optionally, add back the old foreign key referencing the `sellers` table
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }
}

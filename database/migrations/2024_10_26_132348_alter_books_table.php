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
            // Drop the foreign key constraint first
            $table->dropForeign(['seller_id']);
            // Then drop the seller_id column
            $table->dropColumn('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Re-add the seller_id column with the foreign key constraint
            $table->foreignId('seller_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};

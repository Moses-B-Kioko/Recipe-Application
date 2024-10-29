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
            $table->foreignId('seller_id')
                  ->nullable()
                  ->after('id') // Position the column after 'id'
                  ->constrained('sellers') // Reference the 'sellers' table
                  ->onDelete('cascade'); // Delete associated records on seller deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['seller_id']); // Drop the foreign key constraint
            $table->dropColumn('seller_id'); // Drop the column
        });
    }
};

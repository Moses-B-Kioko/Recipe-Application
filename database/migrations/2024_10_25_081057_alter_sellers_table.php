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
        Schema::table('sellers', function (Blueprint $table) {
            // Check if the 'user_id' column does not exist before adding
            if (!Schema::hasColumn('sellers', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Adding user_id
            }

            // If you want to add other fields, you can do so here
            // For example:
            // $table->string('address')->nullable();
            // $table->string('inventory')->nullable();
            // $table->string('additionalInfo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Drop the foreign key constraint first before dropping the column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); // Remove user_id column
        });
    }
};

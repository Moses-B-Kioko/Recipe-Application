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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('description')->nullable();
            $table->double('price', 10, 2);
            $table->double('compare_price', 10, 2)->nullable();
            // Make sure this matches the categories table
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            // Make sure this matches the sub_genres table
            $table->foreignId('sub_genre_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('is_featured', ['Yes', 'No'])->default('No');
            $table->string('Condition');
            $table->enum('track_qty', ['Yes', 'No'])->default('Yes');
            $table->integer('qty')->nullable();
            $table->integer('status')->default(1);
            //$table->unsignedBigInteger('seller_id')->nullable();
            // Ensure seller_id references the correct type in the sellers table
            //$table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

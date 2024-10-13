<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->unique->name();
        $author = fake()->unique->name();
        $slug = Str::slug($title);

        $subGenres = [10,11];
        $subCatRandKey = array_rand($subGenres);

        return [
            'title' => $title,
            'author' => $author,
            'category_id' => 112,
            'sub_genre_id' => $subGenres[$subCatRandKey],
            'price' => rand(10, 1000),
            'track_qty' => 'Yes',
            'qty' => 10,
            'is_featured' => 'Yes',
            'Condition' => 'Good',
            'status' => 1,
            'slug' => $slug
        ];
    }
}

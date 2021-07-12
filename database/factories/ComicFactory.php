<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Comic;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $author = Author::inRandomOrder()->first();
        return [
            'title' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'tags' => '["asdf", "zxcv"]',
            'genres' => '["asdf", "zxcv"]',
            'author_id' => $author,
            'price' => $this->faker->randomFloat(2, 0, 10),
            'cover_url' => '/storage/media/covers/cover.jpg'
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Comic;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $comic = Comic::inRandomOrder()->first()->id;
        return [
            'page_number' => $this->faker->randomDigit(),
            'image_url' => '/storage/media/comics/pg1.jpg',
            'config' => 'tbd',
            'comic_id' => $comic
        ];
    }
}

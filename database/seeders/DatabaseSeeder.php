<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'ppramesi',
            'full_name' => 'Priya Pramesi',
            'email' => 'ppramesi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123qweasd'), // password
            'remember_token' => Str::random(10),
            'purchase_history' => '[]',
            'read_history' => '[]',
        ]);
        \App\Models\Author::factory(10)->create();
        \App\Models\Comic::factory(10)->create();
        \App\Models\Page::factory(50)->create();

        $comics = \App\Models\Comic::get();

        foreach($comics as $comic){
            $l = \App\Models\Author::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $comic->authors()->sync($l);
        }
    }
}

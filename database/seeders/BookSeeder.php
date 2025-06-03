<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 20) as $i) {
            DB::table('books')->insert([
                'title' => $faker->sentence(4),
                'isbn' => $faker->isbn13,
                'description' => $faker->paragraph(4),
                'author_id' => rand(1, 10), // ensure authors exist
                'category_id' => rand(1, 5), // ensure categories exist
                'total_copies' => $total = rand(1, 20),
                'available_copies' => rand(0, $total),
                'publication_date' => $faker->date(),
                'publisher' => $faker->company,
                'language' => $faker->randomElement(['English', 'Spanish', 'French', 'German', 'Chinese']),
                'pages' => rand(100, 800),
                'cover_image' => $faker->imageUrl(200, 300, 'books', true, 'Faker Book'),
                'price' => $faker->randomFloat(2, 5, 100),
                'status' => $faker->randomElement(['active', 'inactive', 'maintenance']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

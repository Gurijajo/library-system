<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Imaginative and creative literary works',
                'color' => '#3B82F6'
            ],
            [
                'name' => 'Science Fiction',
                'description' => 'Fiction dealing with futuristic concepts and advanced technology',
                'color' => '#8B5CF6'
            ],
            [
                'name' => 'Fantasy',
                'description' => 'Fiction involving magical or supernatural elements',
                'color' => '#10B981'
            ],
            [
                'name' => 'Mystery',
                'description' => 'Fiction dealing with puzzling or unexplained events',
                'color' => '#F59E0B'
            ],
            [
                'name' => 'Romance',
                'description' => 'Fiction focusing on romantic relationships',
                'color' => '#EC4899'
            ],
            [
                'name' => 'Thriller',
                'description' => 'Fast-paced fiction designed to hold readers in suspense',
                'color' => '#EF4444'
            ],
            [
                'name' => 'Young Adult',
                'description' => 'Fiction targeted at teenage and young adult readers',
                'color' => '#06B6D4'
            ],
            [
                'name' => 'Classic Literature',
                'description' => 'Enduring works of literary fiction from past eras',
                'color' => '#84CC16'
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('Created categories successfully!');
    }
}
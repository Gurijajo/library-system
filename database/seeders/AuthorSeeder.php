<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'F. Scott Fitzgerald',
                'biography' => 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.',
                'nationality' => 'American',
                'birth_date' => '1896-09-24',
                'death_date' => '1940-12-21'
            ],
            [
                'name' => 'Harper Lee',
                'biography' => 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.',
                'nationality' => 'American',
                'birth_date' => '1926-04-28',
                'death_date' => '2016-02-19'
            ],
            [
                'name' => 'George Orwell',
                'biography' => 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.',
                'nationality' => 'British',
                'birth_date' => '1903-06-25',
                'death_date' => '1950-01-21'
            ],
            [
                'name' => 'Jane Austen',
                'biography' => 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.',
                'nationality' => 'British',
                'birth_date' => '1775-12-16',
                'death_date' => '1817-07-18'
            ],
            [
                'name' => 'J.D. Salinger',
                'biography' => 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.',
                'nationality' => 'American',
                'birth_date' => '1919-01-01',
                'death_date' => '2010-01-27'
            ],
            [
                'name' => 'William Golding',
                'biography' => 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.',
                'nationality' => 'British',
                'birth_date' => '1911-09-19',
                'death_date' => '1993-06-19'
            ],
            [
                'name' => 'J.R.R. Tolkien',
                'biography' => 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.',
                'nationality' => 'British',
                'birth_date' => '1892-01-03',
                'death_date' => '1973-09-02'
            ],
            [
                'name' => 'J.K. Rowling',
                'biography' => 'British author best known for the Harry Potter fantasy series.',
                'nationality' => 'British',
                'birth_date' => '1965-07-31',
                'death_date' => null
            ],
            [
                'name' => 'Dan Brown',
                'biography' => 'American author best known for his thriller novels including The Da Vinci Code.',
                'nationality' => 'American',
                'birth_date' => '1964-06-22',
                'death_date' => null
            ],
            [
                'name' => 'Paulo Coelho',
                'biography' => 'Brazilian lyricist and novelist, best known for his novel The Alchemist.',
                'nationality' => 'Brazilian',
                'birth_date' => '1947-08-24',
                'death_date' => null
            ],
            [
                'name' => 'Suzanne Collins',
                'biography' => 'American television writer and author, best known for The Hunger Games trilogy.',
                'nationality' => 'American',
                'birth_date' => '1962-08-10',
                'death_date' => null
            ],
            [
                'name' => 'Aldous Huxley',
                'biography' => 'English writer and philosopher, best known for his dystopian novel Brave New World.',
                'nationality' => 'British',
                'birth_date' => '1894-07-26',
                'death_date' => '1963-11-22'
            ]
        ];

        foreach ($authors as $authorData) {
            Author::create($authorData);
        }

        $this->command->info('Created authors successfully!');
    }
}
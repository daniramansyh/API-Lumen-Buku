<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'title' => $this->faker->name,
            'publisher_id' => Uuid::uuid4()->toString(),
            'author_id' => Uuid::uuid4()->toString(),
            'publication_year'=> $this->faker->year,
            'isbn' => $this->faker->isbn13,
            'genre_id' => $this->faker->uuid,
            'pages' => $this->faker->numberBetween(100, 1000),
            'language' => $this->faker->languageCode,
            'edition' => $this->faker->word,
            'synopsis' => $this->faker->text,
        ];
    }
}

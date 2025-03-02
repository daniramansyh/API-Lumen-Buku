<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->word,
        ];
    }
}

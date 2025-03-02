<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->name,
            'region' => $this->faker->country,
            'birth_date' => $this->faker->date('Y-m-d'),
            'death_date' => $this->faker->optional()->date('Y-m-d'),
            'education' => $this->faker->optional()->sentence,
            'awards' => $this->faker->optional()->sentence,
            'writing_style' => $this->faker->word,
        ];
    }
}

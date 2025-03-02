<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class PublisherFactory extends Factory
{
    protected $model = Publisher::class;

    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->name,
            'founded_year' => $this->faker->year,
            'founder' => $this->faker->name,
            'headquarters' => $this->faker->city,
            'website' => $this->faker->url,
        ];
    }
}

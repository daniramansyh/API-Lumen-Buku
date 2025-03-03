<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $borrowDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $returnDate = $this->faker->boolean(70) ? $this->faker->dateTimeBetween($borrowDate, 'now') : null;
        $status = $returnDate ? Transaction::RETURNED : Transaction::BORROWED;

        return [
            "id" => Uuid::uuid4()->toString(),
            "book_id" => Book::inRandomOrder()->first()->id ?? Book::factory()->create()->id,
            "user_id" => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            "borrow_date" => $borrowDate,
            "return_date" => $returnDate,
            "status" => $status,
        ];
    }
}

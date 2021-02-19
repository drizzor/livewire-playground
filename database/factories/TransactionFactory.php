<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => "Payment to " . $this->faker->name,
            'amount' => $this->faker->numberBetween(15, 999),
            'status' => $this->faker->randomElement(['processing', 'success', 'failed']),
        ];
    }
}

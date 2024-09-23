<?php

namespace Database\Factories;

use App\Models\Recipient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credit>
 */
class CreditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipient_id' => Recipient::factory(),
            'amount' => fake()->numberBetween(1, 80000),
            'term_in_months' => fake()->numberBetween($min = 3, $max = 120),
            'created_at' => fake()->dateTimeBetween($startDate = '-2 year', $endDate = 'now'),
        ];
    }
}
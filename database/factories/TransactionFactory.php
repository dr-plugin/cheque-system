<?php

namespace Database\Factories;

use App\Enums\TransactionColumn;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionFactory extends Factory
{

    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            TransactionColumn::UserId->value            => User::factory(),
            TransactionColumn::Amount->value            => fake()->numberBetween(1000, 95000),
            TransactionColumn::Desc->value              => fake()->text(100),
            TransactionColumn::Type->value              => fake()->randomElement(['wallet_charge', 'inquiry_fee', 'plan_purchase']),
            TransactionColumn::TransactionId->value     => fake()->lexify('????????'),
            TransactionColumn::Status->value            => 'pending'
        ];
    }
}

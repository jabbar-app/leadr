<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $isRecurring = $this->faker->boolean(30); // 30% chance tugas berulang
        $recurringType = $isRecurring
            ? $this->faker->randomElement(['daily', 'weekly', 'monthly'])
            : null;

        return [
            'organization_id' => Organization::factory(), // make sure you have OrganizationFactory
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph,
            'due_date' => $isRecurring ? null : $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'score' => $this->faker->numberBetween(10, 100),
            'is_recurring' => $isRecurring,
            'recurring_type' => $recurringType,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'username' => $this->faker->unique()->userName,
            'api_url' => $this->faker->url,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '62' . $this->faker->numerify('8#########'),
        ];
    }
}

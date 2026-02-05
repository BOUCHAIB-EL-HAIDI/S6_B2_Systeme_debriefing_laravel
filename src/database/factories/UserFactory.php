<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'STUDENT',
            'classe_id' => null,
        ];
    }

    // Custom state for admin
    public function admin()
    {
        return $this->state([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN',
            'classe_id' => null,
        ]);
    }
}

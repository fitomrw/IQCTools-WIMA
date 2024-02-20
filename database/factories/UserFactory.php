<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ['Admin QC', 'Staff QC', 'Kepala Seksi QC', 'Staff QA'],
            'jabatan' => ['Admin QC', 'Staff QC', 'Kepala Seksi QC', 'Staff QA'],
            'username' => ['adminqc', 'staffqc', 'kepalaseksiqc', 'staffqa'],
            'email' => ['adminqc@gmail.com', 'staffqc@gmail.com', 'kepalaseksiqc@gmail.com', 'staffqa@gmail.com'],
            'email_verified_at' => now(),
            'password' => Hash::make(['adminqc', 'staffqc', 'kepalaseksiqc', 'staffqa']), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

// '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
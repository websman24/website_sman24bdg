<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => fake()->sentence(4),
            'category' => fake()->randomElement(['SPMB', 'Kurikulum', 'Panduan', 'Formulir']),
            'file_path' => 'documents/sample.pdf',
            'file_size' => fake()->numberBetween(100000, 5000000),
            'file_type' => 'pdf',
            'download_count' => fake()->numberBetween(0, 100),
            'description' => fake()->sentence(),
        ];
    }
}

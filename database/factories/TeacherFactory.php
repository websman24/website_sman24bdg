<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('19################'),
            'name' => fake()->name(),
            'title_prefix' => fake()->randomElement(['Drs.', 'Dra.', 'H.', 'Hj.', null]),
            'title_suffix' => fake()->randomElement(['S.Pd.', 'M.Pd.', 'S.Si.', 'M.Si.', null]),
            'subject' => fake()->randomElement(['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Indonesia', 'Bahasa Inggris', 'Sejarah', 'Ekonomi']),
            'gender' => fake()->randomElement(['L', 'P']),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }
}

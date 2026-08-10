<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sman24bdg.sch.id'],
            [
                'name' => 'Administrator SMAN 24',
                'password' => \Illuminate\Support\Facades\Hash::make('Password24!'),
                'role' => 'admin',
            ]
        );
    }
}

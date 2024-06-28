<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        TaskStatus::factory()->createMany([
            ['name' => 'новая'],
            ['name' => 'завершена'],
            ['name' => 'выполняется'],
            ['name' => 'в архиве']
        ]);
    }
}

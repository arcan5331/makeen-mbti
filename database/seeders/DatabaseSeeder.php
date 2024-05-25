<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $mbtiJson = json_decode(File::get(database_path('seeders/mbti.json')));
        Test::create([
            'name' => 'mbti',
            'questions' => $mbtiJson->questions,
            'answers' => $mbtiJson->answers,
            'types_data' => $mbtiJson->types_data
        ]);
    }
}

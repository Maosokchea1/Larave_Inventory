<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // កំណត់គណនីរបស់អ្នកឱ្យក្លាយជា Admin ស្វ័យប្រវត្តិ
        User::updateOrCreate(
            ['email' => 'mrrsokchea0@gmail.com'], // ⚠️ ដូរដាក់អ៊ីមែលពិតរបស់អ្នកដែលកំពុង Login
            [
                'name' => 'Mao Sokchea',
                'role' => 'admin', // បង្ខំសិទ្ធិជា admin
            ]
        );
    }
}
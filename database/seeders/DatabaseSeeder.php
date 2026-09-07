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
        // បង្កើត ឬអាប់ដេតគណនី Admin របស់អ្នកដោយស្វ័យប្រវត្តិតាមអ៊ីមែល
        User::updateOrCreate(
            ['email' => 'mrrsokchea0@gmail.com'], // ដាក់អ៊ីមែលដែលអ្នកកំពុង Login ទីនេះ
            [
                'name' => 'Mao Sokchea',
                'password' => Hash::make('password123'),
                'role' => 'admin', // កំណត់សិទ្ធិជា admin ផ្ទាល់
            ]
        );
    }
}
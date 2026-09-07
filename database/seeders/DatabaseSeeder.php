<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // បង្កើត ឬអាប់ដេតគណនី Admin របស់អ្នកដោយស្វ័យប្រវត្តិ
        User::updateOrCreate(
            ['email' => 'mrrsokchea0@gmail.com'], // ឆ្កឹះពិនិត្យតាម Email របស់អ្នក
            [
                'name' => 'Mao Sokchea',
                'password' => Hash::make('password123'), // អ្នកអាចប្តូរពាក្យសម្ងាត់តាមតម្រូវការ
                'role' => 'admin', // កំណត់សិទ្ធិជា Admin ផ្ទាល់
            ]
        );

        // (ជាជម្រើស) បន្ថែម Test User ធម្មតា
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
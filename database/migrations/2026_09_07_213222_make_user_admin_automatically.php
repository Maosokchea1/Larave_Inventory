<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        // ធ្វើការ Update ឬ បង្កើត Admin ស្វ័យប្រវត្តិរាល់ពេល Migrate
        User::updateOrCreate(
            ['email' => 'mrrsokchea0@gmail.com'], // ដាក់អ៊ីមែលរបស់អ្នកទីនេះ
            [
                'name' => 'Mao Sokchea',
                'role' => 'admin', // បង្ខំឱ្យaccount នេះក្លាយជា Admin ភ្លាម
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
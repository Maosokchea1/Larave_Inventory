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
        User::updateOrCreate(
            ['email' => 'mrrsokchea0@gmail.com'], // ⚠️ ដាក់អ៊ីមែលដដែលឱ្យដូចគ្នា
            [
                'role' => 'admin',
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
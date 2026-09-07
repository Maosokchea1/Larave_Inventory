<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; // កុំភ្លេចហៅ Model User មកប្រើ

return new class extends Migration
{
    public function up(): void
    {
        // ប្ដូរ Email ខាងក្រោមឱ្យចំជាមួយ Email ដែលអ្នក Login លើ Render
        User::where('email', 'mrrsokchea@gmail.com')->update([
            'role' => 'admin'
        ]);
    }

    public function down(): void
    {
        //
    }
};
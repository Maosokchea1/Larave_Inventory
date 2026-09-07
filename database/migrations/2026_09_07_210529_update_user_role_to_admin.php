<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // ដាក់ Email ដែលកំពុង Login លើ Render ផ្ទាល់
        User::where('email', 'mrrsokchea0@gmail.com')->update([
            'role' => 'admin'
        ]);
    }

    public function down(): void
    {
        //
    }
};
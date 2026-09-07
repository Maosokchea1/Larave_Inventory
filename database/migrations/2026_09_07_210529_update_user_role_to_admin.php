<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        try {
            User::where('email', 'mrrsokchea0@gmail.com')->update([
                'role' => 'admin'
            ]);
        } catch (\Exception $e) {
            // ការពារកុំឱ្យ Crash ប្រសិនបើ Table មិនទាន់រួចរាល់
        }
    }

    public function down(): void
    {
        //
    }
};
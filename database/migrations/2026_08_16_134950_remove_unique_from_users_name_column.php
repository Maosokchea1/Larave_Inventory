<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // គ្មានអ្វីត្រូវលុបទេ ព្រោះ name មិនមាន unique constraint ទេ
    }

    public function down(): void
    {
        // 
    }
};
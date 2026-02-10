<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_checklists', function (Blueprint $table) {
            // Kita tambahkan kolom notes (boleh kosong/nullable)
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_checklists', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
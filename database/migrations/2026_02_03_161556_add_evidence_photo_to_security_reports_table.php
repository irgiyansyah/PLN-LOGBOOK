<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('security_reports', function (Blueprint $table) {
        $table->string('evidence_photo')->nullable(); // Kolom untuk simpan path foto
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('security_reports', function (Blueprint $table) {
            //
        });
    }
};

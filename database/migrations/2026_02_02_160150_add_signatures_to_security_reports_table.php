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
        // Kita pakai longText karena data gambar base64 itu sangat panjang
        $table->longText('signature_from')->nullable(); // TTD Penyerah
        $table->longText('signature_to')->nullable();   // TTD Penerima
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

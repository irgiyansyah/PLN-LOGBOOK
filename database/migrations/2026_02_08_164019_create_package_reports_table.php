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
    Schema::create('package_reports', function (Blueprint $table) {
        $table->id();
        $table->string('item_name'); // Kolom BARANG
        $table->string('condition')->default('Baik'); // Kolom KONDISI
        $table->string('receiver_name'); // Kolom PENERIMA
        $table->date('received_date'); // Kolom TANGGAL
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_reports');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_checklists', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Tanggal
            $table->string('driver_name'); // Nama Driver
            $table->string('license_plate'); // No Polisi
            $table->string('vehicle_type'); // Motor/Mobil
            $table->time('time_in'); // Jam Masuk
            $table->time('time_out')->nullable(); // Jam Keluar (Boleh kosong)
            $table->text('remarks')->nullable(); // Keterangan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_checklists');
    }
};
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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Tamu
            $table->string('institution')->nullable(); // Instansi
            $table->text('purpose'); // Tujuan
            $table->string('phone')->nullable(); // No HP
            $table->date('visit_date'); // Tanggal Kunjungan
            $table->longText('signature')->nullable(); // Tanda Tangan
            $table->string('photo')->nullable(); // Foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }


    //Untuk Menampilkan data relasi pada model GuestBook
    /*public function visit_data()
    {
        return $this->hasMany(GuestBook::class, 'visit_date', 'visit_date');
        Schema::dropIfExists(
            'guest_books'
        )
            $table->date('visit_date;')
            $table->string('namae')
            $table->longtext("signature")
            $table->string('received_by')
            $table->longtext('leave_date')
            $table->string ('photo')

    }*/


};

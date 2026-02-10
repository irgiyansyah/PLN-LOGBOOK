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
    Schema::create('security_reports', function (Blueprint $table) {
        $table->id();
        $table->date('report_date');
        $table->enum('shift', ['Pagi', 'Sore', 'Malam']);
        $table->time('start_time');
        $table->time('end_time');
        $table->string('handover_from'); // Yang Menyerahkan
        $table->string('handover_to');   // Yang Menerima
        $table->string('area_status')->default('Aman');
        $table->text('general_notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_reports');
    }
};

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
    Schema::create('security_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('security_report_id')->constrained('security_reports')->cascadeOnDelete();
        $table->time('log_time');
        $table->text('description');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_activities');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('medication_id');
            $table->string('dose', 50);
            $table->string('frequency', 80);
            $table->string('duration', 80);
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('Activa');
            $table->string('vet', 100)->nullable();
            $table->date('date');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('prescriptions'); }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('vet_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date');
            $table->string('type', 80);
            $table->text('diagnosis');
            $table->text('treatment');
            $table->text('notes')->nullable();
            $table->decimal('weight', 6, 2)->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};

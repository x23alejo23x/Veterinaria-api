<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('species', 50);
            $table->string('breed', 100);
            $table->unsignedSmallInteger('age');
            $table->decimal('weight', 6, 2);
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->string('status', 20)->default('activo');
            $table->string('avatar_color', 30)->default('blue');
            $table->date('next_visit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consulta_hospitalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas')->cascadeOnDelete();
            $table->unique('consulta_id');
            $table->integer('days')->default(1);
            $table->decimal('price_per_day', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consulta_hospitalizations');
    }
};

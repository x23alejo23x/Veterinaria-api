<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('category', 60);
            $table->unsignedInteger('stock')->default(0);
            $table->string('unit', 20);
            $table->decimal('price', 12, 2);
            $table->string('supplier', 100);
            $table->date('expiry_date')->nullable();
            $table->string('status', 20)->default('disponible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};

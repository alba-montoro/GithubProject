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
        Schema::create('profesor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 130);
            $table->string('especialidad', 100);
            $table->date('fechalta')->nullable();
            $table->decimal('salario', 10, 2)->nullable();
            $table->timestamps();
            // No va a poder existir dos profesores con el mismo nom y apell
            $table->unique(['nombre', 'apellidos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor');
    }
};

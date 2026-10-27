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
        Schema::create('matricula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id');
            $table->foreignId('modulo_id');
            $table->decimal('nota', 4, 2)->nullable;
            $table->unsignedSmallInteger('curso');
            $table->timestamps();
            // Un mismo alumno no se puede matricular dos veces en el mismo curso 
            $table->unique(['alumno_id', 'modulo_id', 'curso']);
            // Metemos los constraints
            $table->foreign('alumno_id')->references('id')->on('alumno')->onDelete('cascade');  // Se borran todos
            $table->foreign('modulo_id')->references('id')->on('modulo')->onDelete('restrict'); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula');
    }
};

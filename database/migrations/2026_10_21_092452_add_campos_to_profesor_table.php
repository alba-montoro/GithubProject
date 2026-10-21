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
        Schema::table('profesor', function (Blueprint $table) {
        $table->string('nombre', 100);
        $table->string('apellidos', 130);
        $table->string('especialidad', 100)->nullable();
        $table->date('fechalta')->nullable();
        $table->decimal('salario', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profesor', function (Blueprint $table) {
            $table->dropColumn([
            'nombre',
            'apellidos',
            'especialidad',
            'fechalta',
            'salario',
            ]);
        });
    }
};

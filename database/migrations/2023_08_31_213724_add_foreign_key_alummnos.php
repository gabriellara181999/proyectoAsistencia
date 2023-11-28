<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            //
            $table->foreignId('ciclo_id')->constrained('ciclos')->onDelete('cascade');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->foreignId('materiaInscrita_id')->constrained('materia_inscritas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            //
            $table->dropColumn('ciclo_id')->onDelete('cascade');
            $table->dropColumn('carrera_id')->onDelete('cascade');
            $table->dropColumn('materiaInscrita_id')->onDelete('cascade');
        });
    }
};

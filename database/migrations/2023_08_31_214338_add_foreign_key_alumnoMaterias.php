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
        Schema::table('alumnoMaterias', function (Blueprint $table) {
            //
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnoMaterias', function (Blueprint $table) {
            //
            $table->dropColumn('alumno_id')->onDelete('cascade');
            $table->dropColumn('materia_id')->onDelete('cascade');
        });
    }
};

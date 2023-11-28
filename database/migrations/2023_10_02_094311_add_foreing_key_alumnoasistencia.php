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
        Schema::table('alumnoasistencias', function (Blueprint $table) {
            //
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('estadoAlumno_id')->constrained('estadoAlumnoAsistencias')->onDelete('cascade');
            $table->foreignId('asistencia_id')->constrained('asistencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnoasistencias', function (Blueprint $table) {
            //
            $table->dropColumn('alumno_id')->onDelete('cascade');
            $table->dropColumn('estadoAlumno_id')->onDelete('cascade');
            $table->dropColumn('asistencia_id')->onDelete('cascade');
        });
    }
};

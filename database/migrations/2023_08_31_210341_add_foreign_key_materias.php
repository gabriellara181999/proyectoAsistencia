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
        Schema::table('materias', function (Blueprint $table) {
            //
            $table->foreignId('ciclo_id')->constrained('ciclos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->foreignId('diaHorario_id')->constrained('dia_horarios')->onDelete('cascade');
            $table->foreignId('diaHorario_idv2')->nullable()->constrained('dia_horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materias', function (Blueprint $table) {
            //
            $table->dropColumn('ciclo_id')->onDelete('cascade');
            $table->dropColumn('user_id')->onDelete('cascade');
            $table->dropColumn('carrera_id')->onDelete('cascade');
            $table->dropColumn('diaHorario_id')->onDelete('cascade');
            $table->dropColumn('diaHorario_idv2')->onDelete('cascade');
        });
    }
};

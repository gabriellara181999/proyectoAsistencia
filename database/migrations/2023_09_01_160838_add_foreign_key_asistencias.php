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
        Schema::table('asistencias', function (Blueprint $table) {
            //
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('Qr_id')->constrained('qrs')->onDelete('cascade');
            $table->foreignId('estado_id')->constrained('estados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            //
            $table->dropColumn('materia_id')->onDelete('cascade');
            $table->dropColumn('user_id')->onDelete('cascade');
            $table->dropColumn('Qr_id')->onDelete('cascade');
            $table->dropColumn('estado_id')->onDelete('cascade');
        });
    }
};

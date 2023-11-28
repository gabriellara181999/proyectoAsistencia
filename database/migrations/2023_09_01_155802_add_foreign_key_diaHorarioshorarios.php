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
        Schema::table('dia_horarios', function (Blueprint $table) {
            //
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dia_horarios', function (Blueprint $table) {
            //
            $table->dropColumn('horario_id')->onDelete('cascade');
        });
    }
};

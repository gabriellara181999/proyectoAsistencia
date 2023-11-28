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
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombreMateria', 100);
            $table->string('numero', 10);
            $table->string('requisito', 100);
            $table->string('unidadValorativa', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materias');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelDesempenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nivel_desempenos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->integer('puntaje')->default(0);
            $table->integer('ordenJerarquico');
            $table->float('puntaje_minimo',7,2)->default(0,0);
            $table->float('puntaje_maximo',7,2)->default(0,0);
            $table->unsignedBigInteger('id_dimension')->notnull();
            $table->foreign('id_dimension')->references('id')->on('dimensiones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nivel_desempenos');
    }
}

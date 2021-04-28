<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspectos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->integer('porcentaje');
            $table->float('puntaje_obtenido',7,2)->default(-1);
            $table->float('puntaje_minimo',7,2)->default(-1);
            $table->float('puntaje_maximo',7,2)->default(-1);
            $table->string('comentario')->default("");
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
        Schema::dropIfExists('aspectos');
    }
}

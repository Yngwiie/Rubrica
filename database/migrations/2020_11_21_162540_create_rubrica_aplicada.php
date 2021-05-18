<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricaAplicada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubrica_aplicada', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('escala_notas',40)->nullable();
            $table->string('tipo_puntaje')->default('unico');
            $table->float('version',10,3)->default(0,000);
            $table->float('nota',7,2)->default(-1);
            $table->float('nota_aprobativa',7,2)->default(4);
            $table->unsignedBigInteger('id_evaluacion')->nullable();
            $table->foreign('id_evaluacion')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->unsignedBigInteger('id_estudiante')->nullable();
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubrica_aplicada');
    }
}

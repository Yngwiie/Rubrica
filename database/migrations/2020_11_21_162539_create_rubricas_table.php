<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubricas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('escala_notas',40)->default('1-7');
            $table->string('tipo_puntaje')->default('unico');
            $table->float('version',10,3)->default(0,000);
            $table->float('nota_aprobativa',7,2)->nullable();
            $table->boolean('plantilla')->default(FALSE);
            $table->unsignedBigInteger('id_evaluacion')->nullable();
            $table->foreign('id_evaluacion')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubricas');
    }
}

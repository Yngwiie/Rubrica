<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteEvaluacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('nota',7,2)->default(-1);
            $table->unsignedBigInteger('id_estudiante')->notnull();
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->unsignedBigInteger('id_evaluacion')->notnull();
            $table->foreign('id_evaluacion')->references('id')->on('evaluaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiante_evaluacions');
    }
}

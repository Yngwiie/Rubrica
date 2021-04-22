<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('descripcion',2000)->nullable();
            $table->string('descripcion_avanzada',2000)->nullable();
            $table->boolean('deshabilitado')->default(FALSE);
            $table->boolean('aplicado')->default(FALSE);
            $table->integer('last_id_subcriterio')->default(0);
            $table->unsignedBigInteger('id_aspecto')->notnull();
            $table->foreign('id_aspecto')->references('id')->on('aspectos')->onDelete('cascade');
            $table->unsignedBigInteger('id_nivel')->notnull();
            $table->foreign('id_nivel')->references('id')->on('nivel_desempenos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterios');
    }
}

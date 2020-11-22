<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimensiones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre',60);
            $table->unsignedBigInteger('id_rubrica')->notnull();
            $table->foreign('id_rubrica')->references('id')->on('rubricas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimensions');
    }
}

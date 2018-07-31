<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniformeElemento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('servicios_uniforme_elemento', function (Blueprint $table) {
        $table->increments('id');
        $table->string('delegacion');
        $table->integer('calzado');
        $table->integer('camisa');
        $table->integer('pantalon');
        $table->integer('chamarra');
        $table->bigInteger('id_elemento');
        $table->string('tipo_uniforme')->nullable();
        $table->boolean('comisionado')->default(false);
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
        Schema::dropIfExists('servicios_uniforme_elemento');
    }
}

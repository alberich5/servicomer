<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EdicionUniformeElemento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_edicion_uniforme_elemento', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('uniforme_elemento_id');
        $table->integer('usuario_edicion');
        $table->timestamp('fecha_edicion');
        $table->boolean('calzado')->default(false);
        $table->boolean('camisa')->default(false);
        $table->boolean('pantalon')->default(false);
        $table->boolean('chamarra')->default(false);
        $table->boolean('tipo_uniforme')->default(false);
        $table->boolean('comisionado')->default(false);
        $table->string('detalle');
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
        Schema::dropIfExists('servicios_edicion_uniforme_elemento');
    }
}

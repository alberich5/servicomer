<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_cliente', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('num_cliente')->nullable();
          $table->string('razon_social');
          $table->string('domicilio_fiscal');
          $table->string('nombre_comercial');
          $table->boolean('estatus');
          $table->date('fecha_alta')->nullable();
          $table->boolean('activo');
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comerc_cliente');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccesoAccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_acceso_accion', function (Blueprint $table) {
            $table->bigInteger('id_usuario');
            $table->bigInteger('id_acceso');
            $table->bigInteger('id_accion');
            $table->text('detalle');
            $table->timestamp('fecha');
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
        Schema::dropIfExists('admin_acceso_accion');
    }
}

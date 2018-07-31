<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Acceso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_acceso', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_usuario')->default(0);
            $table->string('ip')->nullable();
            $table->timestamp('fecha_acceso');
            $table->timestamp('fecha_exit')->nullable();
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
        Schema::dropIfExists('admin_acceso');
    }
}

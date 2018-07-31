<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Departamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rh_departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_departamento_depende')->nullable();
            $table->string('titular');
            $table->string('cargo_titular');
            $table->string('abreviatura');
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
        Schema::dropIfExists('rh_departamento');
    }
}

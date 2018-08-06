<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioGiro extends Model
{
  protected $table='comerc_servicio_giro';

  protected $connection='pgsql';
  protected $primaryKey='id';


  protected $fillable =[
    'nombre'
  ];
}

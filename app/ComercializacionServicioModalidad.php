<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioModalidad extends Model
{
  protected $table='comerc_servicio_modalidad';

  protected $connection='pgsql';
  protected $primaryKey='id';


  protected $fillable =[
    'tipo',
    'nombre',
    'precio'
  ];
}

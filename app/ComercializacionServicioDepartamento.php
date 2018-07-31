<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioDepartamento extends Model
{
  protected $table='comerc_servicio_depto';

  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'id_servicio',
    'id_departamento',
    'estatus',
    'observacion',
    'fecha',
    'hora'
  ];
}

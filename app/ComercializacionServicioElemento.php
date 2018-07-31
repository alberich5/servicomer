<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioElemento extends Model
{
  protected $table='comerc_servicio_elemento';

  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'id_servicio',
    'id_elemento_policial',
    'tipo',
    'tipo_turno',
    'horario',
    'estatus',
    'observacion',
    'fecha_asignacion',
    'fecha_cambio'
  ];
}

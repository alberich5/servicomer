<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class analisis_riesg_solicitud_servicio extends Model
{
  protected $table='analisis_riesg_solicitud_servicio';
  protected $connection='pgsql';

  protected $fillable =[
    'fecha_programada',
    'fecha_solicitud',
    'id_servicio'
  ];
}

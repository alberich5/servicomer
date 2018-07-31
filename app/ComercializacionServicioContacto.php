<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioContacto extends Model
{
  protected $table='comerc_servicio_contacto';

  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'id_servicio',
    'nombre',
    'tipo',
    'dato',
    'id_area'
  ];
}

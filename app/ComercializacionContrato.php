<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionContrato extends Model
{
  protected $table='comerc_contrato';

  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'num_contrato',
    'tipo',
    'fecha_contratacion',
    'fecha_termino',
    'observacion',
    'estatus',
    'activo'
  ];
}

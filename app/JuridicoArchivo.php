<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JuridicoArchivo extends Model
{
  protected $table='juridico_num_contratos';
  public $timestamps = false;
  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'num_contrato',

    'fecha_alta',
    'fecha_baja',
    'estatus',
    'ruta_archivo',
    'tipo',
    'id_servicio',
    'observaciones'
  ];
}

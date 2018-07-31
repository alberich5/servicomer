<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicio extends Model
{
  protected $table='comerc_servicio';

  protected $connection='pgsql';
  protected $primaryKey='id';

  protected $fillable =[
    'id_cliente',
    'id_contrato',
    'id_analisis_riesgos',
    'nombre_comercial',
    'domicilio',
    'municipio',
    'giro',
    'tipo',
    'estatus',
    'observacion',
    'latitud',
    'longitud',
    'fecha'
  ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionServicioCosto extends Model
{
  protected $table='comerc_servicio_costo';

  protected $connection='pgsql';
  protected $primaryKey='id';



  protected $fillable =[
    'id_servicio',
    'mes',
    'anio',
    'total',
    'umma',
    'elemento_arma',
    'id_elemento'
  ];
}

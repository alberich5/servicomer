<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class analisis_riesg_dictamen extends Model
{
  protected $table='analisis_riesg_dictamen';
  protected $connection='pgsql';
  public $timestamps = false;

  protected $fillable =[
    'id_solicitud',
    'nivel_riesgo'
  ];

}

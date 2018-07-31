<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepresentanteLegal extends Model
{
  protected $table='representante_legal';

  public $timestamps=true;
  protected $primaryKey='id';

  protected $fillable =[
    'nombre'
  ];
}

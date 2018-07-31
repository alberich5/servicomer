<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona_fisica extends Model
{
      /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $connection='principal';
    protected $table = 'persona_fisica';
    public $timestamps = false;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','activo','adscripcion_id','dato_personal_id','desarrollo_academico_id','disciplina_policial_id','estudio_socio_economico_id','fecha_alta','documentacion_oficial_fiscal_id',];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
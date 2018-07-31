<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DigitalizaDocumentacionPolicial extends Model
{
      /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $connection='principal';
    public $timestamps = false;
    
    protected  $table= 'digitaliza_documentacion_policial';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','documentacion_policial_id','original','activo','comentario','fecha_expedicion','fecha_vigencia','fecha_registro','elemento_policial_id',];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
}
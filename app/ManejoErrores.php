<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManejoErrores extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $connection='pgsql';
    protected $table = 'admin_manejo_errores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */




    protected $fillable = [
  'id' ,
  'modulo',
  'tipo_error',
  'datos' ,
  'usuario_registro_error',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}

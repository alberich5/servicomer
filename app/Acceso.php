<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $connection='pgsql';
    protected $table = 'admin_acceso';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */




    protected $fillable = [
  'id',
  'id_usuario',
  'ip',
  'fecha_acceso',
  'fecha_exit',
  'bloqueo_cierre_sesion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}

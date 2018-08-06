<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */

        protected $connection='pgsql';
    protected $table = 'admin_acceso_accion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_usuario', 
        'id_accion',
        'id_acceso',
        'detalle',
        'fecha'

    ];





    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}

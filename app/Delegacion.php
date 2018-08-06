<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegacion extends Model
{
       /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $connection='pgsql';
    protected $table = 'admin_delegacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
    'id',
    'nombre',
    'id_sucursal_depende',
    'id_elemento_encargado',
    'numero_nomina',
    'email',
    'nombre_largo_sucursal'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}

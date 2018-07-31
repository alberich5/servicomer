<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioSucursal extends Model
{
    protected $connection='pgsql';
    protected $table = 'usuario_sucursal';
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     "id_usuario","id_sucursal"

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}

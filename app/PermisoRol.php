<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
  protected $connection='pgsql';
  protected $table = 'permission_role';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */


  protected $fillable = [
     "id","permission_id","role_id"

  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];
}

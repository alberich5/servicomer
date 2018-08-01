<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComercializacionCliente extends Model
{
    protected $table='comerc_cliente';



    protected $connection='pgsql';

    protected $fillable =[
      'num_cliente',
      'razon_social',
      'domicilio_fiscal',
      'estatus',
      'fecha_alta',
      'nombre_comercial',
      'activo',
      'rfc',
      'cargo',
      'giro',
      'domicilio_notificacion',
      'id_delegacion',
      'tipo_contrato'
    ];
}

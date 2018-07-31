<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementoPolicialV extends Model
{
    protected $connection='principal';
    protected $table = 'elementos_policiales_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       "id",'id_dato_personal','id_persona_fisica',"nombre_completo","nombre","apellido_paterno","apellido_materno","tipo_sangre","alergia","numero_nomina","numero_empleado","numero_plaza","antiguedad","antiguedad_anio","fecha_nacimiento","edad","edad_anio","rfc","curp","imss","cuip","genero","estado_civil","fecha_inicio_laboral",
       "fecha_ultimo_examen_c3","examen_c3","fecha_ultima_capacitacion_interna","capacitacion_interna","fecha_ultima_capacitacion_seguridad_publica","capacitacion_seguridad_publica","fecha_ultima_capacitacion_adicional","capacitacion_adicional","escolaridad","activo","orz","fecha_registro_orz","aprobacion_loc","fecha_aprobacion_loc","categoria","sub_delegacion","delegacion","direccion","estatus","administrativo","fecha_registro_baja","direccion_nacimiento"

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}

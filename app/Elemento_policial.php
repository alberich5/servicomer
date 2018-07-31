<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elemento_policial extends Model
{
    protected $connection='principal';
    protected $table = 'elemento_policial';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $fillable= ['id','activo','administrativo','antecedentes_no_penales','antecedentes_policiales','antidoping','categoria','comentario_antecedentes_no_penales','comentario_antecedentes_policiales','comentario_antidoping','comentario_baja','comentario_email','comentario_examen_fisico','comentario_examen_medico','comentario_examen_psicologico','comentario_usuario_registra_candidato_aprobado','comentario_usuario_registra_candidato_contratado','comentario_usuario_registra_candidato_historico','comentario_usuario_registra_candidato_proceso','comentario_usuario_registra_candidato_rechazado','detalle_motivo','elemento_policial_reingreso_id','email_sent','examen_fisico','examen_medico','examen_psicologico','fecha_baja','fecha_candidato','fecha_candidato_aprobado','fecha_candidato_contratado','fecha_candidato_historico','fecha_candidato_rechazado','fecha_inicio_laboral','fecha_registro','fecha_registro_baja','militar','motivo_baja','persona_fisica_id','policia','reingreso','status','status_operativo','tipo_defuncion','usuario_registra_id','usuario_registra_baja_id','usuario_registra_candidato_aprobado_id','usuario_registra_candidato_contratado_id','usuario_registra_candidato_historico_id','usuario_registra_candidato_proceso_id','usuario_registra_candidato_rechazado_id','fecha_update','usuario_actualiza_id','registro_cuip','oficio','original_de_oficio','aprobacion','fecha_aprobacion','fecha_orz','orz','oficio_preventiva_pago','sector','servicio','cargo','fecha_baja_resolucion','status_pendiente','archivo_cuip_digital','nombre_archivo_cuip_digital','tipo_archivo_cuip_digital','examenc3','fecha_examenc3','oficio_fecha_inicio_laboral','archivo_firma_digital','nombre_archivo_firma_digital','tipo_archivo_firma_digital','comodin_id','servicio_fijo_id','servicio_temporal_id','comisionado','numero_plaza','formato_alta_imss_id','es_comodin','baja_rupo','loc',];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   
}
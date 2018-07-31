<?php

namespace App\Http\Controllers\recursosHumanos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\ElementoPolicialV;
use Response;
//use HTML2PDF;

class DescargaDocumentosController extends Controller
{

    public function downloadModoHonesto($idElemento)
    {


        $elemento=ElementoPolicialV::where('id',$idElemento)
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->first();


           if($elemento!=null)
        {
            $domicilio=DB::connection('principal')->select("select 
        elemento_policial.id as id_elemento_policial,
        uc.nombre as ciudad,
        direccion.n_ext,
        direccion.n_int,
        direccion.calle,
        uco.nombre as colonia,
        ue.nombre as entidad,
        ucm.nombre as municipio,
        uco.codigo_postal
        from elemento_policial
        left join persona_fisica on elemento_policial.persona_fisica_id=persona_fisica.id
        left join persona_fisica_direccion on persona_fisica_direcciones_id=persona_fisica.id
        left join direccion on persona_fisica_direccion.direccion_id=direccion.id
        left join ubicacion uc on uc.id = direccion.ciudad_id
        left join ubicacion uco on uco.id = direccion.colonia_id
        left join ubicacion ue on ue.id = direccion.entidad_federativa_id
        left join ubicacion ucm on ucm.id = direccion.municipio_id
        where elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$idElemento." and direccion.activo=true  ");



      $phpWord = new \PhpOffice\PhpWord\PhpWord();

/* Note: any element you append to a document must reside inside of a Section. */

 // Adding an empty Section to the document...
$section = $phpWord->addSection();




$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillasDoc/modoHonesto.docx');

 
$nombre =$elemento->nombre." ".$elemento->apellido_paterno." ".$elemento->apellido_materno;
$direccion=$domicilio[0]->calle.", ".$domicilio[0]->n_ext.", Col.".$domicilio[0]->colonia.", ".$domicilio[0]->municipio.", ".$domicilio[0]->entidad;
$rfc=$elemento->rfc;

//años de antiguedad


//fecha de contratacion
 $fecha_inicio = Carbon::parse($elemento->fecha_inicio_laboral);//Carbon::now();
 $fch_mes=$fecha_inicio->format('m');
  $fch_anio=$fecha_inicio->format('Y');
  $fch_dia=$fecha_inicio->format('d');
$mesfinal=strtoupper ($this->mesAletra($fch_mes));



$edad= $elemento->edad_anio;

$estado=$elemento->estado_civil;



// --- Asignamos valores a la plantilla
$templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
$templateWord->setValue('nombre',$nombre);
$templateWord->setValue('uno',$edad);
$templateWord->setValue('dia',$fch_dia);
$templateWord->setValue('mes',$mesfinal);
$templateWord->setValue('ano',$fch_anio);
// --- Guardamos el documento
$templateWord->saveAs('ModoHonesto.docx');

return Response::download('ModoHonesto.docx',$elemento->apellido_paterno." ".$elemento->apellido_materno." ".$elemento->nombre.'.docx');

        }
        abort(403, 'Unauthorized action.');
//observaciones: que pasa si copian la ruta e intentan descargar de un elemento inactivo? --solucionado
//solo revisar que se mande una vista generica de error o la direccion no encomntrada :) solucionado

    }//end download modo honesto



   public  function downloadContrato($idElemento)
   {



    $elemento=ElementoPolicialV::where('id',$idElemento)
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->first();

    $domicilio=DB::connection('principal')->select("select 
        elemento_policial.id as id_elemento_policial,
        uc.nombre as ciudad,
        direccion.n_ext,
        direccion.n_int,
        direccion.calle,
        uco.nombre as colonia,
        ue.nombre as entidad,
        ucm.nombre as municipio,
        uco.codigo_postal
        from elemento_policial
        left join persona_fisica on elemento_policial.persona_fisica_id=persona_fisica.id
        left join persona_fisica_direccion on persona_fisica_direcciones_id=persona_fisica.id
        left join direccion on persona_fisica_direccion.direccion_id=direccion.id
        left join ubicacion uc on uc.id = direccion.ciudad_id
        left join ubicacion uco on uco.id = direccion.colonia_id
        left join ubicacion ue on ue.id = direccion.entidad_federativa_id
        left join ubicacion ucm on ucm.id = direccion.municipio_id
        where elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$idElemento." and direccion.activo=true  ");



 if($elemento!=null)
{
    // Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();
$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillasDoc/contrato.docx');
$nombre =preg_replace('/( ){2,}/u',' ', $elemento->nombre." ".$elemento->apellido_paterno." ".$elemento->apellido_materno);
$direccion=$domicilio[0]->calle.", ".$domicilio[0]->n_ext." ".$domicilio[0]->colonia.", ".$domicilio[0]->municipio.", ".$domicilio[0]->entidad;

//fecha de contratacion
 $fecha_inicio = Carbon::parse($elemento->fecha_inicio_laboral);//Carbon::now();
 $fch_mes=$fecha_inicio->format('m');
 $fch_anio=$fecha_inicio->format('Y');
 $fch_dia=$fecha_inicio->format('d');
 $mesfinal=$this->mesAletra($fch_mes);
 $edad= $elemento->edad_anio;
 $estado=$elemento->estado_civil;


// --- Asignamos valores a la plantilla
$templateWord->setValue('nombre',$nombre);
$templateWord->setValue('edad',$edad);
$templateWord->setValue('direccion',$direccion);
// --- Asignamos valores de fecha
$templateWord->setValue('dia',$fch_dia);
$templateWord->setValue('mes',$mesfinal);
$templateWord->setValue('ano',$fch_anio);
// --- Asignamos esatdo civil
$templateWord->setValue('estado_civil',$estado);
// --- Asignamos genero
if($elemento->genero=="Masculino")
{
	$templateWord->setValue('nombre1',"EL C. ".$nombre);
	$templateWord->setValue('nombre2',"el Ciudadano ".$nombre);
	$templateWord->setValue('nombre3',"El Ciudadano ".$nombre);
	$templateWord->setValue('nombre4',"del Ciudadano ".$nombre);
}
else
{
	$templateWord->setValue('nombre1',"LA C. ".$nombre);
	$templateWord->setValue('nombre2',"la Ciudadana ".$nombre);
	$templateWord->setValue('nombre3',"La Ciudadana ".$nombre);
	$templateWord->setValue('nombre4',"de la Ciudadana ".$nombre);
	
}


// --- Guardamos el documento
$templateWord->saveAs('contrato.docx');

return Response::download('contrato.docx',$elemento->apellido_paterno." ".$elemento->apellido_materno." ".$elemento->nombre.'.docx');
}//fin if elemento != null
abort(403, 'Unauthorized action.');
}//fin downloadContrato
    




   public  function downloadOficioAlta($idElemento)
   {



    $elemento=ElementoPolicialV::where('id',$idElemento)
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->first();

    $oficio=DB::connection('principal')->select("select 
        elemento_policial.id as id_elemento_policial,
        elemento_policial.oficio_fecha_inicio_laboral as oficio
        from elemento_policial
        where elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$idElemento);



 if($elemento!=null)
{
    // Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();
$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillasDoc/oficioAlta.docx');
$nombre =preg_replace('/( ){2,}/u',' ', $elemento->nombre." ".$elemento->apellido_paterno." ".$elemento->apellido_materno);


//fecha de contratacion
 $fecha_inicio = Carbon::parse($elemento->fecha_inicio_laboral);//Carbon::now();
 $fch_mes=$fecha_inicio->format('m');
 $fch_anio=$fecha_inicio->format('Y');
 $fch_dia=$fecha_inicio->format('d');
 $mesfinal=strtoupper($this->mesAletra($fch_mes));



// --- Asignamos valores a la plantilla
$templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
$templateWord->setValue('nombre',$nombre);
$templateWord->setValue('rfc',$elemento->rfc);
// --- Asignamos valores de fecha
$templateWord->setValue('dia',$fch_dia);
$templateWord->setValue('mes',$mesfinal);
$templateWord->setValue('ano',$fch_anio);

$templateWord->setValue('oficio',$oficio[0]->oficio);

// --- Guardamos el documento
$templateWord->saveAs('oficioAlta.docx');

return Response::download('oficioAlta.docx',$elemento->apellido_paterno." ".$elemento->apellido_materno." ".$elemento->nombre.'.docx');
}//fin if elemento != null
abort(403, 'Unauthorized action.');
}//fin downloadOficio de Alta

    public function downloadFichaPersonal($idElemento)
    {



//datos personales

    $datos_elemento=ElementoPolicialV::where('id',$idElemento)
        ->select('id','delegacion','nombre','apellido_paterno','apellido_materno','fecha_nacimiento','tipo_sangre','alergia','edad_anio','imss','genero','escolaridad','categoria','curp','fecha_inicio_laboral')
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->first();

         if($datos_elemento!=null)
{

  $capacitacion_interna = DB::connection('principal')->select("select 
  cap.id,
  cap.elemento_policial_id,
  conf.tipo,
  ag.fecha,
  ag.fecha_termino
 from
  capacitacion_interna_elemento_policial cap
 inner join agenda_capacitacion_interna ag on cap.agenda_capacitacion_interna_id=ag.id 
 inner join configura_capacitacion_interna conf on ag.configura_capacitacion_interna_id=conf.id
 where   cap.activo='true' and  cap.elemento_policial_id=".$idElemento);

$capacitacion_historica = DB::connection('principal')->select("select 
ch.id,
ch.elemento_policial_id,
ncc.nombre_curso_capacitacion,
ch.fecha_inicio,
ch.fecha_termino
 from 
capacitacion_historica ch
inner join nombre_curso_capacitacion ncc on ch.nombre_curso_capacitacion_id=ncc.id
where elemento_policial_id=".$idElemento);


$capacitacion = DB::connection('principal')->select("select 
cap.id,
cap.elemento_policial_id,
nombre_curso,
ag.fecha_inicio,
ag.fecha_termino

 from capacitacion_elemento_policial cap
inner join agenda_capacitacion ag on cap.agenda_capacitacion_id=ag.id
inner join configura_capacitacion conf on ag.configura_capacitacion_id=conf.id
 where cap.activo='true' and elemento_policial_id=".$idElemento);




$arma_elemento=DB::connection('principal')->select("select * from 
servicio_arma_elemento_policial saep
inner join 
resguardo_historico rh on rh.servicio_arma_elemento_policial_id=saep.id
inner join arma on saep.arma_id=arma.id
 where  
saep.activo='t' and rh.activo='t' and arma.activo='t' and 
saep.elemento_policial_id=".$idElemento);
if($arma_elemento)
{
$portaArma='SI';
}
else
{
$portaArma='NO';
}

//servicio

$servicio_fijo=DB::connection('principal')->select("select 
ep.id as id_elemento_policial,

cc.nombre_cliente

from elemento_policial ep
inner join servicio_cantidad_operativo_elemento_policial scoep on ep.servicio_fijo_id=scoep.id
inner join contrato_juridico cj on scoep.contrato_id=cj.id
inner join  cliente_comercializacion cc on cj.cliente_id=cc.id

where ep.id=".$idElemento);

$capacitaciones=array();
for ($j=0; $j < count($capacitacion_interna); $j++) { 
   array_push($capacitaciones,
        array( 'inicio'=> str_replace( " 00:00:00","",$capacitacion_interna[$j]->fecha),
                'nombre'=>$capacitacion_interna[$j]->tipo,
                'termino'=> str_replace( " 00:00:00","",$capacitacion_interna[$j]->fecha_termino)
            ));
}

for ($k=0; $k < count($capacitacion_historica); $k++) { 
      array_push($capacitaciones,
        array(  'inicio'=> str_replace( " 00:00:00","",$capacitacion_historica[$k]->fecha_inicio),
                'nombre'=>$capacitacion_historica[$k]->nombre_curso_capacitacion,
                
                'termino'=>str_replace( " 00:00:00","",$capacitacion_historica[$k]->fecha_termino)

            ));
}

for ($l=0; $l < count($capacitacion); $l++) { 

       array_push($capacitaciones,
        array(  'inicio'=> str_replace( " 00:00:00","",$capacitacion[$l]->fecha_inicio),
                'nombre'=>$capacitacion[$l]->nombre_curso,
                
                'termino'=> str_replace( " 00:00:00","",$capacitacion[$l]->fecha_termino)

            ));
}



sort($capacitaciones);




 //dd($capacitaciones);
$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillasDoc/fichaPersonal.docx');
 // Adding an empty Section to the document...

//$templateWord->addImage()
//capacitaciones

   $templateWord->cloneRow('nombreCap',count($capacitaciones));

for ($i=0; $i <count($capacitaciones) ; $i++) { 
     $a=$i+1;
     $fecha_inicio = Carbon::parse($capacitaciones[$i]['inicio']);
     $f_inicio=$fecha_inicio->format('d/m/Y');

     $fecha_termino = Carbon::parse($capacitaciones[$i]['termino']);
     $f_termino=$fecha_termino->format('d/m/Y');


     $templateWord->setValue('nombreCap#'.$a, $capacitaciones[$i]['nombre']);
       $templateWord->setValue('fechaCap#'.$a, $f_inicio." -  ".$f_termino);
}
 


$fecha_actual = Carbon::now();

//$templateWord->setValue('delegación',strtoupper($datos_elemento->delegacion));
$templateWord->setValue('fecha',strtoupper('Valles Centrales, a '.$fecha_actual->day.' de '.$this->mesAletra($fecha_actual->month).' del '.$fecha_actual->year));
$templateWord->setValue('nombre',strtoupper($datos_elemento->nombre.' '.$datos_elemento->apellido_paterno.' '.$datos_elemento->apellido_materno));
$templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
$fecha_nac = Carbon::parse($datos_elemento->fecha_nacimiento);

$templateWord->setValue('fechaNac',$fecha_nac->format('d/m/Y'));
$templateWord->setValue('edad',$datos_elemento->edad_anio);
$templateWord->setValue('sexo',strtoupper($datos_elemento->genero));
if($servicio_fijo!=null)
{
 $templateWord->setValue('servicio',strtoupper($servicio_fijo[0]->nombre_cliente));   
}
else
{
    $templateWord->setValue('servicio',strtoupper('NO ASIGNADO'));
}

$templateWord->setValue('portaArma',$portaArma);

$fecha_il = Carbon::parse($datos_elemento->fecha_inicio_laboral);

$templateWord->setValue('fechaAlta',$fecha_il->format('d/m/Y'));
$templateWord->setValue('grado',strtoupper($datos_elemento->categoria));
$templateWord->setValue('escolaridad',strtoupper($datos_elemento->escolaridad));
$templateWord->setValue('curp',strtoupper($datos_elemento->curp));
$templateWord->setValue('numSeguridadSocial',strtoupper($datos_elemento->imss));
$templateWord->setValue('tipoSangre',strtoupper($datos_elemento->tipo_sangre));
$templateWord->setValue('alergias',strtoupper($datos_elemento->alergia));


 
// --- Guardamos el documento
$templateWord->saveAs('fichaPersonal.docx');
//$this->historial('Descarga de oficio de alta del elemento '.$id);
return Response::download('fichaPersonal.docx',$datos_elemento->nombre.' '.$datos_elemento->apellido_paterno.' '.$datos_elemento->apellido_materno.'.docx');
    }//fin if elemento != null
abort(404, 'Unauthorized action.');
}//fin ficha personal

    function ordenar( $a, $b ) {
    return strtotime($a['fecha']) - strtotime($b['fecha']);  
}

}

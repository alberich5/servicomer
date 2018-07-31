<?php

namespace App\Http\Controllers\recursosHumanos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ElementoPolicialV;
use App\DigitalizaDocumentacionPolicial;
use DB;
use Carbon\Carbon;



class ElementoPolicialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


      $request['elemento']['id']=4342;
      $request['vacaciones']['inicio']='2018-04-02';
      $request['vacaciones']['solicitud']='2018-04-01';
      $request['vacaciones']['oficio']='oficio1';
      $request['vacaciones']['termino']='2018-04-26';
      $request['vacaciones']['reincorporacion']='2018-04-27';
      $request['vacaciones']['servicio']="serv";
      $request['vacaciones']['lugar']="setg sdtg";
      $request['vacaciones']['ccp']="ccccc";
      $request['vacaciones']['elemento']="Elemento sss";

  return view('recursos-humanos.elemento-policial.index');
    }

    public function search(Request $request)
    {

      if($request['elemento']['id']!='')
        {
        $elementos=ElementoPolicialV::where('id',$request['elemento']['id'])
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->orderBy('id','asc')
        ->select('id','nombre','apellido_paterno','apellido_materno','delegacion','fecha_inicio_laboral','estatus')
        ->paginate(10);
        }
        else
        {
        $elementos=ElementoPolicialV::where('nombre','like','%'.strtoupper($request['elemento']['nombre']).'%')
        ->where('apellido_paterno','like','%'.strtoupper($request['elemento']['paterno']).'%')
        ->where('apellido_materno','like','%'.strtoupper($request['elemento']['materno']).'%')
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->orderBy('id','asc')
        ->select('id','nombre','apellido_paterno','apellido_materno','delegacion','fecha_inicio_laboral','estatus')

        ->paginate(10);

            /*
        $elementos=ElementoPolicialV::whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
         ->take(30)
        ->get(); */
        }


        //Vacaciones

        //solo para primer año



        for ($i=0; $i < sizeof($elementos); $i++) {
          $fecha = Carbon::parse($elementos[$i]->fecha_inicio_laboral);
          $f_inicio=$fecha->format('d-m-Y');
          $elementos[$i]->fecha_inicio_laboral=$f_inicio;
          $fecha_actual=Carbon::now();
          $fch_anio=$fecha_actual->format('Y');

          $permiso=DB::connection('pgsql')->select('select max(extract(year from fecha_inicial)) anio from rh_permiso
          where elemento_policial_id='.$elementos[$i]->id.' group by elemento_policial_id
          order by elemento_policial_id');

           $dias_ocupados=DB::connection('pgsql')->select('select sum(num_dias) dias from rh_permiso
          where extract(year from fecha_inicial)='.$fch_anio.' and activo=true and elemento_policial_id='.$elementos[$i]->id.' 
          group by elemento_policial_id
          order by elemento_policial_id');

          $fecha_inicio = Carbon::parse($elementos[$i]->fecha_inicio_laboral);//Carbon::now();
          $fecha_primer_anio = $fecha_inicio->addYear();
          

          $elementos[$i]->vacaciones=false;

          if($fecha_actual>$fecha_primer_anio)
          {
              if(empty($permiso))
              {
                  $elementos[$i]->vacaciones=true;
              }
              else {

               if($fch_anio<$permiso[0]->anio )//  && ) $fecha_actual>$fecha_primer_anio
                {
                  
                  
                    $elementos[$i]->vacaciones=true;
                  
                  
                }
              }
          }//primer año y vacaciones elegidas
          else{}
            //dias ocupados
            if(!empty($permiso) && $dias_ocupados[0]->dias<25)
            {
               $elementos[$i]->vacaciones=true;
            }
             else{}

            //historial
          if(empty($permiso))
              {
                  $elementos[$i]->historial=false;
              }
          else
          {
             $elementos[$i]->historial=true;
          }
        }//fin for







        return [
            'pagination'=>[
                'total'         =>$elementos->total(),
                'current_page'  =>$elementos->currentPage(),
                'per_page'      =>$elementos->perPage(),
                'last_page'     =>$elementos->lastPage(),
                'from'          =>$elementos->firstItem(),
                'to'            =>$elementos->lastItem()
            ],
            'resultados'=>$elementos
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $elemento=ElementoPolicialV::where('id',$request['idElemento'])
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->first();


        $documentacion=DigitalizaDocumentacionPolicial::where('digitaliza_documentacion_policial.elemento_policial_id',$request['idElemento'])
        ->where('digitaliza_documentacion_policial.version','=','0')
        ->where('digitaliza_documentacion_policial.activo','=','true')
        ->join('documentacion_policial','digitaliza_documentacion_policial.documentacion_policial_id','=','documentacion_policial.id')
        ->select('digitaliza_documentacion_policial.elemento_policial_id',
        'digitaliza_documentacion_policial.original',
        'digitaliza_documentacion_policial.id as id_digitaliza_documentacion_policial',
        'documentacion_policial.descripcion')
        ->get();

        $escolaridad=DB::connection('principal')->select("select
        elemento_policial.id as id_elemento_policial,
        CASE WHEN persona_fisica.desarrollo_academico_id IS NULL THEN 'SIN ESCOLARIDAD'
                    else
            desarrollo_academico.descripcion
               END
             as desarrollo_academico,
             escolaridad.*
        from elemento_policial
        inner join persona_fisica on elemento_policial.persona_fisica_id=persona_fisica.id
        left join persona_fisica_escolaridad on persona_fisica.id=persona_fisica_escolaridad.persona_fisica_escolaridades_id
        left join escolaridad on persona_fisica_escolaridad.escolaridad_id=escolaridad.id
        left join desarrollo_academico on persona_fisica.desarrollo_academico_id=desarrollo_academico.id
        where elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$request['idElemento']
        );

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
        where elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$request['idElemento']." and direccion.activo=true  ");

        $contacto=DB::connection('principal')->select(" select
        contacto.dato,
        contacto.tipo
        from elemento_policial
        left join persona_fisica on elemento_policial.persona_fisica_id=persona_fisica.id
        left join persona_fisica_contacto on persona_fisica.id=persona_fisica_contacto.persona_fisica_contactos_id
        left join contacto on persona_fisica_contacto.contacto_id=contacto.id

        where contacto.version=0 and elemento_policial.status in ('Candidato Contratado','Candidato Historico') and elemento_policial.id=".$request['idElemento']);

        $informacion=array();
        $informacion['elemento']=$elemento;
        $informacion['documentacion']=$documentacion;
        $informacion['escolaridad']=$escolaridad[0];
        if($domicilio!=null)
       {
         $informacion['domicilio']=$domicilio[0];
       }
       else{
        $informacion['domicilio']=array();
       }
        $informacion['contacto']=$contacto;

        return $informacion;



        /*


select
digitaliza_documentacion_policial.elemento_policial_id,
digitaliza_documentacion_policial.activo as archivo_activo,
digitaliza_documentacion_policial.version,
digitaliza_documentacion_policial.original,
documentacion_policial.id,
documentacion_policial.descripcion


from digitaliza_documentacion_policial
inner join documentacion_policial on digitaliza_documentacion_policial.documentacion_policial_id=documentacion_policial.id


where digitaliza_documentacion_policial.version=0 and digitaliza_documentacion_policial.activo=true;



select
elemento_policial.id as id_elemento_policial,
CASE WHEN persona_fisica.desarrollo_academico_id IS NULL THEN 'SIN ESCOLARIDAD'
            else
    desarrollo_academico.descripcion
       END
     as desarrollo_academico,
     escolaridad.*
from elemento_policial
inner join persona_fisica on elemento_policial.persona_fisica_id=persona_fisica.id
left join persona_fisica_escolaridad on persona_fisica.id=persona_fisica_escolaridad.persona_fisica_escolaridades_id
left join escolaridad on persona_fisica_escolaridad.escolaridad_id=escolaridad.id
left join desarrollo_academico on persona_fisica.desarrollo_academico_id=desarrollo_academico.id
where elemento_policial.status in ('Candidato Contratado','Candidato Historico');




        */



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

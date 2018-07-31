<?php

namespace App\Http\Controllers\recursosHumanos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ElementoPolicialV;
use Auth;
use App\Permiso;
use App\DigitalizaDocumentacionPolicial;
use DB;
use App\ManejoErrores;
use Carbon\Carbon;
use Response;

class VacacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function search(Request $request)
    {

        if($request['elemento']['id']!='')
        {
        $elementos=ElementoPolicialV::where('id',$request['elemento']['id'])
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->orderBy('id','desc')
        ->paginate(10);

        }
        else
        {

        $elementos=ElementoPolicialV::where('nombre','like','%'.strtoupper($request['elemento']['nombre']).'%')
        ->where('apellido_paterno','like','%'.strtoupper($request['elemento']['paterno']).'%')
        ->where('apellido_materno','like','%'.strtoupper($request['elemento']['materno']).'%')
        ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
        ->orderBy('id','desc')
        ->paginate(10);

            /*
        $elementos=ElementoPolicialV::whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
         ->take(30)
        ->get(); */
        }

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
    public function pruebaomar()
    {
$copiafinal=array();
      $copiafinal[0]="ajuhdos";
      $copiafinal[1]="fhhf";
      $nom=array();
      $nom1='';
      $nom2='';
      $nom3='';
      $nom4='';
      $nom5='';
      for ($i=0; $i <count($copiafinal) ; $i++) {
         $a=$i+1;
         $nom[$a]= $copiafinal[$i];

       }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	$texto="";

      try {

        $permisoLocal=new Permiso;
        $permisoLocal->elemento_policial_id=$request['vacaciones']['id_elemento'];
        $permisoLocal->num_dias=$request['vacaciones']['dias'];
        $permisoLocal->fecha_inicial=Carbon::parse($request['vacaciones']['inicio']);
        $permisoLocal->fecha_solicitud=Carbon::parse($request['vacaciones']['solicitud']);
        $permisoLocal->oficio=$request['vacaciones']['oficio'];
        $permisoLocal->fecha_final=Carbon::parse($request['vacaciones']['termino']);
        $permisoLocal->fecha_reincorporacion=Carbon::parse($request['vacaciones']['reincorporacion']);
        $permisoLocal->tipo='vacaciones';
        $permisoLocal->fecha_registro=Carbon::now();
        $permisoLocal->usuario_registro_id=Auth::user()->id;
        $permisoLocal->activo=true;
        

        if($request['vacaciones']['servicio'])
        {
          $permisoLocal->servicio=$request['vacaciones']['servicio'];
          $texto=$texto.",servicio:".$request['vacaciones']['servicio'];
        }else{}

        if($request['vacaciones']['lugar'])
        {
           $permisoLocal->lugar_vacaciones=$request['vacaciones']['lugar'];
           $texto=$texto.",lugar:".$request['vacaciones']['lugar'];
        }else{}

         if($request['vacaciones']['ccp'])
         {
           $permisoLocal->ccp=$request['vacaciones']['ccp'];
           $texto=$texto.",ccp:".$request['vacaciones']['ccp'];
         }else{}

         if($request['vacaciones']['elemento']!="Pol. Aux.")
         {
           $permisoLocal->elemento_temporal=ucfirst($request['vacaciones']['elemento']);
           $texto=$texto.",elemento_temporal:".ucfirst($request['vacaciones']['elemento']);
         }else{}
         /*
           if($request['vacaciones']['presentarse'])
           {
             $permisoLocal->presentarse=$request['vacaciones']['presentarse'];
           }else{}
        */
        $permisoLocal->save();
        //$this->historial($permisoLocal->id);

        return "si";

      } catch (\Exception $e) {


        $error=new ManejoErrores;
        $error->modulo="vacaciones";
        $error->tipo_error="guardar";
        $error->datos="id_elemento:".$request['vacaciones']['id_elemento'].",fecha_solicitud:".$request['vacaciones']['solicitud'].",fecha_inicio:".$request['vacaciones']['inicio'].$texto;
        $error->usuario_registro_error=Auth::user()->id;
        $error->save();
        //$e->getMessage()
        return "no";
      }//catch fin


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
        ->select('id','delegacion','rfc','curp','nombre','apellido_materno','apellido_paterno','fecha_nacimiento','genero','administrativo','estatus','estado_civil')
        ->first();



        $fecha_actual=Carbon::now();
        $fch_anio=$fecha_actual->format('Y');
        $dias_ocupados=DB::connection('pgsql')->select('select sum(num_dias) dias from rh_permiso
          where extract(year from fecha_inicial)='.$fch_anio.' and activo=true and elemento_policial_id='.$request['idElemento'].'
          group by elemento_policial_id
          order by elemento_policial_id');

         $informacion=array();
        $informacion['elemento']=$elemento;

        
        if(empty($dias_ocupados))
        {
            $informacion['dias']=25;
        }
        else
        {
            $informacion['dias']=25-$dias_ocupados[0]->dias;
        }
       //aqui

		//$informacion['dias']=25;
        return $informacion;


    }
    public function historial(Request $request)
    {

      try {
        $permisos=DB::connection('pgsql')->select('select rh_permiso.id,rh_permiso.tipo,rh_permiso.fecha_inicial,rh_permiso.fecha_final,rh_permiso.oficio,users.username from rh_permiso
        inner join users on rh_permiso.usuario_registro_id=users.id where elemento_policial_id='.$request['id_elemento']);

        for ($i=0; $i <sizeof($permisos) ; $i++) {

          $fecha = Carbon::parse($permisos[$i]->fecha_inicial);
          $f_inicio=$fecha->format('d-m-Y');
          $permisos[$i]->fecha_inicial=$f_inicio;

          $fecha = Carbon::parse($permisos[$i]->fecha_final);
          $f_final=$fecha->format('d-m-Y');
          $permisos[$i]->fecha_final=$f_final;

        }

        return $permisos;

      } catch (\Exception $e) {
        return "no";
      }

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


      public function calcularFecha(Request $request)
    {
       // $fechaInicioVacaciones=$request['fechaInicioVacaciones'].split('-');
        //$request['fechaInicioVacaciones']='2017-11-08';

        $fechaInicioVacaciones= explode('-', $request['fechaInicioVacaciones']);
	$diasV=(int)$request['diasVacaciones'];
        $fechaIV = Carbon::create($fechaInicioVacaciones[0], $fechaInicioVacaciones[1], $fechaInicioVacaciones[2], 12);
        $fechaTerminoVacaciones=$fechaIV->addDays($diasV-1);

        $fechaRV = Carbon::create($fechaInicioVacaciones[0], $fechaInicioVacaciones[1], $fechaInicioVacaciones[2], 12);
        $fechaReincorporacionVacaciones= $fechaRV->addDays($diasV);



        $informacion=array();
	       $informacion['diasv']=$request['diasVacaciones'];
        $informacion['fechaTerminoVacaciones']=$fechaTerminoVacaciones->format('Y-m-d');
        $informacion['fechaReincorporacionVacaciones']=$fechaReincorporacionVacaciones->format('Y-m-d');

        return  $informacion;
      //$request['fecha'];
    }//end calcular fecha


    public function download($idpermiso)
{
/*

*/

$id =$idpermiso;//request['id_permiso'];

$permiso=Permiso::select('id',
'tipo as asunto','oficio',
'fecha_solicitud',
'elemento_policial_id',
'fecha_inicial',
'fecha_final',
'fecha_reincorporacion',
'num_dias',
'num_meses',
'num_anios',
'elemento_temporal',
'lugar_vacaciones',
'servicio',
'presentarse',
'ccp')
->where('id','=',$id)
->get();


    $date = new \DateTime($permiso[0]->fecha_inicial);
    $permiso[0]->fecha_inicial= $date->format('Y-m-d');



    $elemento=ElementoPolicialV::where('id',$permiso[0]->elemento_policial_id)
    ->select('id','estatus as status','nombre','apellido_paterno','apellido_materno','sub_delegacion','categoria')
    ->get();


          // Creating the new document...
    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    /* Note: any element you append to a document must reside inside of a Section. */

    // Adding an empty Section to the document...
    $section = $phpWord->addSection();

    $templateWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillasDoc/oficioVacaciones.docx');
    if(!empty($permiso[0]->elemento_temporal))
    {
       $eleSustituto = "Cubriendo el servicio durante su periodo vacacional el C. ".$permiso[0]->elemento_temporal.".";
    }
    else
    {
      $eleSustituto = "";
    }//fin if sustituto
    if(!empty($permiso[0]->lugar_vacaciones))
    {
       $lugarvaca = "Los cuales disfrutará en ".$permiso[0]->lugar_vacaciones.".";
    }
    else
    {
      $lugarvaca = "";
    }//fin lugar vac

    if(!empty($permiso[0]->servicio))
    {
       $servi ="En caso de estar de servicio en ".$permiso[0]->servicio.", en el horario establecido." ;
    }
    else
    {
      $servi ="";
    }//fin servicio

    if(!empty($permiso[0]->ccp))
    {
	/*
       $copipara = $permiso[0]->ccp;
       $copiafinal =explode('*', $copipara, 2);

       for ($j=sizeof($copiafinal); $j <5 ; $j++) {
       $a=$j+1;
       $templateWord->setValue('copi'.$a,"");
     }//inicializacion de arreglo

       for ($i=0; $i <sizeof($copiafinal) ; $i++) {
       $a=$i+1;
       $templateWord->setValue('copi'.$a,"C.C.P. ".$copiafinal[$i]);
     }//asignacion
	 */
	 $ccps = explode("#", $permiso[0]->ccp);
	 
	 for ($j=sizeof($ccps); $j <5 ; $j++) {
       $a=$j+1;
       $templateWord->setValue('copi'.$a,"");
     }//inicializacion de arreglo
	 
	 
	  for ($i=0; $i <sizeof($ccps) ; $i++) {
       $a=$i+1;
       
	   if($ccps[$i]=="")
	   {
		   $templateWord->setValue('copi'.$a,"");
	   }
	   else{
		   $templateWord->setValue('copi'.$a,"C.C.P. ".$ccps[$i]);
	   }
	   
     }//asignacion
	 
    }
    else
    {
      for ($j=0; $j <5 ; $j++) {
      $a=$j+1;
      $templateWord->setValue('copi'.$a,"");
    }//inicializacion de arreglo
    }//fin ccp

    if(!empty($permiso[0]->presentarse))
    {
       $presen = $permiso[0]->presentarse;
    }
    else
    {

    }//fin ccp







    //nombre del cmt delegacion


    $templateWord->setValue('elementoSustituto',$eleSustituto);
    $templateWord->setValue('lugarVaca',$lugarvaca);
   // $templateWord->setValue('presentarse',$presen);

  //  $templateWord->cloneRow('copi',count($copiafinal));
  //fin else datos adicionales
    $nombre =$elemento[0]->apellido_paterno." ".$elemento[0]->apellido_materno." ".$elemento[0]->nombre;
    $nombre=str_replace("  "," ",$nombre);
    $anios="";
    if($permiso[0]->num_anios!=0)
    {
    $anios=$permiso[0]->num_anios." años ";
    if($permiso[0]->num_anios==1)
    {
    $anios=$permiso[0]->num_anios." año ";
    }

    }else{}
    $meses="";
    if($permiso[0]->num_meses!=0)
    {
    $meses=$permiso[0]->num_meses." meses ";

    if($permiso[0]->num_meses==1)
    {
    $meses=$permiso[0]->num_meses." mes ";
    }
    }else{}
    $dias="";
    if($permiso[0]->num_dias!=0)
    {
    $dias=$permiso[0]->num_dias." días ";

    if($permiso[0]->num_dias==1)
    {
    $dias=$permiso[0]->num_dias." día ";
    }
    }else{}

    //fecha inicial
    $fecha_i = Carbon::parse($permiso[0]->fecha_inicial);
    $diaI=$fecha_i->format('d');
    $mesI=ucwords($this->mesAletra($fecha_i->month));
    $anioI=$fecha_i->year;
    $fI=$diaI." de ".$mesI;
    //fecha final
    $fecha_f = Carbon::parse($permiso[0]->fecha_final);
    $diaF=$fecha_f->format('d');
    $mesF=ucwords($this->mesAletra($fecha_f->month));
    $anioF=$fecha_f->year;
    $fF=$diaF." de ".$mesF." del ".$anioF;
    //fecha reincorporacion
    $fecha_r = Carbon::parse($permiso[0]->fecha_reincorporacion);
    $diaR=$fecha_r->format('d');
    $mesR=ucwords($this->mesAletra($fecha_r->month));
    $anioR=$fecha_r->year;
    $fR=$diaR." de ".$mesR." del ".$anioR;
    //fecha descarga
    $fecha_d = Carbon::parse($permiso[0]->fecha_solicitud);//Carbon::now();
    $diaD=$fecha_d->format('d');
    $mesD=ucwords($this->mesAletra($fecha_d->month));
    $anioD=$fecha_d->year;
    $fD=$diaD." de ".$mesD." del ".$anioD;
/*
    $eleSustituto = $permiso[0]->elemento_temporal;
    $lugarvaca = $permiso[0]->lugar_vacaciones;
    $servi = $permiso[0]->servicio;
    $copipara = $permiso[0]->ccp;
    $presen = $permiso[0]->presentarse;


    $copiafinal =explode('*', $copipara, 2);
    */
    //nombre del cmt delegacion



    switch ($elemento[0]->sub_delegacion) {

    case 'Valles Centrales':
    $templateWord->setValue('delegacion','Delegación de Valles Centrales');
    $templateWord->setValue('nombreEncargado','CMTE. LEONARDO ORTEGA MARTINEZ');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE VALLES CENTRALES');

    $templateWord->setValue('lugarExpedicion','Oaxaca de Juarez');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Valles Centrales'));

    $templateWord->setValue('calle','Av. Escuadron 201, S/N');
    $templateWord->setValue('colonia','Colonia Antiguo Areopuerto ');
    $templateWord->setValue('cp','C. P. 68050');
    $templateWord->setValue('telefono','Tel (951) 1328401');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;

    case 'Pinotepa Nacional':
    $templateWord->setValue('delegacion','Subdelegación Pinotepa Nacional');
    $templateWord->setValue('nombreEncargado','OFICIAL FRANCISCO TALLEDOS SILVA');
    $templateWord->setValue('cargoEncargado','SUBDELEGADO EN PINOTEPA NACIONAL');


    $templateWord->setValue('lugarExpedicion','Santiago Pinotepa Nacional');
    $templateWord->setValue('delegacionA',strtoupper('Subdelegacion Pinotepa Nacional'));


    $templateWord->setValue('colonia','Colonia Aviación ');
    $templateWord->setValue('calle','Carret. Pinotepa Acapulco Km. 1, Edif. Albomoncy, Dpto. 7');
    $templateWord->setValue('cp','C. P. 71600');
    $templateWord->setValue('telefono','Tel (954) 54 3 2572');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;

    case 'Juchitan':
    $templateWord->setValue('delegacion','Delegación de Juchitan');
    $templateWord->setValue('nombreEncargado','CMTE. JUANITO GÓMEZ GÓMEZ');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE JUCHITAN');

    $templateWord->setValue('lugarExpedicion','H. Cd. de Juchitán de Zaragoza');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Juchitan'));


    $templateWord->setValue('colonia','4ª sección');
    $templateWord->setValue('calle','Av. Juárez, S/N');
    $templateWord->setValue('cp','C. P. 70000');
    $templateWord->setValue('telefono','Tel 01 971 28 10020');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;

    case 'Tuxtepec':
    $templateWord->setValue('delegacion','Delegación de Tuxtepec');
    $templateWord->setValue('nombreEncargado','CMTE. SEVERO SILVA JACINTO');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE TUXTEPEC');

    $templateWord->setValue('lugarExpedicion','San Juan Bautista Tuxtepec');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Tuxtepec'));


    $templateWord->setValue('colonia','Colonia Lázaro Cárdenas');
    $templateWord->setValue('calle','Calle Morelos, No 742');
    $templateWord->setValue('cp','C. P. 68340');
    $templateWord->setValue('telefono','Tel  01 287 875 43 42');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;


    case 'Puerto Escondido':
    $templateWord->setValue('delegacion','Delegación de Puerto Escondido');
    $templateWord->setValue('nombreEncargado','CMTE. ANDRÉS ROBERTO RAMIREZ MENDOZA');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE PUERTO ESCONDIDO');

    $templateWord->setValue('lugarExpedicion','Puerto Escondido');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Puerto Escondido'));


    $templateWord->setValue('colonia','Colonia Benito Juárez');
    $templateWord->setValue('calle','Margarita Maza, S/N');
    $templateWord->setValue('cp','C. P. 71980');
    $templateWord->setValue('telefono','Tel 5831788');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;

    case 'Matias Romero':
    $templateWord->setValue('delegacion','Delegación de Matías Romero');
    $templateWord->setValue('nombreEncargado','CMTE. JOSE SALVADOR AQUINO ROJAS');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE MATIAS ROMERO');

    $templateWord->setValue('lugarExpedicion','Matías Romero');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Matías Romero'));

    $templateWord->setValue('calle','Calle Independencia , No.301');
    $templateWord->setValue('colonia','Colonia Rincón Viejo Sur ');
    $templateWord->setValue('cp','C. P. ---');
    $templateWord->setValue('telefono','Tel 01 (972) 72 2 02 19');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;

    case 'Huajuapan':
    $templateWord->setValue('delegacion','Delegación de Huajuapan de León');
    $templateWord->setValue('nombreEncargado','CMTE. ALBERTO CONTRERAS GARCÍA');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE HUAJUAPAN');

    $templateWord->setValue('lugarExpedicion','Huajuapan de León');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Huajuapan de León'));

    $templateWord->setValue('calle','Calle San Carlos, No. 28');
    $templateWord->setValue('colonia','Colonia del Carmen ');
    $templateWord->setValue('cp','C. P. 69005');
    $templateWord->setValue('telefono','Tel 53 0 08 09');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');

    break;

    default:
    $templateWord->setValue('delegacion','Delegación de Valles Centrales');
    $templateWord->setValue('nombreEncargado','CMTE. LEONARDO ORTEGA MARTINEZ');
    $templateWord->setValue('cargoEncargado','DELEGADO REGIONAL DE VALLES CENTRALES');

    $templateWord->setValue('lugarExpedicion','Oaxaca de Juarez');
    $templateWord->setValue('delegacionA',strtoupper('Delegacion de Valles Centrales'));

    $templateWord->setValue('calle','Av. Escuadron 201, S/N');
    $templateWord->setValue('colonia','Colonia Antiguo Areopuerto ');
    $templateWord->setValue('cp','C. P. 68050');
    $templateWord->setValue('telefono','Tel (951) 1328401');
    $templateWord->setValue('leyenda','“2018, AÑO DE LA ERRADICACIÓN DEL TRABAJO INFANTIL”');
    break;
    }


    $templateWord->setValue('categoria',$elemento[0]->categoria);
    $templateWord->setValue('oficio',$permiso[0]->oficio);
    $templateWord->setValue('fechaDescarga',$fD);
    $templateWord->setValue('nombreElemento',$nombre);
    $templateWord->setValue('num_anios',$anios);
    $templateWord->setValue('num_meses',$meses);
    $templateWord->setValue('num_dias',$dias);
    $templateWord->setValue('fecha_inicial',$fI);
    $templateWord->setValue('fecha_final',$fF);
    $templateWord->setValue('fecha_reincorporacion',$fR);
    $templateWord->setValue('elementoSustituto',$eleSustituto);
    $templateWord->setValue('lugarVaca',$lugarvaca);
    $templateWord->setValue('presentarse',$servi);
    /*$templateWord->cloneRow('copi',count($copiafinal));
    for ($i=0; $i <count($copiafinal) ; $i++) {
        $templateWord->setValue('copi#'.$i,  $copiafinal[$i]);
     }*/

    // --- Guardamos el documento
    $templateWord->saveAs('oficioVacaciones.docx');
    //$this->historial('Descarga de oficio de alta del elemento '.$id);
    $nombreDocumento=$elemento[0]->apellido_paterno." ".$elemento[0]->apellido_materno." ".$elemento[0]->nombre;
    $nombreDocumento=str_replace("  "," ",$nombreDocumento);
    return Response::download('oficioVacaciones.docx',$nombreDocumento.'.docx');

	//////////////////////////////
    }

  }

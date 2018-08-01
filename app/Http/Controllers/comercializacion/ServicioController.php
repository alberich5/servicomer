<?php

namespace App\Http\Controllers\comercializacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComercializacionCliente;
use App\ComercializacionServicio;
use App\analisis_riesg_solicitud_servicio;
use App\analisis_riesg_dictamen;
use App\ComercializacionServicioContacto;
use App\ComercializacionContrato;
use App\ComercializacionServicioElemento;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    public function search(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $informacion=['error'=>false, 'resultado' => ''];


        try{
          //contrato
           $comerContrato=new ComercializacionContrato;
           $comerContrato->observacion="Contrato comercializa";
           $comerContrato->save();
           $ultimocontrato = ComercializacionContrato::orderBy('id', 'desc')->first();

             $servicio=new ComercializacionServicio;
              $servicio->id_cliente=$request['servicio']['id_cliente'];
              $servicio->id_contrato=$ultimocontrato->id;
              $servicio->nombre_comercial=strtoupper($request['servicio']['nombre_comercial']);
              $servicio->domicilio=strtoupper($request['servicio']['domicilio']);
              $servicio->municipio=strtoupper($request['servicio']['municipio']);
              $servicio->giro=strtoupper($request['servicio']['giro']);
              $servicio->tipo=strtoupper('normal');
              $servicio->observacion=strtoupper($request['servicio']['observacion']);
              $servicio->id_delegacion=strtoupper($request['servicio']['id_delegacion']);
              $servicio->fecha=$request['servicio']['fecha_contratacion'];
              $servicio->save();

              $ultimoservicio = ComercializacionServicio::orderBy('id', 'desc')->first();
              //aqui se agrega la solicitud
              $solicitudServicio=new analisis_riesg_solicitud_servicio;
               $solicitudServicio->id_servicio=$ultimoservicio->id;
               $solicitudServicio->save();

              $contactos=$request['servicio']['contactos'];
              for ($i=0; $i < sizeof($contactos); $i++) {
                  $contacto=new ComercializacionServicioContacto;
                  $contacto->nombre=$contactos[$i]['nombre'];
                  $contacto->tipo=$contactos[$i]['tipo'];
                  $contacto->dato=$contactos[$i]['dato'];
                  $contacto->id_area=2;
                  $contacto->id_servicio=$servicio->id;
                  $contacto->save();
              }
              $elementos=$request['servicio']['elementos'];
              for ($i=0; $i < sizeof($elementos); $i++) {
                  for ($j=0; $j < $elementos[$i]['cantidad']; $j++) {
                  $elemento=new ComercializacionServicioElemento;
                  $elemento->tipo_turno=$elementos[$i]['tipo_turno'];
                  $elemento->tipo=$elementos[$i]['tipo'];
                  $elemento->horario=$elementos[$i]['horario'];
                  $elemento->id_servicio=$servicio->id;
                  $elemento->save();
                  }
              }

            $informacion['resultado']='El registro del servicio '.$servicio->nombre_comercial.' fue exitoso';
        }
        catch(\Exception $e) {
            $informacion['error']=false;
            $informacion['resultado']='El registro del servicio '.$servicio->nombre_comercial.' fue exitoso';
        }

      return $informacion;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $informacion=['error'=>false, 'resultado' => ''];
        $contactos=array();
            $elementos=array();
        if($request['id']!='')
        {
            $servicio=ComercializacionServicio::where('id',$request['id'])
                ->first();



            if($servicio)
            {
             $informacion['resultado']='Ver detalle del servicio con el id: '.$servicio->id;
             $contactos=ComercializacionServicioContacto::where('id_servicio',$servicio->id)
                ->get();
             $elementos=ComercializacionServicioElemento::where('id_servicio',$servicio->id)
                ->get();
            }
            else
            {
             $informacion['error']=true;
             $informacion['resultado']='Servicio no registrado';
             $servicio=array();
            }
        }
        else{
            $informacion['error']=true;
            $informacion['resultado']='Servicio no registrado';
            $servicio=array();
        }



        $servicio['contactos']=$contactos;
        $servicio['elementos']=$elementos;



        return [

            'resultados'=>$servicio,
            'informacion'=>$informacion
        ];
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

    public function prueba(Request $request)
    {

      $ultimoservicio = ComercializacionServicio::orderBy('id', 'desc')
      ->first();
    dd($ultimoservicio->id);


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

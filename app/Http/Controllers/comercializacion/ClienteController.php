<?php

namespace App\Http\Controllers\comercializacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComercializacionCliente;
use App\ComercializacionServicio;
use App\RepresentanteLegal;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /*
        $request['cliente']['id']="";
        $request['cliente']['num_cliente']="";
        $request['cliente']['razon_social']="dhfhfdhfd";
        $request['cliente']['nombre_comercial']="dhfhfdhfd";
        $request['cliente']['fecha']="2018-07-21";
        $request['cliente']['domicilio_fiscal']="dfhdfh";

        $request['servicio']['nombre_comercial']="kjasbck";
        $request['servicio']['domicilio']="kjasbck";
        $request['servicio']['municipio']="kjasbck";
        $request['servicio']['giro']="kjasbck";
        $request['servicio']['observacion']="kjasbck";
        $request['servicio']['fecha_contratacion']="2018-07-21";
        $request['servicio']['id_cliente']=2;
        $request['servicio']['elementos']=array();
        $request['servicio']['elementos'][0]=array(
        "id"=> 1,
        "tipo"=> "ESCOLTA",
        "cantidad"=> "4",
        "tipo_turno"=> "24x24",
        "horario"=> "kswlrk"
      );*/


    


       return view ('comercializacion.index');
    }

    public function search(Request $request)
    {
        $informacion=['error'=>false, 'resultado' => ''];

        if($request['cliente']['id']!='')
        {
            $clientes=ComercializacionCliente::where('id',$request['cliente']['id'])
           // ->whereIn('estatus',array('Candidato Contratado','Candidato Historico'))
           // ->orderBy('id','asc')
            ->select('id','razon_social','estatus')
            ->paginate(10);
        }
        else{
            if($request['cliente']['fecha']!='')
            {
            $clientes=ComercializacionCliente::where('razon_social','like','%'.strtoupper($request['cliente']['razon_social']).'%')
            ->where('nombre_comercial','like','%'.strtoupper($request['cliente']['nombre_comercial']).'%')
            ->whereDate('fecha_alta','=',$request['cliente']['fecha'])
            ->select('id','razon_social','estatus')
            ->paginate(10);
            }
            else{
            $clientes=ComercializacionCliente::where('razon_social','like','%'.strtoupper($request['cliente']['razon_social']).'%')
            ->where('nombre_comercial','like','%'.strtoupper($request['cliente']['nombre_comercial']).'%')
            ->select('id','razon_social','estatus')
            ->paginate(10);
            }


        }



        if(sizeof($clientes)!=0)
        {
            $informacion['resultado']='Busqueda realizada con éxito';
            //recorremos el arreglo de clientes y agregamos sus servicios
             for ($i=0; $i < sizeof($clientes) ; $i++) {
                 # code...
                $servicios=ComercializacionServicio::where('id_cliente','=',$clientes[$i]['id'])
                    ->where('estatus','=',true)
                    ->select('id','nombre_comercial')
                    ->get();

                $clientes[$i]['servicios']=$servicios;
             }

        }
        else{
            $informacion['error']=true;
            $informacion['resultado']='La busqueda no arrojó ningun resultado';

        }

        return [
            'pagination'=>[
                'total'         =>$clientes->total(),
                'current_page'  =>$clientes->currentPage(),
                'per_page'      =>$clientes->perPage(),
                'last_page'     =>$clientes->lastPage(),
                'from'          =>$clientes->firstItem(),
                'to'            =>$clientes->lastItem()
            ],
            'resultados'=>$clientes,
            'informacion'=>$informacion
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
        $informacion=['error'=>false, 'resultado' => ''];



        try{
          //Aqui se guarda el representante legal
            $repLegal=new RepresentanteLegal;
            $repLegal->nombre=$request['cliente']['replegal'];
            $repLegal->tipo="Cliente";
            $repLegal->save();
            $ultimorep = RepresentanteLegal::orderBy('id', 'desc')->first();
            //Aqui se guarda el cliente
            $cliente=new ComercializacionCliente;
            $cliente->razon_social=$request['cliente']['razon_social'];
            $cliente->domicilio_fiscal=$request['cliente']['domicilio_fiscal'];
            $cliente->fecha_alta=$request['cliente']['fecha'];
            $cliente->nombre_comercial=$request['cliente']['nombre_comercial'];
            $cliente->rfc=$request['cliente']['rfc'];
            $cliente->cargo=$request['cliente']['cargo'];
            $cliente->giro=$request['cliente']['giro'];
            $cliente->domicilio_notificacion=$request['cliente']['notificacion'];
            $cliente->id_delegacion=$request['cliente']['id_delegacion'];
            $cliente->tipo_contrato=$request['cliente']['tipo_contrato'];
            $cliente->id_representante_legal=$ultimorep->id;
            $cliente->save();


            $informacion['resultado']='El registro del cliente '.$cliente->razon_social.' fue exitoso';
        }
        catch(\Exception $e) {
            $informacion['error']=true;
            $informacion['resultado']='Registro de datos incorrecto, reporte añadido a SISTEMAS';
        }
        return $informacion;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $informacion=['error'=>false, 'resultado' => ''];

        if($request['id']!='')
        {
            $cliente=ComercializacionCliente::where('id',$request['id'])
                ->first();
            if($cliente)
            {
             $informacion['resultado']='Ver detalle del cliente con el id: '.$cliente->id;
            }
            else
            {
             $informacion['error']=true;
             $informacion['resultado']='Cliente no registrado';
             $cliente=array();
            }
        }
        else{
            $informacion['error']=true;
            $informacion['resultado']='Cliente no registrado';
            $cliente=array();
        }




        return [

            'resultados'=>$cliente,
            'informacion'=>$informacion
        ];
    }

    public function showHistorial(Request $request)
    {

        $informacion=['error'=>false, 'resultado' => ''];

        if($request['id']!='')
        {

            $servicios=ComercializacionServicio::where('id_cliente','=',$request['id'])

                    //->select('id','nombre_comercial','fecha')
                    ->orderBy('fecha','desc')
                    ->get();


           //falta checar sino tiene servicios no mostrar
             $informacion['resultado']='Historial de servicios del cliente con el id: '.$request['id'];


        }
        else{
            $informacion['error']=true;
            $informacion['resultado']='Cliente no registrado';
            $servicios=array();
        }




        return [

            'resultados'=>$servicios,
            'informacion'=>$informacion
        ];
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

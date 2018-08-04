<?php

namespace App\Http\Controllers\juridico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComercializacionContrato;

class ContratoController extends Controller
{
  public function index()
  {
     return view ('juridico.index');
  }

  public function subir(Request $request){
       //este metodo funciona bien esta en el controlador

//tiene que coincidir con el nombre del input
        if( $request->hasFile("file") ){

        $file = $request->file("file");
        $extension = $file->getClientOriginalExtension();//extension del archivo

         if($extension == 'pdf'){

            $nombre = uniqid()."-".$file->getClientOriginalName();
            $path2= '/imagenes/';
            $path = \Storage::disk('local')->put($nombre, \File::get($file)); // el path lo puedes mandar a la bd
            $fecha= date('Y-m-d');

            /*$archivo=ClienteComerArchivos::create([
            'tipo'=>$request->input('tipo'),
            'ruta'=> $path2,
            'fecha_alta'=> $fecha,
            'nombre' => $nombre,
        ]);*/


            $respuesta= "alert('exito');";

            return $respuesta;
        }
        return 'el archivo no es un pdf';
        }

        $respuesta='a ocurrido un error o no a enviado nada';

        return $respuesta;



}

}

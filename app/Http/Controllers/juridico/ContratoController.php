<?php

namespace App\Http\Controllers\juridico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComercializacionContrato;
use App\JuridicoArchivo;


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
            $path2= '/imagenes/'.$nombre;
            $path = \Storage::disk('local')->put($nombre, \File::get($file)); // el path lo puedes mandar a la bd
            $fecha= date('Y-m-d');

            $archivo=JuridicoArchivo::create([

            'num_contrato' => $request->input('num_contrato'),
            'estatus'=> true,
            'fecha_alta'=> $fecha,
            'ruta_archivo'=> $path2,
            'tipo'=>$request->input('tipo')

        ]);



        return redirect('juridico');
            //return $respuesta;
        }
        //return 'el archivo no es un pdf';
        return redirect('juridico');
        }

        $respuesta='a ocurrido un error o no a enviado nada';

        //return $respuesta;
        return redirect('juridico');


}

}

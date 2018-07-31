<?php

namespace App\Http\Controllers\recursosHumanos;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Session;

use App\Http\Controllers\Controller;

class CotejoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }


    public function download()
    {


    $archivoDescarga=Session::get('urlArchivoCotejo','vacio');
    if($archivoDescarga!='vacio')
    {

       Session::forget('urlArchivoCotejo');
 

     return response()->download($archivoDescarga);

    }
    else
    {
    return redirect()->route('recursos-humanos.nomina.cotejo');
    }
    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    
      return view('recursos-humanos.nomina.cotejo');
        
      
      
      
      
      
      //dd($archivoDescarga);
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


      $archivos = $request->file('archivos');
      $nombres="";
        
        // recorremos cada archivo y lo subimos individualmente

        foreach($archivos as $archivo) 
        {
            $filename = $archivo->getClientOriginalName();
            $nombres=$nombres.'-'.$filename;
           \Storage::disk('local')->put( '/nomina/'.$filename,  \File::get($archivo));
            $urlArchivo =storage_path('app')."\\nomina\\".''.$filename;
            Session::put('urlArchivoCotejo',$urlArchivo);
           $this->generarNomina($urlArchivo);
             

        }


     // $pathtoFile = $urlArchivo =storage_path('app')."\\nomina.txt";
    //  return response()->download($pathtoFile);

/*
if($request->file('archivo')!=null &&  $request->file('archivo')->getClientOriginalExtension())
{
    $file = $request->file('archivo');
     \Storage::disk('local')->put( "nominaComparacion.txt",  \File::get($file));
     $urlArchivo =storage_path('app').'\nominaComparacion.txt';
     //guardar el archivo 
       $this->generarNomina($urlArchivo);

}

*/
//$exists = \Storage::disk('local')->has('nomina.txt');
return back();

//return view('nomina.cotejo.create');

      // return "archivo guardado";
    }



    public function titulos($urlArchivo)
    {


$arr1=array("NOM", "EMP","R.F.C.", "C.U.R.P.","CATEGORIA","N O M B R E" );

return $arr1;


    }
    


    public function cortarCadena($cadena,$inicio,$fin)
    {
        $cadena1="";
        $tamCadena=strlen($cadena);
    for ($i=0; $i <$tamCadena ; $i++) { 
     if($i>$inicio-1 && $i<$fin+1)
     {
         $cadena1=$cadena1.$cadena[$i];
     }
    }

    return $cadena1;
    }

        public function sonEspacios($cadena,$inicio,$fin)
    {
      
        $vacia=true;
        
    for ($i=$inicio; $i <$fin ; $i++) { 
     if($cadena[$i]!=' ')
     {
        $vacia=false;
     }
    }

    return $vacia;
    }



    public function generarNomina($urlArchivo)
    {       


          $matriz=array();
       
            //$libro=Excel::create('Nomina');
            //$hoja=$libro->sheet('nomina');
          $contador=0;
          $fila;
            $hojaResumen;
            $nominaB=false;
          $encabezados=$this->titulos($urlArchivo);

          $titulo="";
          $titulos=0;
          $nResumen=0;
          $cadtem="";
         $contadorResumen=0; 
         $contadorLineas=1;

         $contadorAnterior=0;
           $cadAnt="";
$fp = fopen($urlArchivo, "r");
while(!feof($fp)) {
$linea = fgets($fp);
$tamCadena=strlen($linea);

if($this->sonEspacios($linea,0,$tamCadena)==false)
{
  //echo ($contador."<->".$linea."</br>");
if(strpos($linea, "NOMINA CORRESPONDIENTE")==true || strpos($linea, "RESUMEN")==true)
{
$titulo=$linea;
if(strpos($linea, "RESUMEN")==true)
{
$text="RESUMEN CONTABLE".$nResumen;
$nominaB=true;
//$hojaResumen=$libro->sheet($text);
$contadorResumen=0;
$nResumen++;
}//fin (strpos($linea, "RESUMEN")==true())
else//es nomina
{
    $nominaB=false;
}
}//fin if nomina y resumen

else{}

    //if cadena contiene proyecto
if (strpos($linea, "PROYECTO")==true && $titulos==0 && $nominaB==false) {
$titulos=1;
$matriz[0][0]="";//trim($titulo);

//$matriz[1][0]=trim($linea);

for ($jk=0; $jk < sizeof( $encabezados)+4; $jk++) { 
   if($jk>0)
   {
    $matriz[0][$jk]="";
   // $matriz[1][$jk]="";
   }
   else{}
    if($jk>sizeof( $encabezados)-1)
    {
    $matriz[1][$jk]="";
    }
    else{
       $matriz[1][$jk]=trim($encabezados[$jk]);
    }
  
}//fin for recorrer titulos
$contador=2;
}//fin if contiene proyecto
else{



}//else contiene proyecto
if($nominaB==false)
{
 if(strpos($linea, "PROYECTO")==false 
  && strpos($linea, "NOMINA")==false
  && strpos($linea, "P E R C E P C I O N E S")==false
  && strpos($linea, "NOM EMP")==false
  && strpos($linea, "C.U.R.P.")==false
  && $tamCadena!=134 && $tamCadena>3 )
 {

if($tamCadena>123)
{
  $linea=$this->cortarCadena($linea,0,123);
  $tamCadena=123;
}
else{}


//echo ($contador."<->".$contadorLineas."<->".$tamCadena."<->".$linea."</br>");

switch ($tamCadena) {


    case 123:
    //
        if(strpos($linea, "$")==false)
        { 
       
          
          if($contadorLineas==1)
          {

           $cadtem=$linea;
           
           $contadorLineas++;
          }
          else if ($contadorLineas==2)
          {

                $matriz[$contador]=array();
                $matriz[$contador][0]=trim($this->cortarCadena($cadtem,0,4));
                $matriz[$contador][1]=trim($this->cortarCadena($cadtem,5,8));
                $matriz[$contador][2]=trim($this->cortarCadena($cadtem,9,21));
                $matriz[$contador][3]=trim($this->cortarCadena($linea,0,19));
                $matriz[$contador][4]=trim($this->cortarCadena($linea,20,36));
                $matriz[$contador][5]=trim($this->cortarCadena($cadtem,22,51));
             //   echo($this->cortarCadena($cadtem,22,51)."<->".strlen($this->cortarCadena($cadtem,22,51)));
                //nombre si acentos y ñ caraters epspeciales
                $nombreTrim=str_replace("Á", "A", trim($this->cortarCadena($cadtem,22,51)));
                $nombreTrim=str_replace("É", "E", $nombreTrim);
                $nombreTrim=str_replace("Í", "I", $nombreTrim);
                $nombreTrim=str_replace("Ó", "O", $nombreTrim);
                $nombreTrim=str_replace("Ú", "U", $nombreTrim);
                //$nombreTrim=str_replace("Ñ", "N", $nombreTrim);
                $matriz[$contador][6]=$nombreTrim;
          $contadorLineas++;
          }//FINC ONATDOR LINEAS 2

          
        }//FIN IF CONTADOR LINEAS

                else if(strpos($linea, "$")==true)
        {

          if ($contadorLineas==2)
          {
          
            
               $matriz[$contador]=array();
                $matriz[$contador][0]=trim($this->cortarCadena($cadtem,0,4));
                $matriz[$contador][1]=trim($this->cortarCadena($cadtem,5,8));
                $matriz[$contador][2]=trim($this->cortarCadena($cadtem,9,21));
                $matriz[$contador][3]=trim($this->cortarCadena($linea,0,19));
                $matriz[$contador][4]=trim($this->cortarCadena($linea,20,36));
                $matriz[$contador][5]=trim($this->cortarCadena($cadtem,22,51));
                
                $nombreTrim=str_replace("Á", "A", trim($this->cortarCadena($cadtem,22,51)));
                $nombreTrim=str_replace("É", "E", $nombreTrim);
                $nombreTrim=str_replace("Í", "I", $nombreTrim);
                $nombreTrim=str_replace("Ó", "O", $nombreTrim);
                $nombreTrim=str_replace("Ú", "U", $nombreTrim);
                $nombreTrim=str_replace("Ñ", "N", $nombreTrim);
                $matriz[$contador][6]=$nombreTrim;
          }
        

        $contador++;
        $contadorLineas=1;

        }
        
        break;



    
    default:

        break;
}//fin switch 
}//fin if es ttitulos


}//fin if($nomina==false)

    
}//if no es una cadena vacia  
}//fin while

fclose($fp);
 

$arrayBD=$this->datosBD();
$arrayResultado= array( );
$noEncontrados=array();

for ($ii=0; $ii < sizeof($matriz); $ii++) { 
$arrayResultado[$ii]= array();
$encontrado=false;
 //$arrayResultado[$ii][0]=array();
 for ($jj=0; $jj < sizeof($arrayBD); $jj++) { 

    //$arrayResultado[$ii][$jj]=false;
//comparar
 $nombreComp=$this->compararCadenas($arrayBD[$jj][6],$matriz[$ii][6]);
 $rfcComp=$this->compararCadenas($arrayBD[$jj][4],$matriz[$ii][2]);
 $curpComp=$this->compararCadenas($arrayBD[$jj][5],$matriz[$ii][3]);

 if($nombreComp==true)
 {
//$arrayResultado[$ii][$jj]=true;
array_push($arrayResultado[$ii],$arrayBD[$jj]);

$encontrado=true;
 }//if nombre
 else
 {
//array_push($arrayExcel,$matriz[$ii]);

//$arrayResultado[$ii][$jj]=array();
 }//else nombre
}
if($encontrado==false)
{
unset($matriz[$ii][6]);
array_push($noEncontrados,$matriz[$ii]);

}
 }//fin for matriz

 //dd($noEncontrados);

//$arrayResultado=$this->limpiarMatriz($arrayResultado);
//recorrer ma4triz y crear array sizeof($matriz)  
//$arrayExcelZ=$this->generarArrayMatriz($arrayResultado,$matriz);//funciona si en rfc

$arrayExcelZ=$this->limpiarMatriz($arrayResultado,$matriz);

$arrayExcelZ=$this->revisionNombreStatus($arrayExcelZ);
$noEncontrados=$this->revisionNoEncontrados($arrayExcelZ,$noEncontrados);
//$arrayExcelZ=$this->borrarFilas($arrayExcelZ);
/*for ($f=0; $f <sizeof($arrayExcelZ) ; $f++) 
{ 
unset($arrayExcelZ[$f][6]);
unset($arrayExcelZ[$f][13]);
}
*/
$arrayExcelZ=$this->compDatos($arrayExcelZ);
$arrayExcelX=array_map("unserialize", array_unique(array_map("serialize", $arrayExcelZ)));
$arrayExcelX=array_values($arrayExcelX);

//dd($noEncontrados);
//AGREGAR TITULOS
 $titulo=$arrayName = array("NOM","NUE","R.F.C.","C.U.R.P.","CATEGORIA","NOMBRE","ID","NUE","NOM","NOMBRE","R.F.C.","C.U.R.P.","ESTATUS","COMP NOM","COMP NUE","COMP RFC","COMP C.U.R.P.");

 array_unshift($arrayExcelX, $titulo);
//quitar duplicados e imprimir no encontrados


 
 //print_r(($arrayExcel));
 //dd($arrayResultado);
//dd($arrayExcel);






 Excel::create('BDElementos', function($excel) use ($arrayExcelX,$noEncontrados) {
    // Set the title
    $excel->setTitle('Cotejo');
    $excel->sheet('Encontrados', function($sheet) use ($arrayExcelX) {
        // Sheet manipulation
        // Manipulate first row
$contadorLinea=1;
        for ($ijj=0; $ijj < sizeof($arrayExcelX); $ijj++) { 
         if(empty($arrayExcelX[$ijj])==false && $arrayExcelX[$ijj][7]!="BORRAR")
         {
        

    $sheet->row($contadorLinea, $arrayExcelX[$ijj]);
$contadorLinea++;
         }
           
        }
   

    }

    );//hoja de nomina

    $excel->sheet('No encontrados', function($sheet) use ($noEncontrados) {
        // Sheet manipulation
        // Manipulate first row
        $num=1;
     for ($jk=0; $jk < sizeof($noEncontrados); $jk++) { 

         if(empty($noEncontrados[$jk])==false)
         {
 
 $sheet->row($num, $noEncontrados[$jk]);
$num=$jk+1;
 
            
         }
         else
            {$num=$jk-1;}
           
        }
   

    }

    );//hoja de nomina


})->export('xls');








}
//ELIMINAR COLUMNAS Y COMPN DATOS

public function compDatos($arrayExcelZ)
{
 

for ($f=0; $f <sizeof($arrayExcelZ) ; $f++) 
{ 
//NOM
  if ($arrayExcelZ[$f][0]==$arrayExcelZ[$f][9]) {
 $nom="IGUAL";
}
else{
if($arrayExcelZ[$f][9]=="")
{
  $nom="NO REGISTRADO";
}
else
{
   $nom="DIFERENTE";
}

}

//FIN NOM
//NUM
  if ($arrayExcelZ[$f][1]==$arrayExcelZ[$f][8]) {
 $nue="IGUAL";
}
else{
if($arrayExcelZ[$f][8]=="")
{
  $nue="NO REGISTRADO";
}
else
{
   $nue="DIFERENTE";
}

}

//FIN NOM
//rfc
  if ($arrayExcelZ[$f][2]==$arrayExcelZ[$f][11]) {
 $rfc="IGUAL";
}
else{
if($arrayExcelZ[$f][11]=="")
{
  $rfc="NO REGISTRADO";
}
else
{
   $rfc="DIFERENTE";
}

}

//FIN rfc

//curp
  if ($arrayExcelZ[$f][3]==$arrayExcelZ[$f][12]) {
 $curp="IGUAL";
}
else{
if($arrayExcelZ[$f][12]=="")
{
  $curp="NO REGISTRADO";
}
else
{
   $curp="DIFERENTE";
}

}

//FIN curp



$arrayExcelZ[$f][15]=$nom;
$arrayExcelZ[$f][16]=$nue;
$arrayExcelZ[$f][17]=$rfc;
$arrayExcelZ[$f][18]=$curp;


unset($arrayExcelZ[$f][6]);
unset($arrayExcelZ[$f][13]);
}
return $arrayExcelZ;
}

public function generarArrayMatriz($arrayResultado,$matriz)
{
    $arrayExcelX=array();
 for ($t=0; $t < sizeof($arrayResultado); $t++) { 
  
     //echo (sizeof($arrayResultado[$o]));

if(sizeof($arrayResultado[$t]>0))
{
           for ($q=0; $q < sizeof($arrayResultado[$t]); $q++) 
    { 

        $arr1=array();
//unset($arrayResultado[$t][$q][6]);
        $arrayResultado[$t][$q][6]=$t;
$arr1=$arrayResultado[$t][$q];



$arr2=array();
$matriz[$t][6]=$t;
//unset($matriz[$t][6]);
$arr2=$matriz[$t];

$ar=array_merge($arr2,$arr1);
//print_r($ar);
//echo "</br>";
array_push($arrayExcelX,$ar); 
    }

}
 }//fn for

 return $arrayExcelX;
}
//REVISIONN NOMBRE E INACTIVOS CURP RFC
public function revisionNombreStatus($matriz)
{

 
   $arrayComparaciones=array();
  
  




    for ($t=0; $t < sizeof($matriz); $t++)
    { 

  $arrayEl=array();
   $arrayEl[0]=$matriz[$t][6];
   if(strlen($matriz[$t][5])<30  )
   {
       if($matriz[$t][5]==$matriz[$t][13])
    {
        $arrayEl[1]=1;

    }
    else
    {
         $arrayEl[1]=0;
    }
    
   }//if tam <30
   else
   {
         $arrayEl[1]=1;
   }
    //rfc
   if($matriz[$t][11]=="")
   {
     $arrayEl[2]=0;
   }
   else
   {

    $arrayEl[2]=1;
   }
//curp
   if($matriz[$t][12]=="")
   {
     $arrayEl[3]=0;
   }
   else
   {

    $arrayEl[3]=1;
   }

//status
  if($matriz[$t][14]!="Inactivo")
   {
     $arrayEl[4]=1;
   }
   else
   {

    $arrayEl[4]=0;
   }
   array_push($arrayComparaciones, $arrayEl);
       
       }
       
   // dd($arrayComparaciones);
$texto="";
$anterior=$arrayComparaciones[0][0];
for($g=1;$g<sizeof($arrayComparaciones);$g++)
{
$arrayAnterior=$arrayComparaciones[$g-1];
    $anterior=$arrayComparaciones[$g-1][0];

        $actual=$arrayComparaciones[$g][0];

           if($anterior==$actual)// && $matriz[$g][7]!="BORRAR" )
         {

          if($arrayAnterior[1]==0 && $arrayComparaciones[$g][1]==1 )
                {
                    $matriz[$g-1][7]="BORRAR";
                }
                else//seguir con las demas revisiones
                {
                }//else
          if($arrayAnterior[1]==1 && $arrayComparaciones[$g][1]==0 )
                {
                    $matriz[$g][7]="BORRAR";
                }
                else//seguir con las demas revisiones
                {
                }//else

          if($arrayAnterior[4]==0 && $arrayComparaciones[$g][4]==1 )
                {
                    $matriz[$g-1][7]="BORRAR";
                }
                else//seguir con las demas revisiones
                {
                }//else

          if($arrayAnterior[4]==1 && $arrayComparaciones[$g][4]==0 )
                {
                    $matriz[$g][7]="BORRAR";
                }
                else//seguir con las demas revisiones
                {
                }//else

           if($arrayAnterior[4]==0 && $arrayComparaciones[$g][4]==0 )
           {
             $matriz[$g][7]="BORRAR";
              $matriz[$g-1][7]="BORRAR";
           }  

           // $matriz[$g][8]=$arrayComparaciones[$g][4];

 //$texto=$texto."#--ant ".$matriz[$g-1][7]."---".$actual."-----".$matriz[$g][7]."--".$arrayAnterior[4]."--".$matriz[$g-1][14]."--".$arrayComparaciones[$g][4]."--".$matriz[$g][14];


               
               //  $texto=$texto."# ".$g."--".$matriz[$g-1][7]."--".$matriz[$g-1][5]."--".$matriz[$g-1][13]."--".$matriz[$g-1][14]."---".$actual."-----".$matriz[$g][7]."--".$matriz[$g][5]."--".$matriz[$g][13]."--".$matriz[$g][14];


         }
        
}//fin for

//dd($texto);
return $matriz;
}


//FINAL PPARA GENERAR LOS Q NO CUMPLEN COON NINGUN CRITERIO
public function revisionNoEncontrados($matriz,$noEncontrados)
{
    $anterior=$matriz[0][6];
    $contadorBorrar=0;
    $contador=1;
    $texto="";
     $anteriorElemento="";
        if($matriz[0][7]=="BORRAR")
            {   
             
                $contadorBorrar=1;
            }
            else{}
    for ($t=1; $t < sizeof($matriz); $t++)
    { 

      
        $anteriorElemento=$matriz[$t-1];
   

        $actual=$matriz[$t][6];

           if($anterior!=$actual)
         {
                  
            $anterior=$actual;
            if($contador==$contadorBorrar )
            {
              $nomina = array_slice($anteriorElemento, 0, 6); 
                array_push($noEncontrados, $nomina );
            }else{}
            

            if($matriz[$t][7]=="BORRAR")
            {   
               
                $contadorBorrar=1;
            }
            else{

                $contadorBorrar=0;

            }
             $contador=1;
            
          }
          else
           {
    
            $contador++;
            if($matriz[$t][7]=="BORRAR")
            {   
             
                $contadorBorrar++;
            }
            
          }


        $texto=$texto."# ".$t." --ACTUAL---".$actual."--ANTERIOR--".$anterior."--". $contador."<->".$contadorBorrar."--------------".$matriz[$t][5];

       


     }



   // dd($texto);
return $noEncontrados;

}
//limipar matriz

public function limpiarMatriz($arrayResultado,$matriz)
{
$arrayExcelX=array();
 for ($t=0; $t < sizeof($arrayResultado); $t++) { 
  

       for ($q=0; $q < sizeof($arrayResultado[$t]); $q++) 
    { 
///matriz s nomina
$rfcNom=$this->cortarCadena($arrayResultado[$t][$q][5],0,7);
$rfcBD=$this->cortarCadena($matriz[$t][3],0,7);
$compRfc=$this->compararCadenas($rfcNom,$rfcBD);
//echo($rfcNom."<---->".$rfcBD."</br>");

if($compRfc==false && $arrayResultado[$t][$q][5]!="" && sizeof($arrayResultado[$t])>1)// && $matriz[$t][4]!="")

{  $arrayResultado[$t][$q][0]="BORRAR";

}
else{}


$arr1=array();
//unset($arrayResultado[$t][$q][6]);
//$arrayResultado[$t][$q][6]=$t;
$arr1=$arrayResultado[$t][$q];



$arr2=array();
//unset($matriz[$t][6]);
$matriz[$t][6]=$t;
$arr2=$matriz[$t];

$ar=array_merge($arr2,$arr1);
//print_r($ar);
//echo "</br>";
array_push($arrayExcelX,$ar); 



    }//fin for array resultado

    }//fin for matriz

    return $arrayExcelX;

}



    public function compararCadenas($cadbd,$cadnom)
{
  $encontrado=false;



  if(strlen($cadnom)>3)
  {


          if(strlen($cadbd)>strlen($cadnom) || strlen($cadnom)==strlen($cadbd))//nombre
 {





$pos = strpos($cadbd, $cadnom);  
  


if ($pos !== false)
{

  
  $encontrado=true;
}
//fin else


 }



  }

 return $encontrado;
}//fin compaar Canadenas
//buscar informacion BD

    public function datosBD()
{

$elementos=DB::connection('principal')->select("select ep.id as idelemento , nomina_left.numero_empleado as nue,nomina_left.numero_nomina as nom,
ep.nombre,
ep.apellido_paterno,
ep.apellido_materno,
ep.rfc,
ep.curp,
ep.estatus
from elementos_policiales ep 

left join 
(select dato_nomina.numero_empleado, dato_nomina.numero_nomina,dato_nomina.elemento_policial_id 
from dato_nomina left join elemento_policial on dato_nomina.elemento_policial_id = elemento_policial.id 
where dato_nomina.activo=true ) as nomina_left on ep.id=nomina_left.elemento_policial_id
 
 order by ep.id;");
//dd($elementos);


 $arrayElementos=array();
        for ($ijkl=0; $ijkl < sizeof($elementos); $ijkl++) { 
         if(empty($elementos[$ijkl])==false)
         {
            $arrayElementos[$ijkl]=array();
            $arrayElementos[$ijkl][0]=$elementos[$ijkl]->idelemento;
            $arrayElementos[$ijkl][1]=$elementos[$ijkl]->nue;
            $arrayElementos[$ijkl][2]=$elementos[$ijkl]->nom;
            $arrayElementos[$ijkl][3]=trim($elementos[$ijkl]->apellido_paterno." ".$elementos[$ijkl]->apellido_materno." ".$elementos[$ijkl]->nombre);
            $arrayElementos[$ijkl][4]=$elementos[$ijkl]->rfc;
            $arrayElementos[$ijkl][5]=$elementos[$ijkl]->curp;
            

            $nombreTrim=str_replace("Á", "A", trim($elementos[$ijkl]->apellido_paterno." ".$elementos[$ijkl]->apellido_materno." ".$elementos[$ijkl]->nombre));
                $nombreTrim=str_replace("É", "E", $nombreTrim);
                $nombreTrim=str_replace("Í", "I", $nombreTrim);
                $nombreTrim=str_replace("Ó", "O", $nombreTrim);
                $nombreTrim=str_replace("Ú", "U", $nombreTrim);
                $nombreTrim=str_replace("Ñ", "N", $nombreTrim);
           $arrayElementos[$ijkl][6]=preg_replace('/( ){2,}/u',' ',$nombreTrim);
           $arrayElementos[$ijkl][7]=$elementos[$ijkl]->estatus;

            
         }
           
        }

        return $arrayElementos;
/*
Excel::create('BDElementos', function($excel) use ($arrayElementos) {
    // Set the title
    $excel->setTitle('Our new awesome title');
    $excel->sheet('elementos', function($sheet) use ($arrayElementos) {
        // Sheet manipulation
        // Manipulate first row

        for ($ijj=0; $ijj < sizeof($arrayElementos); $ijj++) { 
         if(empty($arrayElementos[$ijj])==false)
         {
        
             $sheet->row($ijj+1, $arrayElementos[$ijj]);
         }
           
        }
   

    });//hoja de nomina




})->save('xls');
*/

}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

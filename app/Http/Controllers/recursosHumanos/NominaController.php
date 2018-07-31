<?php

namespace App\Http\Controllers\recursosHumanos;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;

use App\Http\Controllers\Controller;

class NominaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recursos-humanos.nomina.convertir');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
if($request->file('archivo')!=null &&  $request->file('archivo')->getClientOriginalExtension())
{
    $file = $request->file('archivo');
     \Storage::disk('local')->put( "nomina.txt",  \File::get($file));
     $urlArchivo =storage_path('app').'\nomina.txt';
     //guardar el archivo 
    switch ($request['nomina']) {
            case 'nomina':
            //$this->excelNomina($urlArchivo);
             $this->generarNomina($urlArchivo);
                break;
            case 'sobre':
               

                break;
            case 'concentrado':
                
                break;
            case 'bono':
                
                break;
            
            default:
               
                break;
        }
}


        


//$exists = \Storage::disk('local')->has('nomina.txt');


return view('recursos-humanos.nomina.convertir');

      // return "archivo guardado";
    }



    public function titulos($urlArchivo)
    {
        //$exists = \Storage::disk('local')->has('nomina.txt');
   $contadorLineas=1;
 $nominaB=false;
$percepciones=array();
$deducciones=array();
$fp = fopen($urlArchivo, "r");
while(!feof($fp)) {
$linea = fgets($fp);
$tamCadena=strlen($linea);

if($this->sonEspacios($linea,0,$tamCadena)==false)
{
if(strpos($linea, "NOMINA CORRESPONDIENTE")==true || strpos($linea, "RESUMEN")==true)
{
$titulo=$linea;
if(strpos($linea, "RESUMEN")==true)
{

$nominaB=true;

}//fin (strpos($linea, "RESUMEN")==true())
else//es nomina
{
    $nominaB=false;
}
}//fin if nomina y resumen
else{}
if($nominaB==false)
{

 if(strpos($linea, "PROYECTO")==false 
  && strpos($linea, "NOMINA")==false
  && strpos($linea, "P E R C E P C I O N E S")==false
  && strpos($linea, "NOM EMP")==false
  && strpos($linea, "C.U.R.P.")==false
  && strpos($linea, "EMPLEADOS")==false
  && strpos($linea, "----------")==false
  && $tamCadena!=134 && $tamCadena>3 )
 {

if($tamCadena>123)
{
  $linea=$this->cortarCadena($linea,0,123);
  $tamCadena=123;
}
else{}

  if($tamCadena>88 && $tamCadena<91)
{
  $linea=$this->cortarCadena($linea,0,88);
  $tamCadena=88;
}
else{}
//echo ($contador."<->".$contadorLineas."<->".$tamCadena."<->".$linea."</br>");

switch ($tamCadena) {


    case 123:
    
        if(strpos($linea, "$")==false)
        { 
       
          
          if($contadorLineas==1)
          {

           $cadtem=$linea;
           
           $contadorLineas++;
          }
          else if ($contadorLineas==2)
          {
      

         

                //perceppciones

             
       
       
  $cad=$this->cortarCadena($linea,57,76);
   if(in_array($cad,$percepciones)==false)
   {
    array_push($percepciones,$cad);
   }
   else
   {}
  
  $cad1=$this->cortarCadena($cadtem,57,76);
   if(in_array($cad1,$percepciones)==false)
   {
    array_push($percepciones,$cad1);
   }
   else
   {}

                


                    //deducciones
        
          
          
          
$cad2=$this->cortarCadena($cadtem,91,111);
if(in_array($cad2,$deducciones)==false)
   {
    array_push($deducciones,$cad2);
   }
   
   else{}
   
   $cad3=$this->cortarCadena($linea,91,111);
if(in_array($cad3,$deducciones)==false)
   {
    array_push($deducciones,$cad3);
   }
   
   else{}
             
           
            /*echo("linea 2"."</br>");
            echo($contador."<->".$contadorLineas."<->".$linea."</br>");*/
          $contadorLineas++;
          }//FINC ONATDOR LINEAS 2
          else if($contadorLineas>2) {

         // $this->cortarCadena($linea,57,76)
//trim($this->cortarCadena($linea,91,111))
//$this->cortarCadena($cadtem,91,111)


  $cad=$this->cortarCadena($linea,57,76);
   if(in_array($cad,$percepciones)==false)
   {
    array_push($percepciones,$cad);
   }
   else
   {}
                              
$cad2=$this->cortarCadena($cadtem,91,111);
if(in_array($cad2,$deducciones)==false)
   {
    array_push($deducciones,$cad2);
   }
   
   else{}
   
   $cad3=trim($this->cortarCadena($linea,91,111));
if(in_array($cad3,$deducciones)==false)
   {
    array_push($deducciones,$cad3);
   }
   
   else{}


               
           /* echo("linea >2"."</br>");
            echo($contador."<->".$contadorLineas."<->".$linea."</br>");
            */
          $contadorLineas++;
          }
          
        }//FIN IF CONTADOR LINEAS

                else if(strpos($linea, "$")==true)
        {

          if ($contadorLineas==2)
          {
      
      //percepciones
     
  
  
  
            $cad=$this->cortarCadena($linea,57,76);
   if(in_array($cad,$percepciones)==false)
   {
    array_push($percepciones,$cad);
   }
   else
   {}
  
  $cad1=$this->cortarCadena($cadtem,57,76);
   if(in_array($cad1,$percepciones)==false)
   {
    array_push($percepciones,$cad1);
   }
   else
   {}
                

                   

                    //deducciones
          //trim($this->cortarCadena($cadtem,91,111))
               //  trim($this->cortarCadena($linea,91,111))
         
         $cad2=trim($this->cortarCadena($cadtem,91,111));
if(in_array($cad2,$deducciones)==false)
   {
    array_push($deducciones,$cad2);
   }
   
   else{}
   
   $cad3=trim($this->cortarCadena($linea,91,111));
if(in_array($cad3,$deducciones)==false)
   {
    array_push($deducciones,$cad3);
   }
   
   else{}
             


          }
        
        /*
        echo("final linea"."</br>");
        echo($contador."<->".$contadorLineas."<->".$linea."</br>");
        */


        $contadorLineas=1;

        }
        
        break;
    case 88:
      //if($contadorLineas>1)
      {
    //percepciones
      //$this->cortarCadena($linea,57,76)
              $contadorLineas++;
                    $cad=$this->cortarCadena($linea,57,76);
   if(in_array($cad,$percepciones)==false)
   {
    array_push($percepciones,$cad);
   }
   else
   {}
      }
        
  break;


    
    default:

        break;
}//fin switch 
}//fin if es ttitulos

 }//fin if es nomina   
}//if no es una cadena vacia  
}

fclose($fp);

$arr1=array("NOM", "EMP","R.F.C.", "C.U.R.P.","CATEGORIA","DIARIO","N O M B R E" );
$div=array("-");
$arrayResultado=array_merge($arr1,$percepciones,$div,$deducciones);
return $arrayResultado;
/*
print_r($percepciones);
echo("--------------");
print_r($deducciones);
*/

/*



//$this->titulos($url);



    Excel::create('Filename', function($excel) {

    $excel->sheet('Sheetname', function($sheet) {

        $sheet->fromArray(array(
            array(1, 152),
            array('data3', 'data4')
        ));

    });

})->export('xls');

*/

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

  if($tamCadena>88 && $tamCadena<91)
{
  $linea=$this->cortarCadena($linea,0,88);
  $tamCadena=88;
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
                $matriz[$contador][5]=trim($this->cortarCadena($linea,37,51));
                $matriz[$contador][6]=trim($this->cortarCadena($cadtem,22,51));


                for ($lll=7; $lll <sizeof( $encabezados) ; $lll++) { 
                    
                        $matriz[$contador][$lll]=0;
                }

                for ($iiii=7; $iiii < sizeof( $encabezados); $iiii++) { 
                   $nombreCol=$encabezados[$iiii];
                   if ($nombreCol==$this->cortarCadena($linea,57,76)) {
                    
                 
                      {
                        
                      $actual=trim($this->cortarCadena($linea,76,85));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                   
                   }//fin if 
                   else{}


                    if ($nombreCol==$this->cortarCadena($cadtem,57,76)) {
                      

                       
                      {
                        
                      $actual=trim($this->cortarCadena($cadtem,76,85));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                   }//fin if 
                   else{}


                    //deducciones
                    if ($nombreCol==$this->cortarCadena($linea,91,111)) {

                      {
                        
                      $actual=trim($this->cortarCadena($linea,112,121));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                      
                   }//fin if 
                   else{}

                    if ($nombreCol==$this->cortarCadena($cadtem,91,111)) {

                       
                       
                      {
                        
                      $actual=trim($this->cortarCadena($cadtem,112,121));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                   }//fin if 
                   else{}
                }//fin for ($iiii=0; $iiii < sizeof( $encabezados); $iiii++) 
            /*echo("linea 2"."</br>");
            echo($contador."<->".$contadorLineas."<->".$linea."</br>");*/
          $contadorLineas++;
          }//FINC ONATDOR LINEAS 2
          else if($contadorLineas>2) {

            for ($hhg=7; $hhg < sizeof( $encabezados); $hhg++) 
                { 
                   $nombreCol=$encabezados[$hhg];
                   if ($nombreCol==$this->cortarCadena($linea,57,76)) {
                       
                  
                      {
                        
                      $actual=trim($this->cortarCadena($linea,76,85));
                      if(is_numeric($matriz[$contador][$hhg]) && is_numeric(str_replace ( ',' , "" , $actual)))
                      {
                        $matriz[$contador][$hhg]=$matriz[$contador][$hhg]+str_replace ( ',' , "" , $actual);
                      }
                      else{
                        $matriz[$contador][$hhg]=0;
                      }

                      
                      }

                   
                   }//fin if 
                   else{}


                    


                    //deducciones
                    if (trim($nombreCol)==trim($this->cortarCadena($linea,91,111))) {
  
                      {
                        
                      $actual=trim($this->cortarCadena($linea,112,121));

                      $matriz[$contador][$hhg]=$matriz[$contador][$hhg]+str_replace ( ',' , "" , $actual)+0;
                      }

                      
                   }//fin if 
                   else{}

                    /*aqui quite
              if ($nombreCol==$this->cortarCadena($cadtem,91,111)) {

                      

                       
                      {
                        
                      $actual=trim($this->cortarCadena($cadtem,112,121));

                      $matriz[$contador][$hhg]=$matriz[$contador][$hhg]+str_replace ( ',' , "" , $actual)+0;
                      }
                   }//fin if 
                   else{}
                    */
                }//fin for ($iiii=0; $iiii < sizeof( $encabezados); $iiii++) 
           /* echo("linea >2"."</br>");
            echo($contador."<->".$contadorLineas."<->".$linea."</br>");
            */
          $contadorLineas++;
          }
          
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
                $matriz[$contador][5]=trim($this->cortarCadena($linea,37,51));
                $matriz[$contador][6]=trim($this->cortarCadena($cadtem,22,51));


                for ($lll=7; $lll <sizeof( $encabezados)+4 ; $lll++) { 
                    
                        $matriz[$contador][$lll]=0;
                }

                for ($iiii=7; $iiii < sizeof( $encabezados); $iiii++) { 
                   $nombreCol=$encabezados[$iiii];
                   if ($nombreCol==$this->cortarCadena($linea,57,76)) 
                   {
                    
                 
                      {
                        
                      $actual=trim($this->cortarCadena($linea,76,85));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                   
                   }//fin if 
                   else{}
                    if ($nombreCol==$this->cortarCadena($cadtem,57,76)) {
                    
                 
                      {
                        
                      $actual=trim($this->cortarCadena($cadtem,76,85));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                   
                   }//fin if 
                   else{}

                   

                    //deducciones
                    if (trim($nombreCol)==trim($this->cortarCadena($cadtem,91,111))) {


                       
                      {
                        
                      $actual=trim($this->cortarCadena($cadtem,112,121));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                      
                   }//fin if 
                   else{}
                    if (trim($nombreCol)==trim($this->cortarCadena($linea,91,111))) {


                       
                      {
                        
                      $actual=trim($this->cortarCadena($linea,112,121));

                      $matriz[$contador][$iiii]=str_replace ( ',' , "" , $actual)+0;
                      }
                      
                   }//fin if 
                   else{}

                }//fin for ($iiii=0; $iiii < sizeof( $encabezados); $iiii++) 
          }
        $tamE=sizeof( $encabezados);
        $matriz[$contador][$tamE]=str_replace ( ',' , "" , ($linea));
        $matriz[$contador][$tamE]=str_replace ( '$' , "" , ($matriz[$contador][$tamE]));
        $matriz[$contador][$tamE]=trim ($matriz[$contador][$tamE]);
        /*
        echo("final linea"."</br>");
        echo($contador."<->".$contadorLineas."<->".$linea."</br>");
        */

        $contador++;
        $contadorLineas=1;

        }
        
        break;
    case 88:
      //if($contadorLineas>1)
      {
        for ($ijklm=7; $ijklm < sizeof( $encabezados); $ijklm++) { 
                   $nombreCol=$encabezados[$ijklm];

                   if ($nombreCol==$this->cortarCadena($linea,57,76)) {
                     
                      
                      {
                        
                      $actual=trim($this->cortarCadena($linea,76,85));

                      $matriz[$contador][$ijklm]=str_replace ( ',' , "" , $actual);
                      }
                   }//fin if 
                   else{}
               }

              $contadorLineas++;
        /*
        echo("tamaño 88"."</br>");
        echo($contador."<->".$contadorLineas."<->".$linea."</br>");
        */
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


//prueba impresion
//echo(sizeof($matriz));

/*
for ($ii=0; $ii < sizeof($matriz); $ii++) { 
  for ($iii=0; $iii < sizeof($matriz[$ii]) ; $iii++) 

    { 
     echo("fila->".$ii." columna->".$iii." = ".$matriz[$ii][$iii]."</br>");
   }
}
*/

//calcular deducciones y percepciones


$gper=sizeof( $encabezados)+1;
$gded=sizeof( $encabezados)+2;
$total=sizeof( $encabezados)+3;
for ($o=0; $o < sizeof($matriz); $o++)
{

$percep=0;
$deduc=0;
$ded=false;
  for ($pd=7; $pd <sizeof( $encabezados) ; $pd++) { 
 if($encabezados[$pd]=="-")
 {
  $ded=true;
 }
 else
 {
  if($ded==true)
  {
    if(is_numeric($matriz[$o][$pd]))
    {
       $deduc=$deduc+$matriz[$o][$pd];
    }
 
  }
  else
  {
    if(is_numeric($matriz[$o][$pd]))
    {
    $percep=$percep+$matriz[$o][$pd];
    }
  }
 }

}

//guardamos valores de per y ded
//echo $percep."<->".$deduc."</br>";
$matriz[$o][$gper]=$percep;
$matriz[$o][$gded]=$deduc;
$matriz[$o][$total]=$percep-$deduc;
}
$matriz[1][$gper]="PERCEPCIONES";
$matriz[1][$gded]="DEDUCCIONES";
$matriz[1][$total]="-";


Excel::create('NOMINA', function($excel) use ($matriz) {
    // Set the title
    $excel->setTitle('nomina');
    $excel->sheet('nomina', function($sheet) use ($matriz) {
        // Sheet manipulation
        // Manipulate first row
        for ($ijj=0; $ijj < sizeof($matriz); $ijj++) { 
         if(empty($matriz[$ijj])==false)
         {

             $sheet->row($ijj+1, $matriz[$ijj]);
         }
           
        }
   

    });//hoja de nomina




})->export('xls');



//print_r($matriz);
//print_r($encabezados);
//dd($matriz[48]);
    }
///


    


    public function generarArraayList()
    {

      $percDed= $this->titulos($urlArchivo);

      $matriz=array();
      $titulos=["nombre","apelidos","num"];
      //$matriz[0]
      //rcuerda recorrer el rachiv y comprar para rellenar en el indice en dodne encuentres el titulo

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

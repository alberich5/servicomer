<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Models\Role;
use App\Delegacion;
use App\Roles;
use App\User;
use App\Acceso;
use App\RoleUser;
use App\Elemento_policial;
use App\ElementoPolicialV;
use App\Persona_fisica;
use App\UsuarioSucursal;
use Carbon\Carbon;
use Auth;
use App\Departamento;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function cambioContrasenaUsuario()
    {
        $usuario = User::where('id','=',Auth::user()->id)
        ->select('id','contrasena')
        ->first();

        return $usuario;
    }

       public function guardarCambioContrasenaUsuario(Request $request)
    {
        $informacion=['error'=>false, 'resultado' => ''];

        $usuario = User::where('id','=',Auth::user()->id)
        ->first();

        if($usuario->contrasena==false)
        {
        $usuario->contrasena=true;
        $usuario->password = bcrypt($request['usuario']['contrasena']);
        $usuario->save();

       

       //$this->historial('Cambio de contraseña '.$request['usuario']['contrasena']);

        $informacion['error']=false;
        $informacion['resultado']='Cambio de contraseña para el usuario '.$usuario->username." realizado con éxito";
        }//fin if
        else{
        $informacion['error']=true;
        $informacion['resultado']='Error al actualizar la contraseña del usuario '.$usuario->username;
        }
        

       
        return $informacion;
    }


    public function index()
    {
 

return view('administrador.usuario.index');

}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $request['elemento']['id']=4339;
        $request['usuario']['nombre']='';
        $request['usuario']['paterno']='';
        $request['usuario']['materno']='';



$request['idElemento']=6;
$request['opcion']=1;
$request['usuario']['username']='stephanie';
$request['usuario']['pass']='12345';

$request['usuario']['delegaciones']= [
      1,
      8,
      10,
      6,
      2
    ];




        //dd($permiso);
    return view('administrador.usuario.create');

    }

            public function searchCreate(Request $request)
    {

        $usuario=User::get();
             $usuario_id=array();
        for ($j=0; $j < sizeof($usuario); $j++) {

           array_push($usuario_id,$usuario[$j]->id_persona_fisica);
        }

        if($request['elemento']['id']!='')
        {


        $usuarios=ElementoPolicialV::where('id',$request['elemento']['id'])
        ->whereNotIn('id_persona_fisica',$usuario_id)
        ->select('id','id_persona_fisica','nombre','apellido_paterno','apellido_materno','delegacion','fecha_inicio_laboral')
        ->paginate(10);

        }//if request username <> ''
        else
        {

        $usuarios=ElementoPolicialV::where('nombre','like','%'.strtoupper($request['elemento']['nombre']).'%')
        ->where('apellido_paterno','like','%'.strtoupper($request['elemento']['paterno']).'%')
        ->where('apellido_materno','like','%'.strtoupper($request['elemento']['materno']).'%')
        ->whereNotIn('id_persona_fisica', $usuario_id)
        ->select('id','id_persona_fisica','nombre','apellido_paterno','apellido_materno','delegacion','fecha_inicio_laboral')
        ->paginate(10);

        }//fin else username <> ''


        return [
            'pagination'=>[
                'total'         =>$usuarios->total(),
                'current_page'  =>$usuarios->currentPage(),
                'per_page'      =>$usuarios->perPage(),
                'last_page'     =>$usuarios->lastPage(),
                'from'          =>$usuarios->firstItem(),
                'to'            =>$usuarios->lastItem()
            ],
            'resultados'=>$usuarios
        ];

    }//FIN SEARCH create



        public function search(Request $request)
    {
        if($request['usuario']['username']!='')
        {
        $usuarios=User::where('username','like','%'.$request['usuario']['username'].'%')
        ->select('id','username','sesion','created_at','id_persona_fisica')
        ->paginate(10);


        for ($i=0; $i <sizeof($usuarios); $i++)
        {
              $id_persona_fisica=$usuarios[$i]->id_persona_fisica;
               if($id_persona_fisica!=0)
               {
                /*
                $elemento=Elemento_policial::where('persona_fisica_id', $id_persona_fisica)->first();
                $datos_elemento=ElementoPolicialV::find($elemento->id);
    */

                  $datos_elemento=Persona_fisica::join('dato_personal', 'persona_fisica.dato_personal_id', '=', 'dato_personal.id')
                    ->where('persona_fisica.id','=',$id_persona_fisica)
                    ->select('persona_fisica.id','nombre','apellido_paterno','apellido_materno')
                    ->first();


                $usuarios[$i]['nombre']=$datos_elemento->nombre;
                $usuarios[$i]['apellido_paterno']=$datos_elemento->apellido_paterno;
                $usuarios[$i]['apellido_materno']=$datos_elemento->apellido_materno;

               // dd( $datos_elemento->nombre);
               }
               else//persona fisica
               {
                $usuarios[$i]['nombre']='Sin información';
                $usuarios[$i]['apellido_paterno']='Sin información';
                $usuarios[$i]['apellido_materno']='Sin información';
               }//fin else persona fisica

               if($usuarios[$i]->sesion==false)
                {
                    $usuarios[$i]['estatus']="Fuera de linea";
                }
                else{
                    $usuarios[$i]['estatus']="En linea";

                }
        }//fin for
        }//if request username <> ''
        else
        {
             $usuario=User::get();
             $usuario_id=array();
        for ($j=0; $j < sizeof($usuario); $j++) {

           array_push($usuario_id,$usuario[$j]->id_persona_fisica);
        }
       // dd($usuario_id);
        $usuarios=Persona_fisica::join('dato_personal', 'persona_fisica.dato_personal_id', '=', 'dato_personal.id')
        ->where('nombre','like','%'.strtoupper($request['usuario']['nombre']).'%')
        ->where('apellido_paterno','like','%'.strtoupper($request['usuario']['paterno']).'%')
        ->where('apellido_materno','like','%'.strtoupper($request['usuario']['materno']).'%')
        ->whereIn('persona_fisica.id', $usuario_id)
        ->select('persona_fisica.id','nombre','apellido_paterno','apellido_materno')
        ->paginate(10);

        for ($k=0; $k <sizeof($usuarios) ; $k++) {
                $usuario=User::where('id_persona_fisica',$usuarios[$k]->id)->first();
                $usuarios[$k]['id']=$usuario->id;
                $usuarios[$k]['username']=$usuario->username;
                $usuarios[$k]['sesion']=$usuario->sesion;


                $fecha_creacion = Carbon::parse($usuario->created_at);//Carbon::now();
                $usuarios[$k]['created_at']=$fecha_creacion->format('d-m-Y');
                if($usuarios[$k]->sesion==false)
                {
                    $usuarios[$k]['estatus']="Fuera de linea";
                }
                else{
                    $usuarios[$k]['estatus']="En linea";
                    }

               }

        }//fin else username <> ''


        return [
            'pagination'=>[
                'total'         =>$usuarios->total(),
                'current_page'  =>$usuarios->currentPage(),
                'per_page'      =>$usuarios->perPage(),
                'last_page'     =>$usuarios->lastPage(),
                'from'          =>$usuarios->firstItem(),
                'to'            =>$usuarios->lastItem()
            ],
            'resultados'=>$usuarios
        ];

    }//FIN SEARCH

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

         $usuario=User::where('id',$request['idUsuario'])
        ->select('id','username','sesion','created_at','id_persona_fisica')
        ->first();

        $datos_elemento=Persona_fisica::join('dato_personal', 'persona_fisica.dato_personal_id', '=', 'dato_personal.id')
            ->where('persona_fisica.id','=',$usuario->id_persona_fisica)
            ->select('nombre','apellido_paterno','apellido_materno')
            ->first();

        $rol=RoleUser::where('role_id',2)
            ->where('user_id',$usuario->id)->first();

        if($rol!=null)
        {
            $usuario['bloqueado']='SI';
        }
        else{
            $usuario['bloqueado']='NO';
        }


        $usuario['nombre']=$datos_elemento->nombre;
        $usuario['apellido_paterno']=$datos_elemento->apellido_paterno;
        $usuario['apellido_materno']=$datos_elemento->apellido_materno;
        if($usuario->sesion==false)
        {
         $usuario['estatus']="Fuera de linea";
        }
         else{
         $usuario['estatus']="En linea";
              }
//falta implementar tiempo activo
return $usuario;


    }//fin show



    public function cerrarSesion(Request $request)
    {
try{
    $usuario = User::find($request['idUsuario']);
        if($usuario->sesion==true)
        {
        $acceso = Acceso::find($usuario->id_acceso);
        $acceso->fecha_exit=Carbon::now();
        $acceso->save();
        $usuario->sesion = false;
        $usuario->id_acceso = 0;
        $usuario->save();
        //$usuario->logout();
        //$usuario->session()->invalidate();
        return 'si';
        }
}
catch(Exception $e)
{
    return 'no';
}



        ///return $request['idUsuario'];

    }//fin logout


    public function bloquear(Request $request)
    {


        $usuario = User::find($request['idUsuario']);

        /*
        if($usuario->sesion==true)
        {
        $acceso = Acceso::find($usuario->id_acceso);
        $acceso->fecha_exit=Carbon::now();
        $acceso->save();
        $usuario->sesion = false;
        $usuario->save();
        $usuario->logout();
        $usuario->session()->invalidate();
        }
        */
        if($request['opcion']=='1')
        {
            $rol=new RoleUser;
            $rol->role_id=2;
            $rol->user_id=$usuario->id;
            $rol->save();
        }
        else{


            $rol=RoleUser::where('role_id',2)
            ->where('user_id',$usuario->id)->first();

            $rol->delete();

        }



    }//fin bloquear

        public function cambiarPass(Request $request)
    {
        try {

            $usuario = User::find($request['idUsuario']);
            $usuario->password=bcrypt($request['pass']);
            $usuario->save();

            return "si";// "Actualizacion correcta";
            }
        catch (Exception $e) {
             return "no";//"Error al actualizar";
        }

    }//fin cambiar pass

    public function store(Request $request)
    {


        try {
             $usuarios=User::get();
             $usuario_id=array();
            for ($j=0; $j < sizeof($usuarios); $j++) {

            array_push($usuario_id,$usuarios[$j]->id_persona_fisica);
            }


            $elemento=ElementoPolicialV::where('id',$request['usuario']['idElemento'])
            ->whereNotIn('id_persona_fisica',$usuario_id)
            ->select('id','id_persona_fisica','nombre','apellido_paterno','apellido_materno','delegacion','fecha_inicio_laboral')
            ->first();

            $usuario =new  User();
            $usuario->username=$request['usuario']['username'];
            $usuario->password=bcrypt($request['usuario']['pass']);
            $usuario->id_persona_fisica=$elemento->id_persona_fisica;
            $usuario->save();
            $permisos=array();
            $permisos=$request['usuario']['permisos'];
            for ($i=0; $i <sizeof($permisos) ; $i++) {

                $role=Roles::where('name','=',$permisos[$i])
                ->select('name','id')
                ->first();

                $rol_usuario=new RoleUser;
                $rol_usuario->user_id=$usuario->id;
                $rol_usuario->role_id=$role->id;
                $rol_usuario->save();

            }//fin for


            $delegaciones=$request['usuario']['delegaciones'];
            for ($i=0; $i <sizeof($delegaciones) ; $i++) {

                $userSuc=new UsuarioSucursal;
                $userSuc->id_usuario=$usuario->id;
                $userSuc->id_sucursal=$delegaciones[$i];
                $userSuc->save();

            }//fin for

            return "si";// "Actualizacion correcta";
            } //fin try
        catch (Exception $e) {
             return "no";//"Error al actualizar";
        }




    }//fin  guardar usuario

public function getPermisos()
{
        $roles=Roles::select('name','id_departamento')
        ->get();


        $departamento=Departamento::select('abreviatura','id')->get();
        $permisos=Array();

        for ($i=0; $i < sizeof($departamento); $i++) {
            # code...
            $permisos[$departamento[$i]->abreviatura]=array();


            for ($j=0; $j < sizeof($roles); $j++) {
            # code...
                if($departamento[$i]->id==$roles[$j]->id_departamento)
                {
                    array_push($permisos[$departamento[$i]->abreviatura],$roles[$j]->name);
                }


            }


        }




        return $permisos;
}//end permisos

public function getSucursales()
{
$delegaciones=Delegacion::select('id','nombre')->get();
/*
$delegacion=Array();
$delegacion["Delegacion"]=array();
$delegacion["vacio"]=array();
for ($i=0; $i < sizeof($delegaciones); $i++) {
$delegacion["Delegacion"][$i]=$delegaciones[$i]->nombre;
}//fin for
*/
return $delegaciones;
}//end get sucursales

}

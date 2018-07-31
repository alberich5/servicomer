<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Acceso;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }


        /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $usuario = User::find(Auth::user()->id);


        $acceso = Acceso::find($usuario->id_acceso);
        $acceso->fecha_exit=Carbon::now();
        $acceso->save();
/*
        $usuario->id_acceso = 0;
        $usuario->save();

*/
        $usuario->sesion = false;
        $usuario->save();
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/');
    }//fin logout


        public function login(Request $request)
    {
		/*
		$usr=User::where('username','=','admin')
	  ->first();
	  $usr->password=bcrypt("1234567");
	  $usr->save();
	  dd($usr);
	  */

   
	  
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            //primera parte

      $acceso = Acceso::where('id_usuario','=',Auth::user()->id)
			->orderBy('id','desc')
			->first();
       $usuario = User::find(Auth::user()->id);
      if($acceso){
             
      
      if($acceso->fecha_exit==null)//no cerro correctamente su sesion
      {
        //bloqueamos al usuario y asignamos la hora actual al
        $acceso->fecha_exit=Carbon::now();
        $acceso->bloqueo_cierre_sesion=true;
        $acceso->save();

      }else{}

        if($acceso->bloqueo_cierre_sesion==true)
        {

          $bloqueo=Carbon::parse($acceso->fecha_exit);
          $fin_bloqueo=$bloqueo->addMinutes(0);
          $actual=Carbon::now();
          if($actual>$fin_bloqueo)//ya termino el tiempo de bloqueo y puede iniciar sesion
          {
          //dd("Termino bloqueo");


            $acceso = new Acceso;
            $acceso->id_usuario=$usuario->id;
            $acceso->fecha_acceso=Carbon::now();
            $acceso->ip=$request->getClientIp();
            $acceso->save();

            $usuario->id_acceso=$acceso->id;
            //$usuario->sesion = true;
            $usuario->save();
            return $this->sendLoginResponse($request);
          }
          else if($actual<$fin_bloqueo){
            //dd("sigue bloqueado");
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('/');
          }

        }
        else {//si cierre de sesion no esta bloqueado false
          //dd("no estaba bloqueado cerro sesion bien");
          $acceso = new Acceso;
          $acceso->id_usuario=$usuario->id;
          $acceso->fecha_acceso=Carbon::now();
          $acceso->ip=$request->getClientIp();
          $acceso->save();

          $usuario->id_acceso=$acceso->id;
          //$usuario->sesion = true;
          $usuario->save();
          return $this->sendLoginResponse($request);
        }
      }else{//no hay acceso previo
        $acceso = new Acceso;
          $acceso->id_usuario=$usuario->id;
          $acceso->fecha_acceso=Carbon::now();
          $acceso->ip=$request->getClientIp();
          $acceso->save();

          $usuario->id_acceso=$acceso->id;
          //$usuario->sesion = true;
          $usuario->save();
          return $this->sendLoginResponse($request);
      }


        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
       $this->incrementLoginAttempts($request);

      return $this->sendFailedLoginResponse($request);
    }



        protected function authenticated(Request $request, $user)
    {
      
	  
	  
	  
        if (Auth::attempt(['username' =>  $request['username'], 'password' => $request['password']])) {
         // Authentication passed...
            $usuario = User::find(Auth::user()->id);
            $usuario->sesion = true;
            $usuario->save();

         return redirect()->intended('/');


     }else{
       $this->guard()->logout();

       $request->session()->invalidate();
       //$errors = [$this->username() => trans('auth.failed')];
     }
    }



}

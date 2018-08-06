<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BUSQUEDA</title>

       <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
      
     
        <link href="{{ asset('css/hint.base.css') }}" rel="stylesheet">


        @yield('css')
    </head>

    <body class="fondo">

  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
         <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">SIPAB</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        
   
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">

        @if (Auth::guest())
               <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                           
                 @else
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->username }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                    <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <span class="glyphicon glyphicon-log-in"></span>   Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    </form>
                    </li>
                    </ul>
                    </li>
                  @endif

        </li>
        </ul>
      
    </div>
  </div>
</nav>

        <div class="container">
       
       @yield('content')

    </div>

  
    <!-- Scripts -->
  <script src="{{ asset('js/jquery-3.3.1.js') }}"></script> 
   
  <script src="{{ asset('js/vue.js') }}"></script> 
  <script src="{{ asset('js/axios.js') }}"></script> 
  <script src="{{ asset('js/bootstrap.min.js') }}"></script> 

  <script src="{{ asset('js/toastr.min.js') }}"></script> 
 
    


    @yield('js')
    </body>
   
</html>

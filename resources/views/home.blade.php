@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Menu Principal</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Page Content -->


      <!-- Introduction Row -->

      <!-- Team Members Row -->
      <div class="row">
        <div class="col-lg-12">

        </div>

		    @can('users.index')
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="{{ route('users.index') }}">
          <img src="{{ asset('/img/menu/admin.png') }}" class="rounded-circle img-fluid d-block mx-auto" title="Administrador" href="{{ route('users.index') }}">
          </a>
          <p>-Usuarios <br>-CRU</p>
        </div>
		    @endcan

        @can('roles.index')
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="{{ route('roles.index') }}">
          <img src="{{ asset('/img/menu/admin.png') }}" class="rounded-circle img-fluid d-block mx-auto" title="Administrador" href="{{ route('users.index') }}">
          </a>
          <p>-Roles <br>-CRUD</p>
        </div>
        @endcan

        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="{{ route('comercializacion.cliente.index') }}">
          <img src="{{ asset('/img/menu/comercializacion.png') }}" class="rounded-circle img-fluid d-block mx-auto" title="Administrador" href="{{ route('comercializacion.cliente.index') }}">
          </a>
          <p>-Roles <br>-CRUD</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="{{ route('juridico.contrato.index') }}">
          <img src="{{ asset('/img/menu/juridico.png') }}" class="rounded-circle img-fluid d-block mx-auto" title="Administrador" href="{{ route('juridico.contrato.index') }}">
          </a>
          <p>Juridico</p>
        </div>








      </div>



    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">DESARROLLO 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('css')

<link href="{{ asset('css/estilos2.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="container" id="crud">
<div class="row">
    <div class="col-md-10 col-md-offset-1">
    
     <div class="panel panel-primary">
      <div class="panel-heading">
        <center>MENU PRINCIPAL</center>
    </div>

      <div class="panel-body"> 
        <div class="col-sm-12">

        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <a href="{{ route('comercializacion.cliente.index') }}">
          <img src="{{ asset('/img/menu/comercializacion.png') }}" class="rounded-circle img-fluid d-block mx-auto" title="Administrador" href="{{ route('comercializacion.cliente.index') }}">
          </a>
          
        </div>

        </div>
      </div>

      <div class="panel-footer">

        <p class="m-0 text-center text-white">DESARROLLO 2018</p>
       
      </div>
    </div>
</div>
</div>

@include('comercializacion.modals.cambioContrasena')



</div>

@endsection
@section('js')
<script type="text/javascript">
new Vue({
el:'#crud',
created: function(){
       this.cambiarContrasena();
      },
data:{
usuario:{contrasena:''}
},

methods:{
                      
                        cambiarContrasena:function()
                        {
                        
                        var url='/admin/usuario/contrasena';
                        
                        axios.get(url).then(response=>{
                          if(response.data.contrasena==false)
                          {
                           
                            $('#cambioContrasena').modal('show');
                            
                          }
                          
                         
                        }).catch(error=>{
                         

                        });

                        },
                        storeCambiarContrasena:function(){
                      var url= '/admin/usuario/contrasena/store';
                        axios.post(url,{
                                        usuario:this.usuario
                                    }).then(response=>{
                                      this.showAlerts(response.data);

                          $('#cambioContrasena').modal('toggle');
                                    }).catch(error=>{
                                    });
                      },
                      showAlerts: function(respuesta){
                      if(respuesta.error==false){

                          toastr.success(respuesta.resultado);//mensaje flotante
                        }
                        else{

                          toastr.error(respuesta.resultado);//mensaje flotante
                        }
                    }
                       


}//end metodos

});

 </script>
@endsection
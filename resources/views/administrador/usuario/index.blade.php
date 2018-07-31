    @extends('administrador.layout')

    @section('css')

    @endsection

    @section('content')
    <!-- Inicio del body del panel -->
<div id="crud">
  <!--Inicio panel de busqueda-->
<form method="POST" v-on:submit.prevent="busqueda">  
   <div class="panel panel-default col-md-10 col-md-offset-1">
    <div class="panel-heading">
      <center><h3 class="panel-title">BUSQUEDA</h3></center>
    </div>
    <div class="panel-body ">

      <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
          <div class="form-group">
            <label for="">Username</label>
            <input type="text" name="" value="" class="form-control"  v-model="searchUsuario.username">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
          <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" name="" value="" class="form-control" style="text-transform:uppercase;" v-model="searchUsuario.nombre">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
          <div class="form-group">
            <label for="">Apellido Paterno</label>
            <input type="text" name="" value="" class="form-control" style="text-transform:uppercase;" v-model="searchUsuario.paterno">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
          <div class="form-group">
            <label for="">Apellido Materno</label>
            <input type="text" name="" value="" class="form-control" style="text-transform:uppercase;" v-model="searchUsuario.materno">
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
          <button type="submit" class="btn btn-default">
          <span class="glyphicon glyphicon-search"></span> Buscar
          </button>
          <button type="button" class="btn btn-default" v-on:click="limpiar()" title="Borra los campos de busqueda">
           Limpiar
          </button>
        </div>
      </div>



    </div>
  </div>
</form> 
  <!--Fin panel de busqueda-->


  <!--Inicio panel de resultados-->
  <div  class="panel panel-default col-md-10 col-md-offset-1">
    <div class="panel-heading">
      <center><h3 class="panel-title">Usuarios</h3></center>
    </div>
    <div class="panel-body  table-responsive">
              <table class="table table-hover table-striped table-bordered" >
            <thead class="btn-default">
              <tr >

                <th colspan="1" >
                 Opciones
                </th>

                <th><center>
                    <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                      <input type="checkbox"  value="Exp" style="-webkit-appearance: none;">ID
                    </label>
                  </center>
                </th>

                <th><center>
                    <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                      <input type="checkbox"  value="Exp" style="-webkit-appearance: none;">Username
                    </label>
                  </center>
                </th>

                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >Nombre
                  </label>
                </center></th>


                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >Ap. Paterno
                  </label>
                </center></th>

                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >Ap. Materno
                  </label>
                </center></th>

                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >F. creación
                  </label>
                </center></th>

                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >Estatus
                  </label>
                </center></th>

              </tr>
            </thead>
            <tbody>
              
                <tr v-for="usuario in filter" >

                <th colspan="1">
                    
                   
                    <a href="#" class="btn btn-default" v-on:click="ver(usuario.id)" title="Ver">
                  
                          <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 
                    </a>

                    <a href="#" class="btn btn-default" v-on:click="cambiar(usuario.id)" title="Cambio de contraseña">
                  
                          <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 
                    </a>
                    
                   
                 

                </th>

                <th><center v-text="usuario.id">

                  </center>
                </th>

                <th><center v-text="usuario.username">
                 
                </center></th>

                <th><center v-text="usuario.nombre">
                  
                </center></th>

                <th><center v-text="usuario.apellido_paterno">
                   
                </center></th>

                <th><center v-text="usuario.apellido_materno">
                
                </center></th>

                <th><center v-text="usuario.created_at">
                
                </center></th>

                <th><center>
                  <span class="label label-danger" v-show="usuario.estatus=='Fuera de linea'" v-text="usuario.estatus"></span>
                
                  <span class="label label-success" v-show="usuario.estatus=='En linea'" v-text="usuario.estatus"></span>

                 
                </center></th>

              </tr>
            </tbody>
          </table>
      

      
    </div>
</div> <!--Fin modal tabla  -->



  <div class="modal fade" id="Cambiar" tabindex="-1" role="dialog" aria-labelledby="Cambiar">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
          <center><h4 class="modal-title" id="myModalLabel">Usuario</h4></center>
         
        </div>
        <div class="modal-body">
          

         <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Cambio de contraseña</th>
                     
                    </thead>
                    <tbody>
                      <tr> <td>Nombre de usuario</td>  <td>@{{ usuario.username }}</td> </tr>

                      <tr> <td>Estatus</td>  
                        <td v-show="usuario.estatus=='Fuera de linea'"><span class="label label-danger">@{{ usuario.estatus }}</span></td> 

                        <td v-show="usuario.estatus=='En linea'"><span class="label label-success">@{{ usuario.estatus }}</span></td>
                      </tr>

                      <tr>  <td>Contraseña</td>  
                            <td><input type="password" id="password1">
                                <input type="checkbox" onchange="document.getElementById('password1').type = this.checked ? 'text' : 'password'"> Ver Contraseña
                            </td> 
                      </tr>
                      <tr> <td>Confirmar contraseña</td>
                           <td>
                            <input required type="password" id="confirmPassword" >
                            <span id="errorPass" class="label label-danger" ></span>  
                           </td> 
                      </tr>
                     
                    </tbody>
                  </table>
            </div>

         </div><!--row-->
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger" v-on:click="cambiarContraseña()">Guardar</button>
        </div>
      </div>
    </div>
  </div>
<!--fin modal cambio de contraseñ -->

  <div class="modal fade" id="Ver" tabindex="-1" role="dialog" aria-labelledby="Ver">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
          <center><h4 class="modal-title" id="myModalLabel">Usuario</h4></center>
         
        </div>
        <div class="modal-body">
          

         <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Mostrar Usuario</th>
                     
                    </thead>
                    <tbody>
                      <tr> <td>Id</td>  <td>@{{ usuario.id }}</td> </tr>

                      <tr> <td>Nombre de usuario</td>  <td>@{{ usuario.username }}</td> </tr>

                      <tr> <td>Estatus</td>  
                        <td id="showEstatus1" v-show="usuario.estatus=='Fuera de linea'"><span class="label label-danger">@{{ usuario.estatus }}</span></td> 

                        <td id="showEstatus2" v-show="usuario.estatus=='En linea'"><span class="label label-success">@{{ usuario.estatus }}</span></td>
                      </tr>

   
                    </tbody>
                  </table>
            </div>

         </div><!--row-->



        <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Datos Personales</th>
                     
                    </thead>
                    <tbody>
                      
                      <tr> <td>Nombre</td>  <td>@{{ usuario.nombre }}</td> </tr>

                      <tr> <td>Apellido Paterno</td>  <td>@{{ usuario.apellido_paterno }}</td> </tr>

                      <tr> <td>Apellido Materno</td>  <td>@{{ usuario.apellido_materno }}</td> </tr>

                      

                    </tbody>
                  </table>
            </div>

         </div><!--row-->

        <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Opciones</th>
                     
                    </thead>
                    <tbody>
                      
                      <tr> 
                        <td id="cerrarS">
                          <a href="#" class="btn btn-default" v-on:click="cerrarSesion(usuario.id)" title="Cerrar sesión" v-show="usuario.estatus=='En linea'">
                          <span class="glyphicon glyphicon-off" aria-hidden="true">Cerrar sesion</span> 
                          </a>
                        </td> 

                        <td id="bloquear" v-show="usuario.bloqueado=='NO'">
                          <a href="#" class="btn btn-default" v-on:click="bloquear(usuario.id,'1')" title="Bloquear">
                          <span class="glyphicon glyphicon-ban-circle" aria-hidden="true">Bloquear</span> 
                          </a>
                        </td>


                        <td id="desbloquear" v-show="usuario.bloqueado=='SI'">
                          <a href="#" class="btn btn-default" v-on:click="bloquear(usuario.id,'2')" title="Desbloquear">
                          <span class="glyphicon glyphicon-ok-circle" aria-hidden="true">Desbloquear</span> 
                          </a>
                        </td>


                      </tr>


                      

                    </tbody>
                  </table>
            </div>

         </div><!--row-->





      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
<!--inicio paginacion -->
 <div  class="panel panel-default col-md-10 col-md-offset-1">
    
    <div class="panel-body  ">


    <nav>
      <ul class="pagination">
        <li v-if="pagination.current_page > 1">
          <a href="#" @click.prevent="changePage(pagination.current_page - 1)">
            <span>Atras</span>
          </a>
        </li>

        <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
          <a href="#" @click.prevent="changePage(page)">
            @{{ page }}
          </a>
        </li>

        <li v-if="pagination.current_page < pagination.last_page">
          <a href="#" @click.prevent="changePage(pagination.current_page + 1)">
            <span>Siguiente</span>
          </a>
        </li>
      </ul>
    </nav>
</div>
</div>
    <div class="row">
        <div class="col-xs-12">
            <pre>@{{$data}}</pre>
        </div>
    </div>


  </div>

    <!--Fin panel de resultados-->
    <!-- Fin del body del panel -->

    
    @endsection
    @section('js')




    


 <script type="text/javascript">
new Vue({
el:'#crud',
data:{

  usuarios:[],
  prueba:[],
  searchUsuario:{username:'',nombre:'',paterno:'',materno:''},
  
  idUsuario:'',
  usuario:{},
  documentacion:[],
  escolaridad:{},
  domicilio:{},
  contactos:[],
  pagination:{
    'total':0,
    'current_page':0,
    'per_page':0,
    'last_page':0,
    'from':0,
    'to':0
    },
    offset: 3
},
computed:{
  filter: function(atributo)
  {
    return _.orderBy(this.usuarios,  ['atributo'], ['asc'])
  },
  isActived:function(){
return this.pagination.current_page;
  },
  pagesNumber:function(){
 if(!this.pagination.to){
        return [];
      }

      var from = this.pagination.current_page - this.offset; 
      if(from < 1){
        from = 1;
      }

      var to = from + (this.offset * 2); 
      if(to >= this.pagination.last_page){
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while(from <= to){
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
  }
},
methods:{
                      
                        busqueda:function(pagina)
                        {
                        
                        var url='/admin/usuario/search';
                        
                        axios.post(url,{
                            usuario:this.searchUsuario,
                            page:pagina
                            
                        }).then(response=>{
                          if(response.data.resultados.data===null)
                          {
                            this.usuarios=array();
                          }
                          else
                          {
                            this.usuarios=response.data.resultados.data;
                            this.pagination=response.data.pagination;
                          }
                          
                         
                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }
                        ,


                        ver:function($id)
                        {

                          var url='/admin/usuario/show';
                          axios.post(url,{
                            idUsuario:$id
                        }).then(response=>{
                          
                          this.usuario=response.data;

                          $('#Ver').modal('show');

                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }

                        ,

                        cerrarSesion:function($id)
                        {

                          var url='/admin/usuario/cerrar-sesion';
                          axios.post(url,{
                            idUsuario:$id,
                           
                        }).then(response=>{


                          if(response.data=='si')
                          {
                            document.getElementById('cerrarS').style.display = 'none';
                            document.getElementById('showEstatus1').style.display='block';
                            document.getElementById('showEstatus2').style.display='none';
                            this.usuario.estatus="Fuera de linea";
                            this.updatePage();
                          }
                          else
                          {
                            
                          }
                        

                        

                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }

                        ,

                        bloquear:function($id,$opcion)
                        {

                          var url='/admin/usuario/bloquear';
                          axios.post(url,{
                            idUsuario:$id,
                            opcion:$opcion
                        }).then(response=>{
                          var bloq = document.getElementById('bloquear');
                          var desbloq = document.getElementById('desbloquear');
                          if($opcion=='1')
                          {
                             bloq.style.display = 'none';
                             desbloq.style.display='block';
                           }
                         else
                         {
                             bloq.style.display = 'block';
                             desbloq.style.display='none';
                         }
                          

                        

                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }

                        ,
                        cambiar:function($id)
                        {
                          var pass1 = document.getElementById('password1');
                          var pass2 = document.getElementById('confirmPassword');
                          var etiq  = document.getElementById('errorPass');
                            this.idUsuario=$id;
                            etiq.className="label label-danger";
                            etiq.textContent="";
                            pass1.value="";
                            pass2.value="";

                            var url='/admin/usuario/show';
                          axios.post(url,{
                            idUsuario:$id
                        }).then(response=>{
                          
                          this.usuario=response.data;

                          $('#Cambiar').modal('show');

                        }).catch(error=>{
                          this.errors=error.response.data

                        });
                           
                        }

                        ,
                        cambiarContraseña:function()
                        {

                          var pass1 = document.getElementById('password1');
                          var pass2 = document.getElementById('confirmPassword');
                          var etiq  = document.getElementById('errorPass');
                           
                          if(pass1.value==pass2.value)
                          {
                           
                          var url='/admin/usuario/cambiar-pass';
                          axios.post(url,{
                            idUsuario: this.idUsuario,
                            pass:pass1.value
                            }).then(response=>{

                              if(response.data=="si")
                              {
                                etiq.textContent="Actualizacion correcta";
                                etiq.className="label label-success";

                                pass1.value="";
                                pass2.value="";
                              }
                              else{

                                etiq.textContent="Error al actualizar";
                                etiq.className="label label-danger";
                                pass2.value="";
                              }
                              
                             
                              
                            }).catch(error=>{
                            this.errors=error.response.data

                        
                            });
                            
                          }//if las contraseñas coinciden
                         else
                         {
                              document.getElementById('confirmPassword').value="";
                             document.getElementById('errorPass').textContent="Las contraseñas no coinciden";
                         }//fin else


                        

                        }

                        ,
                        
                       
                        changePage:function(page){
                          this.pagination.current_page=page;
                          this.busqueda(page);
                          
                        },
                        updatePage:function(){
                          
                          this.busqueda(this.pagination.current_page);
                          
                        },
                        limpiar:function(){
                          
                          this.searchUsuario.username='';
                          this.searchUsuario.nombre='';
                          this.searchUsuario.paterno='';
                          this.searchUsuario.materno='';
                          
                        }


}//end metodos

});

 </script>
    @endsection
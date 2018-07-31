    @extends('administrador.layout')

    @section('css')
        <link rel="stylesheet" href="{{asset('css/jquery.octofilter.css')}}"> 
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
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
            <label for="">ID</label>
            <input type="text" name="" value="" class="form-control"  v-model="searchUsuario.id">
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
                    <input type="checkbox" style="-webkit-appearance: none;" >Delegacion
                  </label>
                </center></th>

                <th><center>
                  <label class="btn btn-default" style="display: block; width: 100%; height:100%">
                    <input type="checkbox" style="-webkit-appearance: none;" >Fecha inicio laboral
                  </label>
                </center></th>

              </tr>
            </thead>
            <tbody>
              
                <tr v-for="elemento in filter" >

                <th colspan="1">
                    
                   
                    <a href="#" class="btn btn-default" v-on:click="ver(elemento.id)" title="Ver">
                  
                          <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> 
                    </a>

                    <a href="#" class="btn btn-default" v-on:click="crear(elemento.id)" title="Crear usuario">
                  
                          <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                    </a>
                    
                   
                 

                </th>

                <th><center v-text="elemento.id">
                  </center>
                </th>

                <th><center v-text="elemento.nombre">
                </center></th>

                <th><center v-text="elemento.apellido_paterno">
                </center></th>

                <th><center v-text="elemento.apellido_materno">
                </center></th>

                <th><center v-text="elemento.delegacion">
                </center></th>

                <th><center v-text="elemento.fecha_inicio_laboral">
                </center></th>

                <th><center v-text="elemento.estatus">
                </center></th>

              </tr>
            </tbody>
          </table>
      

      
    </div>
</div> <!--Fin modal tabla  -->


<!--fin show -->

  <div class="modal fade" id="Ver" tabindex="-1" role="dialog" aria-labelledby="Ver">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
          <center><h4 class="modal-title" id="myModalLabel">Elemento Policial</h4></center>
         
        </div>
        <div class="modal-body">
          

         <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Mostrar Elemento Policial</th>
                     
                    </thead>
                    <tbody>
                      <tr> <td>Id</td>  <td v-text="elemento.id"></td> </tr>

                      <tr> <td>Delegacion</td>  <td v-text="elemento.delegacion"></td> </tr>

                      <tr> <td>Reingreso</td>  <td >-</td> </tr>

                      <tr> <td>Administrativo</td>  <td v-text="elemento.administrativo"></td> </tr>

                      <tr> <td>Estatus</td>  <td v-text="elemento.estatus"></td> </tr>
                  
                      <tr> <td>Usuario que Registra</td>  <td >-</td> </tr>

                      <tr> <td>Firma</td>  <td >-</td> </tr>

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
                      <tr> <td>CURP</td>  <td v-text="elemento.curp"></td> </tr>

                      <tr> <td>RFC</td>  <td v-text="elemento.rfc"></td> </tr>

                      <tr> <td>Nombre</td>  <td v-text="elemento.nombre"></td> </tr>

                      <tr> <td>Apellido Paterno</td>  <td v-text="elemento.apellido_paterno"></td> </tr>

                      <tr> <td>Apellido Materno</td>  <td v-text="elemento.apellido_materno"></td> </tr>

                      <tr> <td>Fecha de Nacimiento</td>  <td v-text="elemento.fecha_nacimiento"></td> </tr>

                      <tr> <td>Pais de Nacimiento</td>  <td ></td></tr>

                      <tr> <td>Nacionalidad</td>  <td ></td></tr>

                      <tr> <td>Entidad de Nacimiento</td>  <td ></td></tr>

                      <tr> <td>Municipio de Nacimiento</td>  <td ></td></tr>

                      <tr> <td>Ciudad de Nacimiento</td>  <td ></td></tr>

                      <tr> <td>Genero</td>  <td v-text="elemento.genero"></td></tr>

                      <tr> <td>Estado Civil</td>  <td v-text="elemento.estado_civil"></td></tr>

                    </tbody>
                  </table>
            </div>

         </div><!--row-->




        <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Contacto</th>
                     
                    </thead>
                    <tbody>
                      <tr v-for="contacto in contactos"> <td v-text="contacto.tipo"></td>  <td v-text="contacto.dato"></td> </tr>

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
<!-- fin modal ver -->
  <div class="modal fade" id="Crear" tabindex="-1" role="dialog" aria-labelledby="Cambiar">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
          <center><h4 class="modal-title" id="myModalLabel">Elemento</h4></center>
         
        </div>
        <div class="modal-body">
          

         <div class="row table-responsive ">
            <div class="col-sm-7 col-sm-offset-1 without-padding">
                  
              <table class="table">
                    <thead >
                      <th colspan="2">Datos de Elemento</th>
                     
                    </thead>
                    <tbody>
                      <tr> <td>Id</td>  <td v-text="elemento.id"></td> </tr>
                      <tr> <td>Delegacion</td>  <td v-text="elemento.delegacion"></td> </tr>
                      <tr> <td>Administrativo</td>  <td v-text="elemento.administrativo"></td> </tr>
                      <tr> <td>Estatus</td>  <td v-text="elemento.estatus"></td> </tr>
                      <tr> <td>Nombre</td>  <td >@{{ elemento.nombre+" "+elemento.apellido_paterno+" "+elemento.apellido_materno }}</td> </tr>

                      <tr> <td>Fecha de Nacimiento</td>  <td v-text="elemento.fecha_nacimiento"></td> </tr>

                      


                      <tr> 
                        <table class="table">
                          <thead >
                              <th colspan="2">Datos de usuario</th>
                              <th><span id="errorUsuario" class="label label-danger" ></span>  </th>
                     
                          </thead>
                          <tbody>
                      <tr> 
                        <td>Nombre de usuario</td> 
                        <td>
                          
                          <input type="text" id="usern" v-model='usuario.username'>
                        </td> 
                        
                      </tr>

                      <tr>  <td>Contraseña</td>  
                            <td><input type="password" id="password1">
                                <input type="checkbox" onchange="document.getElementById('password1').type = this.checked ? 'text' : 'password'"> Ver Contraseña
                            </td> 
                      </tr>
                      <tr> <td>Confirmar contraseña</td>
                           <td>
                            <input v-model='usuario.pass' required type="password" id="confirmPassword" >
                            <span id="errorPass" class="label label-danger" ></span>  
                           </td> 
                      </tr>

                          </tbody>
                        </table>
                      </tr>


                      <tr> 
                        <table class="table">
                          <thead >
                              <th>Permisos</th>
                              <th><span id="errorPermisos" class="label label-danger" >skjdfbhggsiuf</span>  </th>
                     
                          </thead>
                          <tbody>
                            <tr > 
                              <td id="td-permisos">
                                
                                </td>
                            </tr>

                          </tbody>
                        </table>
                      </tr>


                      
                      


                      <tr> 
                        <table class="table">
                          <thead >
                              <th >Delegacion</th>
                              <th><span id="errorDelegacion" class="label label-danger" >skjdfbhggsiuf</span>  </th>
                          </thead>
                          <tbody>
                            <tr v-for="delegacion in delegaciones"> <td><input type="checkbox" name="delegacion" :value="delegacion.id" v-model="usuario.delegaciones"
                              ></td>  <td v-text="delegacion.nombre"> </td> </tr>

                          </tbody>
                        </table>
                      </tr>





                     
                    </tbody>
                  </table>
            </div>

         </div><!--row-->
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger" v-on:click="guardar">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- fin modal agregar usuario-->


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

  elementos:[],
  prueba:[],
  searchUsuario:{id:'',nombre:'',paterno:'',materno:''},
  usuario:{idElemento:'',username:'',pass:'',permisos:[],delegaciones:[]},
  idUsuario:'',
  elemento:{},
  contactos:[],
  permisos:[],
  delegaciones:[],
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
    return _.orderBy(this.elementos,  ['atributo'], ['asc'])
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
                        
                        var url='/admin/usuario/searchCreate';
                        
                        axios.post(url,{
                            elemento:this.searchUsuario,
                            page:pagina
                            
                        }).then(response=>{
                          if(response.data.resultados.data===null)
                          {
                            this.elementos=array();
                          }
                          else
                          {
                            this.elementos=response.data.resultados.data;
                            this.pagination=response.data.pagination;
                          }
                          
                         
                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }
                        ,


                        ver:function($id)
                        {


                          var url='/recursos/elemento/show';
                          axios.post(url,{
                            idElemento:$id
                        }).then(response=>{
                          
                          this.elemento=response.data.elemento;
                          
                          this.contactos=response.data.contacto;
/*
                          this.escolaridad=response.data.escolaridad;
                          this.documentacion=response.data.documentacion;
                          this.domicilio=response.data.domicilio;
*/
                          $('#Ver').modal('show');

                        }).catch(error=>{
                          this.errors=error.response.data

                        });

                        }
                        ,

                        crear:function($id)
                        {
                          
                          this.usuario.idElemento=$id;
                          this.usuario.username='';
                          this.usuario.pass='';
                          this.usuario.permisos=[];
                          this.usuario.delegaciones=[];



                         divd=document.getElementById("td-permisos");
                         formd=document.getElementById("form-permisos");
                         if(formd)
                         {
                          divd.removeChild(formd);
                         }
 
                         formPermisos=document.createElement('FORM');
                         formPermisos.id='form-permisos';
                         formPermisos.action='/';

                          var x = document.createElement("input");
                          x.setAttribute("id", "permisosInput");
                          x.setAttribute("type", "text");
                          x.setAttribute("placeholder", "Escribe para buscar...");    
                          x.setAttribute("class", "octofilter-input");

                          formPermisos.appendChild(x);
                          divd.appendChild(formPermisos);


                         

                           var url='/admin/usuario/permisos';
                          axios.get(url).then(response=>{
                          this.permisos=response.data;
                             $('#permisosInput').octofilter({
                                  source:  this.permisos

                                           });

                          //limpia los seleccionados
                          var spanOpciones=document.getElementsByTagName('a');
                          for (var i=0; i< spanOpciones.length ;i++) 
                          {
                            if(spanOpciones[i].className=='octofilter-link octofiltered')
                            {

                              //alert( spanOpciones[i].innerHTML);
                              spanOpciones[i].className='octofilter-link';
                            }
                          
                        
                          }//fin for

                          

                        }).catch(error=>{
                          this.errors=error.response.data

                        });


                        var url='/admin/usuario/sucursales';
                          axios.get(url).then(response=>{
                          this.delegaciones=response.data;
                            /* $('#delegacionesInput').octofilter({
                                  source:  this.delegaciones

                                           });

                                           */
                        }).catch(error=>{
                          this.errors=error.response.data

                        });



                          var url='/recursos/elemento/show';
                          axios.post(url,{
                            idElemento:$id
                        }).then(response=>{
                          
                          this.elemento=response.data.elemento;
                           
                          $('#Crear').modal('show');

                        }).catch(error=>{
                          this.errors=error.response.data

                        });



                       


                           
                        }
                        ,

                        guardar:function()
                        {
//textContent
                          //var inputTag=document.getElementById('octofilter-input');
                          this.usuario.permisos=[];
                          var spanInput=document.getElementsByClassName('octofilter-label');
                          //spanInput.length
                          //alert(spanInput[0].textContent);
                          //var tmp_permisos=[];

                          for (var i=0; i< spanInput.length ;i++) 
                          {

                            var spanTexto = spanInput[i].textContent;
                            var tam=spanTexto.length-1;
                            tmp_spanTexto = spanTexto.substring(0, tam);
                            this.usuario.permisos.push(tmp_spanTexto);
                          }


                          if(this.usuario.permisos.length===0)
                          {
                           // alert("vacio");
                          }

                          var url='/admin/usuario/store';
                          axios.post(url,{
                            idElemento:this.idUsuario,
                            usuario:this.usuario
                            

                        }).then(response=>{
                          
                        //  this.prueba=response.data;//.elemento;
                         alert(response.data);
                          

                        }).catch(error=>{
                          this.errors=error.response.data

                        });
                           
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
   <script src="{{asset('js/jquery.octofilter.js')}}" ></script>

  <script>
    

  </script>


    @endsection
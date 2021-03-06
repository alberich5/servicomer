@extends('comercializacion.layout')

@section('css')

<link href="{{ asset('css/estilos.css') }}" rel="stylesheet">

@endsection

@section('content')

<div id="crud" class="row">
	<div class="col-sm-12">
	</div>

<!-- PANEL DE BUSQUEDA -->
 <form method="POST" id="formBusqueda" v-on:submit.prevent="search">
	 <div class="panel panel-primary">
         <div class="panel-heading">BUSQUEDA POR CLIENTE: </div>

		 <div class="panel-body">
		     <div class="col-sm-5">


			   <div class="form-group">
			      <label for="texto">ID:</label>
			      <input type="text" class="form-control" placeholder="ID" v-model="searchCliente.id" >
			   </div>

			   <div class="form-group">
			      <label for="t2">Razon Social:</label>
			      <input type="text" class="form-control" placeholder="Razon Social" v-model="searchCliente.razon_social">
			   </div>
			   <div class="form-group">
			      <label for="t2">Nombre comercial:</label>
			      <input type="text" class="form-control" placeholder="Nombre Comercial" v-model="searchCliente.nombre_comercial">
			   </div>

			   <div class="form-group">
			      <label for="fecha">Fecha Alta:</label>
			      <input type="date" class="form-control" placeholder="" v-model="searchCliente.fecha">
			   </div>


		   </div>
		 </div>

      <div class="panel-footer">


      	<button type="submit" class="btn btn-sm btn-default">
         <span class="glyphicon glyphicon-search"></span> Buscar
        </button>

      	<button type="reset" class="btn btn-sm btn-default"  v-on:click.prevent="limpiar()">
      	<span class="glyphicon glyphicon-erase"></span>
      	Limpiar
      	</button>

      </div>
    </div>
</form>

<!-- PANEL DE FILTRADO -->

    <div class="panel panel-primary">
      <div class="panel-heading">
      	<div class="btn-group pull-right">
		          <a v-on:click.prevent="create()"   class="btn btn-default btn-sm "   >
		          		<span class="hint--top" data-hint="Agregar Cliente">
		              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		          </a>
		      </div>
      	<center>RESULTADOS</center></div>
      <div class="panel-body">



<!-- LISTADO -->

      	<div class="col-sm-12">
      		<div class="panel panel-primary">
      		<div class="panel-heading col-sm-12">

      			Listado obtenido
      		</div>

      		<div class="panel-body">

      			<div class="col-sm-12">
				<table class="table table-bordered table-hover"  id="myTable">
				<thead>
					<tr>
					<th>Opciones</th>
					<th class="flechas" id="thId" @click="sort('id','thId')">ID</th>
				    <th class="flechas" id="thRazonSocial" @click="sort('razon_social','thRazonSocial')">RAZON SOCIAL</th>
				    <th class="flechas" id="thEstatus" @click="sort('estatus','thEstatus')">ESTATUS</th>
				    <th class="flechas" id="thServicios" @click="sort('id','thServicios')">SERVICIOS</th>

					</tr>
				</thead>
				<tbody >
				<tr  v-for="cliente in reordenamiento">
<!-- BOTONES DE OPCIONES -->
					<td>
				        <div class="btn-group">
				          <a v-on:click.prevent="addServicio(cliente.id)" class="btn btn-default ">
				            <span class="hint--top" data-hint="Agregar Servicio">
				            <span class="glyphicon glyphicon-plus"></span>
				            </span>
				          </a>

				          <a href="#" class="btn btn-default" v-on:click.prevent="showClienteHistorial(cliente.id)">
				            <span class="hint--top" data-hint="Historial Servicios">
				              <span class="glyphicon glyphicon-list"></span>
				            </span>
				          </a>
				          <a href="#" class="btn btn-default " v-on:click.prevent="editaCliente(cliente.id)">
				            <span class="hint--top" data-hint="Editar">
				              <span class="glyphicon glyphicon-pencil"></span>
				            </span>
				          </a>

				           <a v-on:click.prevent="showCliente(cliente.id)" class="btn btn-default ">
				            <span class="hint--top" data-hint="Ver detalle Servicio">
				            <span class="glyphicon glyphicon-eye-open"></span>
				            </span>
				          </a>
				        </div>
      				</td>

					<td v-text="cliente.id"></td>
				    <td v-text="cliente.razon_social"></td>
				    <td>
				    	<span class="label label-danger" v-show="cliente.estatus==false" >INACTIVO</span>

				    	<span class="label label-success" v-show="cliente.estatus==true" >ACTIVO</span>
				    </td>
				    <td  >
				    	<table class="table table-bordered table-hover">
				          <thead>
				            <tr>
				            <th></th>
				            <th>id</th>
				            <th>nombre</th>
				            </tr>
				          </thead>
				          <tbody >
				            <tr  v-for="serv in cliente.servicios">
				            	<td>
				            		<a v-on:click.prevent="showServicio(serv.id)" class="btn btn-default ">
						            <span class="hint--top" data-hint="Ver detalle Servicio">
						            <span class="glyphicon glyphicon-eye-open"></span>
						            </span>
						          	</a>
				            	</td>
				            	<td v-text="serv.id"></td>
				    			<td v-text="serv.nombre_comercial"></td>
				            </tr>

				          </tbody>
				        </table>
				    </td>

				</tr>
				</tbody>
				</table>



			</div>
      		</div>

    		</div>
      	</div>
       </div>

<!-- PAGINACION -->
      <div class="panel-footer">
      	<center>
      	<nav>
				<ul class="pagination">
					<li v-if="pagination.current_page > 1">
						<a href="#" @click.prevent="changePage(pagination.current_page - 1)">
							<span>Atras</span>
						</a>
					</li>

					<li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'active' : '']">
						<a href="#" @click.prevent="changePage(page)"  v-text="page">
						</a>
					</li>

					<li v-if="pagination.current_page < pagination.last_page">
						<a href="#" @click.prevent="changePage(pagination.current_page + 1)">
							<span>Siguiente</span>
						</a>
					</li>
				</ul>
			</nav>
			</center>

      </div>
    </div>


	<div class="col-sm-12">
		<br><br>
		<pre>
			@{{ $data }}
		</pre>
	</div>

	@include('comercializacion.modals.crearCliente')
	@include('comercializacion.modals.verCliente')
	@include('comercializacion.modals.editarCliente')
	@include('comercializacion.modals.agregarServicio')
	@include('comercializacion.modals.agregarContacto')
	@include('comercializacion.modals.agregarElementos')
	@include('comercializacion.modals.verServicio')
	@include('comercializacion.modals.editarContacto')
	@include('comercializacion.modals.editarModalidad')
	@include('comercializacion.modals.historialServicios')


</div>

@endsection

@section('js')

<script type="text/javascript">
		new Vue({
			el: '#crud',
			created: function(){
				this.verdelegacion();
			},

			data:{
				searchCliente:{id:'',razon_social:'',nombre_comercial:'',fecha:''},
				clientes:[],
				nuevoCliente:{num_cliente:'',razon_social:'',nombre_comercial:'',fecha:'',domicilio_fiscal:'',domicilio_fiscal:'',rfc:'',giro:'',cargo:'',notificacion:'',id_delegacion:'',tipo_contrato:'',replegal:''},
				giros:[],
				mostrarCliente:{razonSocial:'',domicilioFiscal:'',estatus:'',fecha:'',id:'',estado:''},
				nuevoServicio:{id_cliente:'',nombre_comercial:'',domicilio:'',municipio:'',giro:'',riesgo:'',id_delegacion:'',fecha_contratacion:'',observacion:'',contactos:[],elementos:[]},
				verdelegacion:[],
				delegaciones:[],
				subdelegaciones:[],
				nuevoContacto:{id:'',nombre:'',tipo:'',dato:''},
				horario1:'08:00',
				horario2:'08:00',
				nuevoElemento:{id:'',tipo:'',cantidad:'',tipo_turno:'',horario:''},
				mostrarClienteHistorial:[],
				editarCliente:{},
				mostrarServicio:{},
				id_contacto:'',
				id_modalidad:'',
				editContacto:{},
				editModalidad:{},
				//variables base
				firstOptions: null,
								secondOption: null,
								list: {
								  'SEGURIDAD Y VIGILANCIA': [
									  { id:'1',tipo_servicio:'SIN ARMA POR ELEMENTO EN UN TURNO DE 12HRS, POR 1 MES', precio:'13,632.00' },
									  { id:'1',tipo_servicio:'SIN ARMA POR ELEMENTO EN UN TURNO DE 12HRS, POR 15 DIAS', precio:'7,131.00'},
									  { id:'1',tipo_servicio:'CON 1 ARMA POR ELEMENTO EN UN TURNO DE 12HRS, POR 1 MES', precio:'14,588.00'},
									  { id:'1',tipo_servicio:'CON 1 ARMA POR ELEMENTO EN UN TURNO DE 12HRS, POR 15 DIAS', precio:'7,718.00'},
									  { id:'1',tipo_servicio:'CON 1 ARMA POR ELEMENTO, MAS RELEVO EN UN TURNO DE 12 HRS POR 1 MES', precio:'29,176.00'},
									  { id:'1',tipo_servicio:'DE OFICIALIDAD CON UN ARMA, POR ELEMENTO EN UN TURNO DE 12HRS, POR 1 MES', precio:'16,745.00'},
									  { id:'1',tipo_servicio:'DE OFICIALIDAD CON UN ARMA, POR ELEMETO EN UN TURNO DE 12 HRS, POR 1 SEMANA', precio:'4,423.00'},
									  { id:'1',tipo_servicio:'ESCOLTA, CON UN ARMA POR ELEMETO EN UN TURNO DE 12 HRS, POR 1 MES', precio:'19,048.00' },
									  { id:'1',tipo_servicio:'ESCOLTA CON UN ARMA POR ELEMENTO EN UN TURNO DE 12 HRS, POR 1 SEMANA', precio:'5,028.00' },
									  { id:'1',tipo_servicio:'ESCOLTA CON VEHICULO DE MOTOR CON DOS ELEMENTOS ARMADOS A BORDO, EN UN TURNO DE 12HRS POR 1 MES', precio:'72,127.00' },
									  { id:'1',tipo_servicio:'ESCOLTA CON VEHICULO DE MOTOR CON DOS ELELEMTOS ARMADOS A BORDO, EN UN TURNO DE 12HRS POR 1 SEMANA', precio:'18,415.00' },
									  { id:'1',tipo_servicio:'ESCOLTA CON VEHICULO DE MOTOR CON DOS ELELEMTOS ARMADOS A BORDO, MAS RELEVOS, TURNO DE 24HRS POR MES', precio:'144,255.00' },
									  { id:'1',tipo_servicio:'CON MOTOCICLETA, DOS ELELEMTOS ARMADOS A BORDO EN UN TURNO DE 12HRS, POR 1 MES', precio:'49,650.00' },
									  { id:'1',tipo_servicio:'CON MOTOCICLETA Y DOS ELEMENTOS ARMADOS A BORDO EN UN TURNO DE 12HRS, POR 1 SEMANA', precio:'12,638.00' },
									  { id:'1',tipo_servicio:'CON CUATRIMOTO Y DOS ELEMETOS ARMADOS A BORDO EN UN TURNO DE 12HRS, POR 1 MES', precio:'63,190.00' },
								  ],
								  'POR OTROS SERVICIOS': [
									  {id:'2', tipo_servicio:'POR ELEMENTO POR 1 MES', precio:'2,076.00'},
									  {id:'2', tipo_servicio:'ARMA ADICIONAL POR 1 MES', precio:'1,715.00'}
								  ],
								  'VIGILANCIA ADMINISTRATIVA': [
									  {id:'3', tipo_servicio:'SIN ARMA, POR UN ELEMENTO POR UN TURNO DE 12HRS, POR 1 MES', precio:'12,547.00'},
									  {id:'3', tipo_servicio:'SIN ARMA, POR UN ELEMENTO POR UN TURNO DE 12HRS, POR 15 DIAS', precio:'6,499.00'}
								  ],
								  'SEGURIDAD Y VIGILANCIA ESPECIALES': [
									  {id:'4', tipo_servicio:'POR ELEMENTO SIN ARMA, POR 6 HORAS', precio:'587.00'},
									  {id:'4', tipo_servicio:'POR ELEMENTO CON ARMA, POR 6 HORAS', precio:'767.00'},
									  {id:'4', tipo_servicio:'POR ELEMENTO DE ESCOLTA CON ARMA, POR 6 HORAS', precio:'1,941.00'},
									  {id:'4', tipo_servicio:'CON VEHICULO DE MOTOR DENTRO DE LA CIUDAD CON DOS ELEMENTOS A BORDO, POR 6 HORAS', precio:'4,153.00'},
									  {id:'4', tipo_servicio:'CON VEHICULO DE MOTOR DENTRO DE LA CIUDAD PERO DENTRO DEL TERRITORIO DEL ESTADO, CON DOS ELEMENTOS A BORDO Y ARMADOS, POR 12 HRS', precio:'16,249.00'},
									  {id:'4', tipo_servicio:'CON MOTOCICLETA DOS ELEMENTOS A BORDO, POR 6HRS', precio:'2,166'},
									  {id:'4', tipo_servicio:'MONITOREO A TRAVES DE CIRCUITO CERRADO, POR 1 CAMARA POR 1 MES', precio:'2,257.00'}
								  ]
								},
				offset: 3,
				currentSort:'id',
    			currentSortDir:'asc',
    			pagination:{
					 'total' : 0,
              	     'current_page':0,
            	 	 'per_page' :0,
            		 'last_page' :0,
            		 'from' :0,
            		 'to' :0
				}

			},

			computed: {
				//para determinar en que pagina estamos
				isActived: function(){
					return this.pagination.current_page; //retorna la pagina actual
				},
				//calcular los elementos que aparecen en pantalla
				pagesNumber: function(){
					if(!this.pagination.to){
						return [];
					}
					//pagina actual(desde)
					var from = this.pagination.current_page - this.offset;

					if(from < 1){
						from = 1;
					}
					//ultima pagina (hasta)
					var to = from + (this.offset * 2);

					if(to >= this.pagination.last_page){
						to = this.pagination.last_page;
					}
					//calcular la numeracion exacta
					var pagesArray = [];
					while(from <= to){ //lo realizara hasta que sean iguales
						pagesArray.push(from);
						from ++;
					}

					return pagesArray;
				},

				reordenamiento:function() {
					//modificar el nombre del arreglp
			      return this.clientes.sort((a,b) => {
			        let modifier = 1;
			        if(this.currentSortDir === 'desc') modifier = -1;
			        if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
			        if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
			        return 0;
			      });
			    }



			},
			//metodos
			methods: {

				search: function(page){
					var url= 'comercializacion/cliente/search';

						axios.post(url,{
                            cliente:this.searchCliente,
                            page:page
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.clientes=response.data.resultados.data;
							this.pagination=response.data.pagination;
                        }).catch(error=>{
                        });
				},
				verdelegacion:function(){
						alert("alert");
				},
				create:function()
				{
					this.delegaciones=[];
					this.subdelegaciones=[];
					this.nuevoCliente={num_cliente:'',razon_social:'',nombre_comercial:'',fecha:'',domicilio_fiscal:''};
					var url= 'comercializacion/delegaciones/show';
					axios.post(url).then(response=>{
							this.delegaciones=response.data
							}).catch(error=>{});
					var url= 'comercializacion/giros/show';
					axios.post(url).then(response=>{
							this.giros=response.data
							}).catch(error=>{});

					 $('#crearCliente').modal('show');
				},
				showSub:function(){
					var urlsub= 'comercializacion/subdelegaciones/show';
					axios.post(urlsub,{
						id:this.nuevoCliente.id_delegacion
					}).then(response=>{
							this.subdelegaciones=response.data
							}).catch(error=>{});
				},
				showSub2:function(){
					var urlsub= 'comercializacion/subdelegaciones/show';
					axios.post(urlsub,{
						id:this.nuevoServicio.id_delegacion
					}).then(response=>{
							this.subdelegaciones=response.data
							}).catch(error=>{});
				},
				store:function(){
					var url= 'comercializacion/cliente/store';
					axios.post(url,{
						cliente:this.nuevoCliente
						 }).then(response=>{
						// this.showAlerts(response.data);
						$('#crearCliente').modal('toggle');

						//console.log(response.data);
						this.searchCliente={id:response.data.id,razon_social:'',nombre_comercial:'',fecha:''};
						//SE REFRESCA LA PAG CON EL NUEVO CLIENTE
						var url= 'comercializacion/cliente/search';

						axios.post(url,{
                            cliente:this.searchCliente,
                            page:this.pagination.current_page
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.clientes=response.data.resultados.data;
							this.pagination=response.data.pagination;
                        }).catch(error=>{
                        });


						 }).catch(error=>{});

						this.nuevoCliente={num_cliente:'',razon_social:'',nombre_comercial:'',fecha:'',rfc:'',domicilio_fiscal:''};
				},
				showCliente: function(id) {
					var url= 'comercializacion/cliente/show';
						axios.post(url,{
                            id:id
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.mostrarCliente=response.data.resultados;
							$('#verCliente').modal('show');
                        }).catch(error=>{
                        });
				},
				//editar Cliente
				editaCliente: function(id){
					var url= 'comercializacion/delegaciones/show';
					axios.post(url).then(response=>{
							this.delegaciones=response.data
							}).catch(error=>{});
					var url= 'comercializacion/giros/show';
					axios.post(url).then(response=>{
							this.giros=response.data
							}).catch(error=>{});

					var urlcliente= 'comercializacion/cliente/show';
						axios.post(urlcliente,{
                            id:id
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.editarCliente=response.data.resultados;
							$('#editarCliente').modal('show');
                        }).catch(error=>{
                        });
					//	$('#editarCliente').modal('show');
				},
				//actualizar Cliente
				updateCliente:function(){
					var url= 'comercializacion/cliente/actualizar';
					axios.post(url,{
													cliente:this.editarCliente
											}).then(response=>{
												this.showAlerts(response.data);
												$('#editarCliente').modal('hide');
												this.editarCliente={};
												this.search();
											}).catch(error=>{
											});
				},
				addServicio:function(id){
					var url= 'comercializacion/delegaciones/show';
					axios.post(url).then(response=>{
							this.delegaciones=response.data
							}).catch(error=>{});
					var url= 'comercializacion/giros/show';
					axios.post(url).then(response=>{
							this.giros=response.data
							}).catch(error=>{});

					this.nuevoServicio={id_cliente:'',nombre_comercial:'',domicilio:'',municipio:'',giro:'',riesgo:'',id_delegacion:'',fecha_contratacion:'',observacion:'',contactos:[],elementos:[]};
					this.nuevoServicio.id_cliente=id;
					$('#agregarServicio').modal('show');
				},
				storeServicio:function(){
					//	this.nuevoServicio={id_cliente:'',nombre_comercial:'',domicilio:'',municipio:'',giro:'',riesgo:'',id_delegacion:'',fecha_contratacion:'',observacion:'',contactos:[],elementos:[]};
					if( this.nuevoServicio.municipio=="")
										{
											toastr.error("Todos los campos son necesarios");//mensaje flotante
										}else{

					var url= 'comercializacion/servicio/store';
						axios.post(url,{
                            servicio:this.nuevoServicio
                        }).then(response=>{
                        	this.showAlerts(response.data);
				//$this.nuevoServicio={id_cliente:'',nombre_comercial:'',domicilio:'',municipio:'',giro:'',riesgo:'',id_delegacion:'',fecha_contratacion:'',observacion:'',contactos:[],elementos:[]};
							$('#agregarServicio').modal('toggle');
                        }).catch(error=>{
                        });
											}//fin del else
				this.nuevoServicio={id_cliente:'',nombre_comercial:'',domicilio:'',municipio:'',giro:'',riesgo:'',id_delegacion:'',fecha_contratacion:'',observacion:'',contactos:[],elementos:[]};

				},
				//mostrar servicio
				showServicio:function (id) {
					$('#historialServicios').modal('hide');
					var url= 'comercializacion/servicio/show';
						axios.post(url,{
                            id:id
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.mostrarServicio=response.data.resultados;
							$('#verServicio').modal('show');
                        }).catch(error=>{
                        });
				},
				//ver modal de contacto y MOdalidad
				addContacto:function(){
					$('#agregarContacto').modal('show');
				},
				addElemento:function(){
					$('#agregarElementos').modal('show');
				},
				editarContacto:function(id){
					this.editContacto={};
					var url= 'comercializacion/contacto/search';
					this.id_contacto=id;
					axios.post(url,{
													contacto:this.id_contacto
											}).then(response=>{
												this.editContacto=response.data
												$('#editarContacto').modal('show');
											}).catch(error=>{
											});
				},
				editarModalidad:function(id){
					this.editModalidad={};
					var url= 'comercializacion/modalidad/search';
					this.id_modalidad=id;
					axios.post(url,{
													modalidad:this.id_modalidad
											}).then(response=>{
												this.editModalidad=response.data
												$('#editarModalidad').modal('show');
											}).catch(error=>{
											});
				},
				updateContacto:function(id){
						var url= 'comercializacion/servicio/actualizarconta';
						axios.post(url,{
														contacto:this.editContacto
												}).then(response=>{
													this.showAlerts(response.data);
													$('#editarContacto').modal('hide');
													this.editContacto={};
													var url= 'comercializacion/contacto/search';
													this.id_contacto=id;
													axios.post(url,{
																					contacto:this.id_contacto
																			}).then(response=>{
																				this.editContacto=response.data
																				$('#verServicio').modal('hide');
																			}).catch(error=>{
																			});

												}).catch(error=>{
												});
				},
				updateModalidad:function(id){
					var url= 'comercializacion/servicio/actualizarmodalidad';
					axios.post(url,{
													modalidad:this.editModalidad
											}).then(response=>{
												this.showAlerts(response.data);
												$('#editarModalidad').modal('hide');
												this.editModalidad={};
												var url= 'comercializacion/modalidad/search';
												this.id_modalidad=id;
												axios.post(url,{
																				modalidad:this.id_modalidad
																		}).then(response=>{
																			this.editModalidad=response.data
																			$('#verServicio').modal('hide');
																		}).catch(error=>{
																		});
											}).catch(error=>{
											});
				},
				//metodos para cargar los contactos y modalidades
				storeContacto:function(){
					if(this.nuevoContacto.nombre=="" )
                    {
                    	toastr.error("Todos los campos son necesarios");//mensaje flotante
                    }
                    else {
                      var taman=this.nuevoServicio.contactos.length;
                      this.nuevoContacto.id=taman+1;
                      this.nuevoServicio.contactos.push(this.nuevoContacto);
                      this.nuevoContacto={id:'',nombre:'',tipo:'',telefono:'',correo:'',celular:''};
                    $('#agregarContacto').modal('toggle');
                        }
				},
				removeContacto:function(id){
					for (var i = 0; i < this.nuevoServicio.contactos.length; i++) {
                        if(this.nuevoServicio.contactos[i].id=id)
                        {
                          this.nuevoServicio.contactos.splice(i,1);

                        }

                      }
				},
				storeElemento:function(){
					if(this.nuevoElemento.tipo=="" || this.nuevoElemento.cantidad=="" )
                    {
                    	toastr.error("Todos los campos son necesarios");//mensaje flotante
                    }
                    else {
                      var taman=this.nuevoServicio.elementos.length;
                      this.nuevoElemento.id=taman+1;
                      this.nuevoServicio.elementos.push(this.nuevoElemento);
                      this.nuevoElemento={id:'',tipo:'',cantidad:'',tipo_turno:'',horario:''};
                    $('#agregarElementos').modal('toggle');
                        }
				},
				removeElemento:function(id){
					for (var i = 0; i < this.nuevoServicio.elementos.length; i++) {
                        if(this.nuevoServicio.elementos[i].id=id)
                        {
                          this.nuevoServicio.elementos.splice(i,1);

                        }

                      }
				},
				showClienteHistorial: function(id) {
					var url= 'comercializacion/cliente/servicios/show';
						axios.post(url,{
                            id:id
                        }).then(response=>{
                        	this.showAlerts(response.data.informacion);
							this.mostrarClienteHistorial=response.data.resultados;
							$('#historialServicios').modal('show');
                        }).catch(error=>{
                        });
				},

				//funciones base
				verificarCampos: function(array){
					//recorrer el array para saber si un campo es vacio
				},
				showAlerts: function(respuesta){
					if(respuesta.error==false){

							toastr.success(respuesta.resultado);//mensaje flotante
						}
						else{

							toastr.error(respuesta.resultado);//mensaje flotante
						}
				},
				refreshPage: function(){
					//pagina actual sera igual a la pagina que se quiere cambiar
					//this.pagination.current_page = page;
					this.search(this.pagination.current_page);
					//checar
					//this.getKeeps(page);//genere un nuevo listado
				},
				changePage: function(page){
					//pagina actual sera igual a la pagina que se quiere cambiar
					this.pagination.current_page = page;
					//se vuelve a llamar al metodo search con la variable page
					//para que pueda hacer la paginacion
					this.search(page);
				},

				limpiar: function(formulario){
					//limpiar los campos del formulario
					//document.getElementById(formulario).reset();
					this.searchCliente={id:'',num_cliente:'',razon_social:'',nombre_comercial:'',fecha:''};


				},

				sort:function(s,idTh) {
			      //if s == current sort, reverse
			      if(s === this.currentSort) {
			        this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';

			      }
			      this.currentSort = s;

			      this.setIcon(document.getElementById(idTh));
			    },

			    setIcon: function (element) {

			    	if(element.className=="flechas")
			    	{
			    		element.className = "sorting asc";
			    	}
			    	else
			    	{
			    		if (element.className == "sorting desc"){
				    	element.className = "sorting asc";
				    }
				    else{
				    	element.className = "sorting desc";
				    }
			    	}


				  },



		}
	});


		</script>
@endsection

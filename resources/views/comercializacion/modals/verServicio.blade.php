
<div class="modal fade" id="verServicio" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Servicio</h4></center>
			</div>
			<div class="modal-body">



				<table id="t1" class="table table-condensed">
						<tr>
						<td>Numero de cliente</td>
						<td>
							<label v-text="mostrarServicio.id"></label>
						</td>
						</tr>
						<tr>
						<td>Numero de contrato</td>
						<td>
							<label v-text="mostrarServicio.numero_contrato"></label>
						</td>
						</tr>
						<tr>
						<td>Analisis de riesgo</td>
						<td>
							<label v-text="mostrarServicio.analisis"></label>
						</td>
						</tr>
						<tr>
						<td>Nombre comercial</td>
						<td>
							<label v-text="mostrarServicio.nombre_comercial"></label>
						</td>
						</tr>
						<tr>
						<td>Domicilio</td>
						<td>
							<label v-text="mostrarServicio.domicilio"></label>
						</td>
						</tr>
						<tr>
						<td>Municipio</td>
						<td>
							<label v-text="mostrarServicio.municipio"></label>
						</td>
						</tr>
						<tr>
						<td>Giro</td>
						<td>
							<label v-text="mostrarServicio.giro"></label>
						</td>
						</tr>
						<tr>
						<td>Tipo</td>
						<td>
							<label v-text="mostrarServicio.tipo"></label>
						</td>
						</tr>
						<tr>
						<td>Estatus</td>
						<td>
							<span class="label label-danger" v-show="mostrarServicio.estatus==false" >INACTIVO</span>

				    		<span class="label label-success" v-show="mostrarServicio.estatus==true" >ACTIVO</span>
						</td>
						</tr>
						<tr>
						<td>Observacion</td>
						<td>
							<label v-text="mostrarServicio.observaciones"></label>
						</td>
						</tr>

						<tr>
						<td colspan="2">Contactos</td>
						</tr>
						<tr>
						<td colspan="2">
							<table id="t1" class="table table-condensed">
								<tr>
									<td>Opciones</td>
									<td>Nombre</td>
									<td>Tipo</td>
									<td>Dato</td>
								</tr>
								<tr v-for="cont in mostrarServicio.contactos">
									<td>
										<button   v-on:click.prevent="editarContacto(cont.id)"  type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Editar contacto">
										    <span class="glyphicon glyphicon-pencil"></span></span>
										</button>
									</td>
									<td v-text="cont.nombre"></td>
									<td v-text="cont.tipo"></td>
									<td v-text="cont.dato"></td>
								</tr>
							</table>
						</td>
						</tr>

						<tr>
						<td colspan="2">Modalidad</td>
						</tr>
						<tr>
						<td colspan="2">
							<table id="t1" class="table table-condensed">
								<tr>
									<td>Opciones</td>
									<td>Elemento</td>
									<td>Tipo</td>
									<td>Tipo Horario</td>
									<td>Horario</td>
								</tr>
								<tr v-for="elem in mostrarServicio.elementos">
									<td>
										<button   v-on:click.prevent="editarModalidad(elem.id)"  type="button" class="btn btn-defautl btn-xs"><span class="hint--top" data-hint="Editar contacto">
										    <span class="glyphicon glyphicon-pencil"></span></span>
										</button>
									</td>
									<td>
										<span class="label label-danger" v-if="elem.id_elemento==null" >SIN ASIGNAR</span>


									</td>
									<td v-text="elem.tipo"></td>
									<td v-text="elem.tipo_turno"></td>
									<td v-text="elem.horario"></td>
								</tr>
							</table>
						</td>
						</tr>


				</table>


			</div>



			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cerrar
				</button>


			</div>
		</div>
	</div>
</div>

<form method="POST" v-on:submit.prevent="storeServicio">
<div class="modal fade" id="agregarServicio" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Agregar servicio</h4></center>
			</div>
			<div class="modal-body">
				<center><label>Datos del Cliente</label></center><hr>

				<label>Nombre Comercial</label><br>
				<td><input type="text" class="form-control" v-model="nuevoServicio.nombre_comercial" required style="text-transform: uppercase;"></td><br>

				<label>Domicilio del Servicio</label><br>
				<td><input type="text" class="form-control" v-model="nuevoServicio.domicilio" required style="text-transform: uppercase;"></td><br>

				<label>Municipio del Servicio</label><br>
				<td><input type="text" class="form-control" v-model="nuevoServicio.municipio" required style="text-transform: uppercase;"></td><br>

				<label for="">Delegacion Sub. Delegacion Asignado</label>
				<select class="form-control" v-model="nuevoServicio.id_delegacion">
                        <option v-for="de in delegaciones" v-bind:value="de.id" class="lista">
                          @{{ de.nombre}}
                        </option>
        </select>

				<label>Giro</label><br>
				<select class="form-control" v-model="nuevoServicio.giro">
                        <option v-for="giro in giros" v-bind:value="giro.nombre" class="lista">
                          @{{ giro.nombre}}
                        </option>
        </select>

				<!--<label>Nivel Riesgo</label><br>
				<select class="form-control" v-model="nuevoCliente.riesgo">
                        <option v-for="nivel in nivelRiesgo" v-bind:value="nivel.nombre" class="lista">
                          @{{ nivel.nombre}}
                        </option>
				</select>
				-->


				<label>Fecha Inicial Servicio</label><br>
				<td><input type="date" class="form-control" placeholder="" v-model="nuevoServicio.fecha_contratacion" required style="text-transform: uppercase;"></td><br>

				<label>Observación</label><br>
				<td><textarea  class="form-control" autofocus aria-describedby="basic-addon1" style="overflow:auto;resize:none" rows="4" cols="500"  v-model="nuevoServicio.observacion"  style="text-transform: uppercase;"></textarea></td><br>


				<center>
					<button  v-on:click.prevent="addContacto()"   type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Agregar contacto">
			    <span class="glyphicon glyphicon-plus"></span></span>
			    </button>
					<label>Contacto Comercial</label>
				</center><hr><br>



				<table id="t1" class="table table-condensed">
					<tr>
						<td>Opciones</td>
						<td>Nombre</td>
						<td>Tipo</td>
						<td>Dato</td>
					</tr>
					<tr v-for="cont in nuevoServicio.contactos">
						<td>
							<button   v-on:click.prevent="removeContacto(cont.id)"  type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Eliminar contacto">
							    <span class="glyphicon glyphicon-trash"></span></span>
							</button>
						</td>
						<td v-text="cont.nombre"></td>
						<td v-text="cont.tipo"></td>
						<td v-text="cont.dato"></td>
					</tr>
				</table>

				<center>
					<button   v-on:click.prevent="addElemento()"  type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Agregar Elementos">
					    <span class="glyphicon glyphicon-plus"></span></span>
					</button>

					<label>Modalidad del Servicio</label></center><hr><br>

				<table id="t1" class="table table-condensed">
					<tr>
						<td>Tipo</td>
						<td>Cantidad</td>

					</tr>
					<tr v-for="elm in nuevoServicio.elementos">
						<td>
							<button   v-on:click.prevent="removeElemento(elm.id)"  type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Eliminar elementos">
							    <span class="glyphicon glyphicon-trash"></span></span>
							</button>
						</td>

						<td v-text="elm.tipo"></td>
						<td v-text="elm.cantidad"></td>
					</tr>
				</table>

			</div>



			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" value="Aceptar">
             <span class="glyphicon glyphicon-ok-circle"></span>
             Guardar
                </button>

				<button class="btn btn-defautl" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cancelar
				</button>

			</div>
		</div>
	</div>
</div>
</form>

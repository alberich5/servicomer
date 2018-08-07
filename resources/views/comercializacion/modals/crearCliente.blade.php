<form method="POST" v-on:submit.prevent="store">
<div class="modal fade" id="crearCliente" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Nuevo Cliente</h4></center>
			</div>
			<div class="modal-body">
				<!---razon social-->
				<label for="registro">Razon Social</label>
				<input type="text" class="form-control" v-model="nuevoCliente.razon_social" required style="text-transform: uppercase;">
				<!---nombre comercial-->
				<label for="registro">Nombre Comercial</label>
				<input type="text" class="form-control" v-model="nuevoCliente.nombre_comercial" required style="text-transform: uppercase;">
				

				<!---fecha alta-->
				<label for="registro">Fecha Inicial de Contratacion</label>
				<input type="date" class="form-control" v-model="nuevoCliente.fecha">
				<br>
				<!---Delegaciones-->
				<label for="">Delegacion del Contrato</label>
				<select class="form-control" v-model="nuevoCliente.id_delegacion">
					 	<option disabled selected>SELECCIONA UNA DELEGACION</option>
                        <option v-for="de in delegaciones" v-bind:value="de.id" class="lista">
                          @{{ de.nombre}}
                        </option>
        </select>
				<!---giro-->
				<label for="">Giro</label>
				<select class="form-control" v-model="nuevoCliente.giro">
                        <option v-for="giro in giros" v-bind:value="giro.id" class="lista">
                          @{{ giro.nombre}}
                        </option>
        </select>

				<br>


			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" value="Aceptar">
             		<span class="glyphicon glyphicon-ok-sign"></span>
             			Aceptar
        		</button>

				<button class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cancelar
				</button>

			</div>
		</div>
	</div>
</div>
</form>

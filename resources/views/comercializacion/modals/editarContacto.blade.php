
<div class="modal fade" id="editarContacto" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Editar Contacto</h4></center>
			</div>
			<div class="modal-body">
				<!---razon social-->
				<label for="registro">Nombre</label>
				<input type="text" class="form-control" v-model="editContacto.nombre" style="text-transform: uppercase;" >
				<!---cargo-->
				<label for="registro">Cargo</label>
				<input type="text" class="form-control" v-model="editContacto.cargo" style="text-transform: uppercase;">
				<!---telefono-->
				<label for="registro">Telefono</label>
				<input type="text" class="form-control" v-model="editContacto.telefono" style="text-transform: uppercase;" >
				<!---Correo-->
				<label for="registro">Correo</label>
				<input type="text" class="form-control" v-model="editContacto.correo"  style="text-transform: uppercase;">
				<!---Celular-->
				<label for="registro">Celular</label>
				<input type="text" class="form-control" v-model="editContacto.celular" style="text-transform: uppercase;">



			</div>
			<div class="modal-footer">
				<button  class="btn btn-primary" value="Aceptar" v-on:click="updateContacto(editContacto.id)">
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

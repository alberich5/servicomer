<form method="POST" v-on:submit.prevent="store">
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
				<input type="text" class="form-control" v-model="mostrarServicio.nombre_comercial" >
				<!---domiciolio fiscal-->
				<label for="registro">Telefono</label>
				<textarea  class="form-control" ></textarea>
				<!---Correo-->
				<label for="registro">Correo</label>
				<input type="text" class="form-control" >
				<!---Celular-->
				<label for="registro">Celular</label>
				<input type="text" class="form-control" >



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

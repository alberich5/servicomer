<form method="POST" v-on:submit.prevent="store">
<div class="modal fade" id="crearCliente" data-backdrop="static">
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
				<label for="registro">Razon Social</label>
				<input type="text" class="form-control" v-model="nuevoCliente.razon_social">
				<!---domiciolio fiscal-->
				<label for="registro">Domicilio Fiscal</label>
				<textarea  class="form-control" autofocus aria-describedby="basic-addon1" style="overflow:auto;resize:none" rows="4" cols="500"  v-model="nuevoCliente.domicilio_fiscal"></textarea>
				<!---rfc-->
				<label for="registro">RFC</label>
				<input type=text class="form-control" id="rfc_input" oninput="validarInput(this)" v-model="nuevoCliente.rfc">
				<pre id="resultado"></pre>
				<!---cargo-->
				<label for="registro">Domicilio Notificacion</label>
				<input type="text" class="form-control" v-model="nuevoCliente.notificacion">


				<br>
				<button v-on:click.prevent="addArchivos()">Subir Documentacion</button>
				<br>
				<label>Llista de Archivos</label>

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


<div class="modal fade" id="editarCliente" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Editar Cliente</h4></center>
			</div>
			<div class="modal-body">

				<label>Razon social</label><br>
				<input type="text" class="form-control" v-model="editarCliente.razon_social" style="text-transform: uppercase;"><br>

				<label>Domicilio fiscal</label><br>
				<input type="text" class="form-control" v-model="editarCliente.domicilio_fiscal" style="text-transform: uppercase;"><br>

				<label>Nombre comercial</label><br>
				<input type="text" class="form-control" v-model="editarCliente.nombre_comercial" style="text-transform: uppercase;"><br>

				<label>Giro</label><br>
				<input type="text" class="form-control" v-model="editarCliente.giro" style="text-transform: uppercase;"><br>

				<label>Tipo Contrato</label><br>
				<input type="text" class="form-control" v-model="editarCliente.tipo_contrato" style="text-transform: uppercase;"><br>

				<label>Domicilio Notificacion</label><br>
				<input type="text" class="form-control" v-model="editarCliente.domicilio_notificacion" style="text-transform: uppercase;"><br>

			</div>



			<div class="modal-footer">
				<button type="" class="btn btn-primary" value="Guardar" v-on:click="updateCliente()" >
             <span class="glyphicon glyphicon-ok-circle"></span>
             Aceptar
                </button>


			</div>
		</div>
	</div>
</div>

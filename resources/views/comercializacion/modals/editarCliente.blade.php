
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
				<input type="text" class="form-control" v-modal="clientes.razon_social"><br>

				<label>Domicilio fiscal</label><br>
				<input type="text" class="form-control" v-modal=""><br>

				<label>Nombre comercial</label><br>
				<input type="text" class="form-control" v-modal=""><br>

				<label>Estatus</label><br>
				<select class="form-control" v-modal="">
					<option>Activo</option>
					<option>Inactivo</option>
				</select><br>

				

				
			</div>



			<div class="modal-footer">
				<button type="" class="btn btn-primary" value="Guardar" v-on:click="" >
             <span class="glyphicon glyphicon-ok-circle"></span>
             Aceptar
                </button> 

				
			</div>
		</div>
	</div>
</div>

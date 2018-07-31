
<div class="modal fade" id="verCliente" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Cliente</h4></center>
			</div>
			<div class="modal-body">
				<label>ID:</label>
				<label v-text="mostrarCliente.id"></label>
				<br>

				<label>Razon social:</label>
				<label v-text="mostrarCliente.razon_social"></label>
				<br>

				<label>Domicilio fiscal:</label>
				<label v-text="mostrarCliente.domicilio_fiscal"></label>
				<br>

				<label>Nombre comercial:</label>
				
				<label v-text="mostrarCliente.nombre_comercial"></label>
				<br>
				<label>Estatus:</label>
				<span class="label label-danger" v-show="mostrarCliente.estatus==false" >INACTIVO</span>

				    	<span class="label label-success" v-show="mostrarCliente.estatus==true" >ACTIVO</span>

				


				
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

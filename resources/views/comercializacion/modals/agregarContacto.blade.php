
<div class="modal fade" id="agregarContacto" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Contacto</h4></center>
			</div>
			<div class="modal-body">

				<label>Nombre</label><br>
				<input type="text" class="form-control" name="" v-model="nuevoContacto.nombre" required style="text-transform: uppercase;"><br>
				<label for="registro">Cargo</label>
				<input type="text" class="form-control" v-model="nuevoContacto.cargo" required style="text-transform: uppercase;">

				<!--<label>Tipo</label><br>
				<select v-model="nuevoContacto.tipo" class="form-control" id="sel1">
				        <option>Telefono</option>
				        <option>Correo</option>
				        <option>Celular</option>
				      	</select><br>-->

				<label>Telefono</label><br>
				<input type="text" class="form-control" name="" v-model="nuevoContacto.telefono"  style="text-transform: uppercase;">
				<label>Correo</label><br>
				<input type="text" class="form-control" name="" v-model="nuevoContacto.correo" style="text-transform: uppercase;">
				<label>celular</label><br>
				<input type="text" class="form-control" name="" v-model="nuevoContacto.celular"  style="text-transform: uppercase;">


			</div>



			<div class="modal-footer">
				<button type="" class="btn btn-primary" value="Guardar" v-on:click="storeContacto()" >
             <span class="glyphicon glyphicon-ok-circle"></span>
             Aceptar
                </button>

				<button class="btn btn-defautl" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cancelar
				</button>

			</div>
		</div>
	</div>
</div>

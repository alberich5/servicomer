
<div class="modal fade" id="editarModalidad" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Editar Modalidad</h4></center>
			</div>
			<div class="modal-body">
				<!---razon social-->
				<label for="registro">Tipo</label>
				<input type="text" class="form-control" v-model="editModalidad.tipo" style="text-transform: uppercase;">
				<!---Tipo Horario-->
				<label for="registro">Tipo Horario</label>
        			<input type="text" class="form-control" v-model="editModalidad.tipo_turno" style="text-transform: uppercase;">
				<!---Horario-->
				<label for="registro">Horario</label>
				<input type="text" class="form-control" v-model="editModalidad.horario">




			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" value="Aceptar" v-on:click="updateModalidad(editModalidad.id)">
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

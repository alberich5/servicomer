
<div class="modal fade" id="agregarElementos" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Modalidades</h4></center>
			</div>
			<div class="modal-body">

				<label>Tipo</label><br>
				<select class="form-control" id="elemento" v-model="nuevoElemento.tipo">
				        	<option>ESCOLTA</option>
				        				        
				      	</select><br>

				<label>Cantidad</label><br>
				<input type="number" class="form-control" v-model="nuevoElemento.cantidad"><br>

				<label>Tipo turno</label><br>
				<select class="form-control" v-model="nuevoElemento.tipo_turno">
				      <option>24x24</option>
				      <option>12x12</option>		        
				</select><br>

				<label for="registro">Horario</label>
				<input type="text" class="form-control" v-model="nuevoElemento.horario"><br>

				
			</div>



			<div class="modal-footer">
				<button type="" class="btn btn-primary" value="Guardar" v-on:click="storeElemento()" >
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

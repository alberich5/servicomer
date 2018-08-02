
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


								<!--<select class="form-control" v-model="nuevoElemento.tipo">
				                        <option v-for="mo in modalidad" v-bind:value="mo.nombre" class="lista">
				                          @{{ mo.nombre}}  $@{{ mo.precio}}
				                        </option>
				        </select>-->
								<div >
													<label> TIPO SERVICIOS</label>
													<br>

												  <select v-model="firstOptions" class="form-control">
												    <option v-for="(item, index) in list">@{{ index }}</option>
												  </select>


												</div>
												<br>
												<div>
													<select v-model="nuevoElemento.tipo" v-if="firstOptions" class="form-control">
												    <option v-for="option in list[firstOptions]" v-bind:value="option.tipo_servicio">@{{option.tipo_servicio}}, Costo: $@{{option.precio}}</option>
												  </select>
												</div>

				<label>Cantidad Elementos</label><br>
				<input type="number" class="form-control" v-model="nuevoElemento.cantidad"><br>

				<label>Tipo turno</label><br>
				<select class="form-control" v-model="nuevoElemento.tipo_turno">
				      <option>24x24</option>
				      <option>12x12</option>
				</select><br>

				<label for="registro">Horario Inicial</label>
				<input type="time" class="form-control" v-model="nuevoElemento.horario1" ><br>
				<label for="registro">Horario Final</label>
				<input type="time" class="form-control" v-model="nuevoElemento.horario2" ><br>


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

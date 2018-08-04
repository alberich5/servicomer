<div class="modal fade" id="agregaContrato" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>DATOS DEL CONTRATO</h4></center>
			</div>
			<div class="modal-body">

				<div class="row" >

					<table class="table" id="tablita">

					    <tbody>
					      <tr>
					        <td >Numero de contrato</td>
					        <td>
					        	<input type="text" class="form-control" placeholder="Numero de contrato" v-model="contrato.numeroContrato">
					        </td>
					      </tr>
					      <tr>
					        <td>Tipo de contrato</td>
					        <td>
										<select v-model="contrato.tipoContrato" class="form-control">
					        		<option value="privado">Privado</option>
					        		<option value="publico">Publico</option>
					        		<option value="federal">Federal</option>
					        	</select>
					        </td>
					    	</tr>
					      <tr>
					        <td>Fecha de inicio Contrato</td>
					        <td>
					        	<input type="date" class="form-control" placeholder="Fecha de contratacion" >
					        </td>
					      </tr>
					      <tr>
					      	<td>Observaciones</td>
					        <td>

					        	<textarea class="form-control" rows="3" placeholder="Observaciones" ></textarea>
					        </td>
					      </tr>
					      <tr>
					      	<td>Archivo</td>
					        <td>
					        	<form method="post" action="/juridico/contrato/subir"  enctype="multipart/form-data">

								{{ csrf_field() }}
					        	<div class="col-sm-9">
					        	<input type="hidden" id="tipo" name="tipo"  v-model="contrato.tipoContrato">

					        	<input type="hidden" id="num_contrato" name="num_contrato"  v-model="contrato.numeroContrato" >

					        	<input type="file" class="form-control" name="file" accept="application/pdf" >
					        	</div>
					        	<div class="col-sm-3">
					        	<button class="btn btn-primary btn-sm">Subir</button>
					        	</div>
								</form>
					        </td>
					      </tr>

					    </tbody>
					</table>
		</div>

			</div>

			<div class="modal-footer">
				

				<button class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cancelar
				</button>
			</div>
		</div>
	</div>
</div>

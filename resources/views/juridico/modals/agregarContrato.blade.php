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
					        	<input type="text" class="form-control" placeholder="Numero de contrato" >
					        </td>
					      </tr>
					      <tr>
					        <td>Tipo de contrato</td>
					        <td>
					        	<input type="text" class="form-control" placeholder="Tipo de contrato" >
					        </td>
					    	</tr>
					      <tr>
					        <td>Fecha de contratacion</td>
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
					        	<input type="hidden" id="tipo" name="tipo" value="contrato">

					        	<input type="hidden" id="id_servicio" name="id_servicio" >

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
				<button class="btn btn-primary" data-dismiss="modal">
					<span class="glyphicon glyphicon-ok-circle"></span>
					Guardar
				</button>

				<button class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign"></span>
					Cancelar
				</button>
			</div>
		</div>
	</div>
</div>

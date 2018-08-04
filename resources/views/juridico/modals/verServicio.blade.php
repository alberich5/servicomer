
<div class="modal fade" id="verServicio" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Ver Servicio Juridico</h4></center>
			</div>
			<div class="modal-body">



				<table id="t1" class="table table-condensed">
						<tr>
						<td>Numero de cliente</td>
						<td>
							<label v-text="mostrarServicio.id"></label>
						</td>
						</tr>
						<tr>
						<td>Numero de contrato</td>
						<td>
							<label v-text="mostrarServicio.numero_contrato"></label>
						</td>
						</tr>
						<tr>
						<td>Razon Social</td>
						<td>
							<label v-text="mostrarServicio.razon_social"></label>
						</td>
						</tr>
						<tr>
						<td>Analisis de riesgo</td>
						<td>
							<label v-text="mostrarServicio.analisis"></label>
						</td>
						</tr>
						<tr>
						<td>Sucursal u Oficina</td>
						<td>
							<label v-text="mostrarServicio.nombre_comercial"></label>
						</td>
						</tr>
						<tr>
						<td>Domicilio</td>
						<td>
							<label v-text="mostrarServicio.domicilio"></label>
						</td>
						</tr>
						<tr>
						<td>Municipio</td>
						<td>
							<label v-text="mostrarServicio.municipio"></label>
						</td>
						</tr>
						<tr>
						<td>Giro</td>
						<td>
							<label v-text="mostrarServicio.giro"></label>
						</td>
						</tr>
						<tr>
						<td>Tipo</td>
						<td>
							<label v-text="mostrarServicio.tipo"></label>
						</td>
						</tr>
						<tr>
						<td>Estatus</td>
						<td>
							<span class="label label-danger" v-show="mostrarServicio.estatus==false" >INACTIVO</span>

				    		<span class="label label-success" v-show="mostrarServicio.estatus==true" >ACTIVO</span>
						</td>
						</tr>
						<tr>
						<td>Observacion</td>
						<td>
							<label v-text="mostrarServicio.observaciones"></label>
						</td>
						</tr>

						<tr>
						<td colspan="2">Agregar Contrato</td>
						<td colspan="2">
							<button   v-on:click.prevent="addContrato()"  type="button" class="btn btn-info btn-xs"><span class="hint--top" data-hint="Agregar Contrato">
									<span class="glyphicon glyphicon-plus"></span></span>
							</button>
							</td
						</tr>
						<tr>
						<td colspan="2">

						</td>
						</tr>

						<tr>
						<td colspan="2"></td>
						</tr>
						<tr>
						<td colspan="2">

						</td>
						</tr>


				</table>


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

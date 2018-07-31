
<div class="modal fade" id="historialServicios" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Historial de Servicios</h4></center>
			</div>
			<div class="modal-body">

				<table id="t1" class="table table-condensed" >
					
					<tr>
						<td>Opciones</td>
						<td>ID</td>
						<td>Numero de contrato</td>
						<td>Analisis de riesgo</td>
						<td>Nombre comercial</td>
						<td>Giro</td>
						<td>Estatus</td>

					</tr>
					
					<tr v-for="serv in mostrarClienteHistorial ">
						<td>
							<a v-on:click.prevent="showServicio(serv.id)" class="btn btn-default ">
				            <span class="hint--top" data-hint="Ver detalle Servicio">
				            <span class="glyphicon glyphicon-eye-open"></span>
				            </span>
				          	</a>
				      	</td>
						<td v-text="serv.id"></td>
						<td v-text="serv.numero_contrato"></td>
						<td v-text="serv.analisis_riesgo"></td>
						<td v-text="serv.nombre_comercial"></td>
						<td v-text="serv.giro"></td>
						<td>
							<span class="label label-danger" v-show="serv.estatus==false" >INACTIVO</span>

				    		<span class="label label-success" v-show="serv.estatus==true" >ACTIVO</span>
						</td>
					</tr>
					
				</table>

				
			</div>



			<div class="modal-footer">
				

				
			</div>
		</div>
	</div>
</div>

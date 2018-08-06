
<div class="modal fade" id="cambioContrasena" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<center><h4>Editar Contraseña</h4></center>
			</div>
			<div class="modal-body">
				<label>Contraseña</label>  
                <input type="password" id="password1">
                <input type="checkbox" onchange="document.getElementById('password1').type = this.checked ? 'text' : 'password'"> Ver Contraseña
                   
                <label>Confirmar contraseña</label>
                <input v-model='usuario.contrasena' required type="password" id="confirmPassword" >
                <span id="errorPass" class="label label-danger" ></span>  

			</div>
			<div class="modal-footer">

				<button  class="btn btn-primary" value="Aceptar" v-on:click="storeCambiarContrasena()">
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

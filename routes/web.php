<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('home');

    return view('welcome');
});

Auth::routes();




Route::middleware(['auth','sesiones'])->group(function () {

Route::get('/', 'HomeController@index')->name('home');
});

Route::middleware(['auth','sesiones'])->group(function () {

//administrador
Route::get('/admin/usuario', 'admin\UsuarioController@index')->name('administrador.usuario.index');

Route::post('/admin/usuario/search',['uses'=> 'admin\UsuarioController@search', 'as'=> 'administrador.usuario.search']);

Route::post('/admin/usuario/show',['uses'=> 'admin\UsuarioController@show', 'as'=> 'administrador.usuario.show']);

Route::post('/admin/usuario/cerrar-sesion',['uses'=> 'admin\UsuarioController@cerrarSesion', 'as'=> 'administrador.usuario.cerrarSesion']);

Route::post('/admin/usuario/bloquear',['uses'=> 'admin\UsuarioController@bloquear', 'as'=> 'administrador.usuario.bloquear']);

Route::post('/admin/usuario/cambiar-pass',['uses'=> 'admin\UsuarioController@cambiarPass', 'as'=> 'administrador.usuario.cambiarPass']);

Route::get('/admin/usuario/create', 'admin\UsuarioController@create')->name('administrador.usuario.create');

Route::post('/admin/usuario/searchCreate',['uses'=> 'admin\UsuarioController@searchCreate', 'as'=> 'administrador.usuario.searchCreate']);

Route::post('/admin/usuario/showCreate',['uses'=> 'admin\UsuarioController@showCreate', 'as'=> 'administrador.usuario.showCreate']);

Route::post('/admin/usuario/store',['uses'=> 'admin\UsuarioController@store', 'as'=> 'administrador.usuario.store']);

Route::get('/admin/usuario/permisos', 'admin\UsuarioController@getPermisos')->name('administrador.usuario.permisos');

Route::get('/admin/usuario/sucursales', 'admin\UsuarioController@getSucursales')->name('administrador.usuario.sucursales');

Route::get('/admin/usuario/contrasena', 'admin\UsuarioController@cambioContrasenaUsuario')->name('administrador.usuario.contrasena.cambio');

Route::post('/admin/usuario/contrasena/store',['uses'=> 'admin\UsuarioController@guardarCambioContrasenaUsuario', 'as'=> 'administrador.usuario.contrasena.cambio.store']);



//Roles

	Route::post('roles/store', 'admin\RoleController@store')->name('roles.store')
		->middleware('permission:roles.create');

	Route::get('roles', 'admin\RoleController@index')->name('roles.index')
		->middleware('permission:roles.index');

	Route::get('roles/create', 'admin\RoleController@create')->name('roles.create')
		->middleware('permission:roles.create');

	Route::put('roles/{role}', 'admin\RoleController@update')->name('roles.update')
		->middleware('permission:roles.edit');

	Route::get('roles/{role}', 'admin\RoleController@show')->name('roles.show')
		->middleware('permission:roles.show');

	Route::delete('roles/{role}', 'admin\RoleController@destroy')->name('roles.destroy')
		->middleware('permission:roles.destroy');

	Route::get('roles/{role}/edit', 'admin\RoleController@edit')->name('roles.edit')
		->middleware('permission:roles.edit');
	//Users
	Route::get('users', 'admin\UserController@index')->name('users.index')
		->middleware('permission:users.index');

	Route::put('users/{user}', 'admin\UserController@update')->name('users.update')
		->middleware('permission:users.edit');

	Route::get('users/{user}', 'admin\UserController@show')->name('users.show')
		->middleware('permission:users.show');

	Route::delete('users/{user}', 'admin\UserController@destroy')->name('users.destroy')
		->middleware('permission:users.destroy');

	Route::get('users/{user}/edit', 'admin\UserController@edit')->name('users.edit')
		->middleware('permission:users.edit');

	Route::post('/users/store',['uses'=> 'admin\UserController@store', 'as'=> 'users.store'])->middleware('permission:users.store');
Route::get('usuario/registrar', 'admin\UserController@create')->name('usuario.registrar')
		->middleware('permission:usuario.registrar');

Route::post('/recursos/elemento/show',['uses'=> 'recursosHumanos\ElementoPolicialController@show', 'as'=> 'recursos.elemento.show'])->middleware('permission:recursos.elemento.show');


//comercializacion

Route::get('comercializacion/', 'comercializacion\ClienteController@index')->name('comercializacion.cliente.index');

Route::post('comercializacion/cliente/search',['uses'=> 'comercializacion\ClienteController@search', 'as'=> 'comercializacion.cliente.search']);
Route::post('comercializacion/cliente/search2',['uses'=> 'comercializacion\ClienteController@search2', 'as'=> 'comercializacion.cliente.search2']);

Route::post('comercializacion/cliente/store',['uses'=> 'comercializacion\ClienteController@store', 'as'=> 'comercializacion.cliente.store']);
//Actualizar cliente
Route::post('comercializacion/cliente/actualizar',['uses'=> 'comercializacion\ClienteController@actualizar', 'as'=> 'comercializacion.cliente.actualizar']);


Route::post('comercializacion/cliente/show',['uses'=> 'comercializacion\ClienteController@show', 'as'=> 'comercializacion.cliente.show']);

Route::post('comercializacion/cliente/servicios/show',['uses'=> 'comercializacion\ClienteController@showHistorial', 'as'=> 'comercializacion.cliente.showHistorial']);

Route::post('comercializacion/servicio/show',['uses'=> 'comercializacion\ServicioController@show', 'as'=> 'comercializacion.servicio.show']);
Route::post('comercializacion/servicio/show2',['uses'=> 'comercializacion\ServicioController@show2', 'as'=> 'comercializacion.servicio.show2']);


Route::post('comercializacion/servicio/store',['uses'=> 'comercializacion\ServicioController@store', 'as'=> 'comercializacion.servicio.store']);

//actualizar contacto
Route::post('comercializacion/servicio/actualizarconta',['uses'=> 'comercializacion\ServicioController@actualizarconta', 'as'=> 'comercializacion.servicio.actualizarconta']);
//actualizar modalidad
Route::post('comercializacion/servicio/actualizarmodalidad',['uses'=> 'comercializacion\ServicioController@actualizarmodalidad', 'as'=> 'comercializacion.servicio.actualizarmodalidad']);
//buscar $contactos
Route::post('comercializacion/contacto/search',['uses'=> 'comercializacion\ServicioController@searchContacto', 'as'=> 'comercializacion.contacto.search']);
//buscar MOdalidad
Route::post('comercializacion/modalidad/search',['uses'=> 'comercializacion\ServicioController@searchModalidad', 'as'=> 'comercializacion.modalidad.search']);
//pruebas
Route::get('prueba',['uses'=> 'comercializacion\ServicioController@prueba', 'as'=> 'comercializacion.servicio.store']);

//Juridico
Route::get('juridico/', 'juridico\ContratoController@index')->name('juridico.contrato.index');
Route::post('juridico/juridico/search',['uses'=> 'juridico\ContratoController@search', 'as'=> 'juridico.juridico.search']);

Route::post('juridico/contrato/subir',['uses'=> 'juridico\ContratoController@subir', 'as'=> 'juridico.contrato.subir']);









		//->middleware('permission:usuario.registrar');

});//fin route auth

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Autenticación
Route::auth();
Route::group(['namespace' => 'Auth'], function(){

	Route::resource('usuarios', 'AuthController', [
		'parameters'=>['usuarios' => 'USER_id']
	]);
	Route::get('password/email/{USER_id}', 'PasswordController@sendEmail');
	Route::get('password/reset/{USER_id}', 'PasswordController@showResetForm');

	Route::resource('roles', 'RolController', [
		'except' => ['show'],
		'parameters' => ['roles' => 'ROLE_id']
	]);
	Route::group(['as' => 'roles.', 'prefix' => 'roles'], function () {
		Route::get('getUsuarios/{ROLE_id}', 'RolController@getUsuarios')
			->name('getUsuarios');
		Route::get('getRoles', 'RolController@getRoles')
			->name('getRoles');
	});

	Route::group(['as' => 'usuarios.', 'prefix' => 'usuarios'], function () {
		Route::post('importXLS', 'UploadController@createUsersFromFile')
				->name('createUsersFromFile');
		Route::get('plantilla/{ext}', 'UploadController@generarPlantillaUsers')
				->name('generarPlantilla');
	});
	Route::match(['get','post'], 'createUserFromAjax', 'UploadController@createFromAjax')
			->name('usuarios.createFromAjax');

});

Route::get('/buscaPrograma','SoapController@getProgramasWs');
Route::get('/buscaGrupo','SoapController@getGruposWs');
Route::get('/buscaSemestre','SoapController@getSemestresWs');
Route::get('/buscaMateria','SoapController@getMateriasWs');

//Inicio
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

//Calendario de reservas
Route::get('/calreservas', 'HomeController@calreservas');

//Calendario de reservas
Route::get('reservas/calreservas', 'ReservasController@listarReservas');

Route::get('listarReservas{sala?}','ReservasController@consultarReservas');
Route::post('listReservasFiltro', array('as' => 'listReservasFiltro','uses' => 'ReservasController@consultarReservasFiltro'));

//Ayuda
Route::get('/help', function(){
	return View::make('help');
});
//Prueba
Route::get('/prueba', function(){
	return View::make('emails.info_reserva_creada');
});

//upload tablas Academusoft
Route::get('upload', 'UploadFacultadController@index');
Route::delete('eliminarRegistros', 'UploadFacultadController@eliminarRegistros');
Route::post('upload', 'UploadFacultadController@upload');


//Sedes (EspacioFisico)
Route::resource('sedes', 'SedesController');

// Salas (recursofisico)
Route::resource('salas', 'SalasController');

// Equipos (equipos)
Route::resource('equipos', 'EquiposController');

//festivos
Route::resource('festivos', 'FestivosController');

//Parametros Generales
Route::resource('parametrosgenerales', 'ParametroGeneralController');

//tipos de estados
Route::resource('tipoestados', 'TipoestadosController');

//estados
Route::resource('estados', 'EstadosController');

//politicas
Route::resource('politicas', 'PoliticasController');

//Consulta de equipos
Route::resource('consultaEquipos', 'ConsultaEquiposController');

//Consulta y crear prestamo
Route::resource('consultaPrestamos', 'PrestamoEquiposController');
Route::post('prestamoEquipo', 'PrestamoEquiposController@crearPrestamo');
//Consulta reservas
Route::resource('consultaReservas', 'ConsultaReservasController');

//Consulta Salas Disponibles
Route::resource('consultaSalasDispo', 'consultaSalasDispoController');

//reservas
Route::resource('reservas', 'ReservasController');
Route::get('cargaEventos{sala?}','ReservasController@index');
Route::post('reservas/guardaEventos', array('as' => 'guardaEventos','uses' => 'ReservasController@store'));
Route::post('reservas/guardarReservas', array('as' => 'guardarReservas','uses' => 'ReservasController@guardarReservas'));
Route::post('reservas/getFestivos', array('as' => 'getFestivos','uses' => 'FestivosController@getFestivos'));
Route::post('actualizaEventos','ReservasController@update');
Route::post('eliminaEvento','ReservasController@delete');
Route::post('consultaSalas', array('as' => 'consultaSalas','uses' => 'EquiposController@consultaSalas'));
Route::post('consultarEquipos', array('as'=>'consultarEquipos','uses' => 'ConsultaEquiposController@consultarEquipos'));

Route::get('autorizarReservas', 'AutorizacionesController@index');
Route::post('autorizarReservas/{AUTO_ID}/aprobar', 'AutorizacionesController@aprobar');
Route::post('autorizarReservas/{AUTO_ID}/rechazar', 'AutorizacionesController@rechazar');
Route::post('autorizarReservas/{AUTO_ID}/anular', 'AutorizacionesController@anular');
Route::get('autorizarReservas/{AUTO_ID}/anular', 'AutorizacionesController@anular');


Route::post('consultaEstados', array('as' => 'consultaEstados','uses' => 'ReservasController@consultaEstados'));

//recursos
Route::resource('recursos', 'RecursosController');

Route::post('consultaSalasR', array('as' => 'consultaSalasR','uses' => 'RecursosController@consultaSalasR'));

//Salas para equipos
Route::get('salas/{SALA_ID}/reservarSalaEquipos', 'SalasController@reservarSalaEquipos')->name('reservasSalaEquipos');

//Finalizar prestamos para equipos
Route::get('prestamos/{PRES_ID}/finalizarPrestamo', 'PrestamoEquiposController@finalizarPrestamo')->name('finalizarPrestamo');

//ExportarPdf
Route::get('layoutPDF', 'ExportarPdfController@layoutPDF');
Route::get('streamPDF', 'ExportarPdfController@streamPDF');
Route::get('savePDF', 'ExportarPdfController@savePDF');

//Prueba
Route::get('/testreserva', function(){
	return View::make('reservas/testvalidacion');
});

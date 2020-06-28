<?php

namespace reservas\Http\Controllers;

use reservas\Http\Requests;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;


use reservas\ParametroGeneral;

class ParametroGeneralController extends Controller
{
	public $soap;

	const REQUIRED = 'required';
	const PARAMETRODESC = 'PAGE_DESCRIPCION';
	const PARAMETROVAL = 'PAGE_VALOR';
	const PARAMETROOBS = 'PAGE_OBSERVACIONES';
	const ALERTINFO = 'alert-info';
	const MAX3000 = 'max:3000';

	protected $route = 'parametrosgenerales';

	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		$this->soap = (new SoapController);
		if(!auth()->guest() && isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_ROL) ? auth()->user()->rol->ROLE_ROL : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = array('index', 'create', 'edit', 'store', 'show', 'destroy');

			if(in_array(explode("@", $action)[1], $arrActionsAdmin) && ! in_array($role , ['admin','editor']))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				Session::flash('alert-danger', '¡Usuario no tiene permisos!');
				abort(403, '¡Usuario no tiene permisos!.');
			}
		}
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$parametrosgenerales = ParametroGeneral::all();
		//Se carga la vista y se pasan los registros
		return view($this->route.'.index', compact('parametrosgenerales'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view($this->route.'.create');
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validación de datos
		$this->validate(request(), [
			ParametroGeneralController::PARAMETRODESC => [ParametroGeneralController::REQUIRED, 'max:100'],
			ParametroGeneralController::PARAMETROVAL => [ParametroGeneralController::REQUIRED, ParametroGeneralController::MAX3000],
			ParametroGeneralController::PARAMETROOBS => [ParametroGeneralController::MAX3000],
		]);

 		$parametro = request()->except(['_token']);


        $parametro = ParametroGeneral::create($parametro);
        $parametro->PAGE_CREADOPOR = auth()->user()->username;
        $parametro->save();

		// redirecciona al index de controlador
		Session::flash(ParametroGeneralController::ALERTINFO, 'Parametro General creado exitosamente!');
		return redirect()->to($this->route);
	}

	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $ESFI_ID
	 * @return Response
	 */
	public function show($PAGE_ID)
	{
		// Se obtiene el registro
		$parametrogeneral = ParametroGeneral::findOrFail($PAGE_ID);

		// Muestra la vista y pasa el registro
		return view($this->route.'.show', compact('parametrogeneral'));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $ESFI_ID
	 * @return Response
	 */
	public function edit($PAGE_ID)
	{
		// Se obtiene el registro a modificar
		$parametrogeneral = ParametroGeneral::findOrFail($PAGE_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		// y arreglos para llenar los Selects
		return view($this->route.'.edit', compact('parametrogeneral'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $ESFI_ID
	 * @return Response
	 */
	public function update($ESFI_ID)
	{
		//Validación de datos
		$this->validate(request(), [
			ParametroGeneralController::PARAMETRODESC => [ParametroGeneralController::REQUIRED, 'max:100'],
			ParametroGeneralController::PARAMETROVAL => [ParametroGeneralController::REQUIRED, ParametroGeneralController::MAX3000],
			ParametroGeneralController::PARAMETROOBS => [ParametroGeneralController::MAX3000],
		]);

		// Se obtiene el registro
		$parametro = ParametroGeneral::findOrFail($ESFI_ID);

		$parametro->PAGE_DESCRIPCION = Input::get(ParametroGeneralController::PARAMETRODESC);
		$parametro->PAGE_VALOR = Input::get(ParametroGeneralController::PARAMETROVAL);
		$parametro->PAGE_OBSERVACIONES = Input::get(ParametroGeneralController::PARAMETROOBS);
        $parametro->PAGE_MODIFICADOPOR = auth()->user()->username;
        //Se guarda modelo
		$parametro->save();

		// redirecciona al index de controlador
		Session::flash(ParametroGeneralController::ALERTINFO, 'Parametro '.$parametro->PAGE_ID.' modificado exitosamente!');
		return redirect()->to($this->route);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $ESFI_ID
	 * @return Response
	 */
	public function destroy($PAGE_ID, $showMsg=True)
	{
		$parametro = ParametroGeneral::findOrFail($PAGE_ID);

		// delete
        $parametro->PAGE_ELIMINADOPOR = auth()->user()->username;
		$parametro->save();
		$parametro->delete();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash(ParametroGeneralController::ALERTINFO, 'Parametro '.$parametro->PAGE_ID.' eliminada exitosamente!');
			return redirect()->to($this->route);
		}
	}
	
}

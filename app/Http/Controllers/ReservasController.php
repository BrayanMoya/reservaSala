<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;

use reservas\Http\Requests;
use reservas\Reserva;
use reservas\Autorizacion;
use reservas\Estado;
use Carbon\Carbon;
use reservas\User;
use reservas\Rol;

use reservas\Mail;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;
use Exception;

use reservas\Http\Controllers\SoapController;

class ReservasController extends Controller
{
	public $soap;

	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		$this->soap = (new SoapController);
		if(!auth()->guest() && isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_ROL) ? auth()->user()->rol->ROLE_ROL : 'guest';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = array('index', 'create', 'edit', 'store', 'show', 'destroy');

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor','docente', 'estudiante']))//Si el rol no es admin o editor, se niega el acceso.
				{
					Session::flash('alert-danger', '¡Usuario no tiene permisos!');
					abort(403, '¡Usuario no tiene permisos!.');
				}
			}
		}
	}

	public function show()
	{
		$arrFacultades = $this->soap->getFacultadesWs();

		$arrProgramas = $this->soap->getProgramasWs();

		$arrFranjas = $this->soap->getFranjasWs();

		$arrGrupos = $this->soap->getGruposWs();

		$arrMaterias = $this->soap->getMateriasWs();

		$arrPeriodos = getGlobalParameterToArrayCombine('PERIODO_ACADEMICO', '1900-01');

		return view('reservas/index', compact('arrFacultades', 'arrProgramas', 'arrFranjas', 'arrGrupos', 'arrMaterias', 'arrPeriodos'));
	}

	public function listarReservas()
	{
		return view('reservas/listarreservas');
	}


	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index($sala = null)
	{
		$data = array(); //declaramos un array principal que va contener los datos

		$reservas = \reservas\Reserva::programadas()
									->join('SALAS', 'SALAS.SALA_ID', '=', 'RESERVAS.SALA_ID')
									->join('SEDES', 'SEDES.SEDE_ID', '=', 'SALAS.SEDE_ID')
									->join('RESERVAS_AUTORIZADAS AS RES_AUT', 'RES_AUT.RESE_ID', '=', 'RESERVAS.RESE_ID')
									->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RESERVAS_AUTORIZADAS.AUTO_ID')
									->join('ESTADOS', 'ESTADOS.ESTA_ID', '=', 'AUTORIZACIONES.ESTA_ID')
									->where('RESERVAS.SALA_ID', $sala)
						->where('RESERVAS.SALA_ID', $sala)
						->get();

		$count = count($reservas); //contamos los ids obtenidos para saber el numero exacto de eventos

		//hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
		for($i=0;$i<$count;$i++){

			//Se calcula el color de la reserva según el estado de la autorización
			$ESTA_ID = $reservas[$i]->autorizaciones->first()->ESTA_ID;
			switch ($ESTA_ID) {
				case Estado::RESERVA_PENDIENTE:
					$backgroundColor = Reserva::COLOR_PENDIENTE;
					break;
				case Estado::RESERVA_APROBADA:
					$backgroundColor = Reserva::COLOR_APROBADO;
					break;
				case Estado::RESERVA_RECHAZADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				case Estado::RESERVA_ANULADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				default:
					$backgroundColor = Reserva::COLOR_FINALIZADO;
					break;
			}

			$data[$i] = [
				"title"=>"", //obligatoriamente "title", "start" y "url" son campos requeridos
				"start"=>$reservas[$i]->RESE_FECHAINI, //por el plugin asi que asignamos a cada uno el valor correspondiente
				"end"=>$reservas[$i]->RESE_FECHAFIN,
				"allDay"=>$reservas[$i]->ALLDAY,
				//"backgroundColor"=>$reservas[$i]->RESE_COLOR,
				"backgroundColor"=>$backgroundColor,
				//"borderColor"=>$borde[$i],
				"RESE_ID"=>$reservas[$i]->RESE_ID,
				"SALA_DESCRIPCION"=>$reservas[$i]->SALA_DESCRIPCION,
				"SALA_CAPACIDAD"=>$reservas[$i]->SALA_CAPACIDAD,
				"SEDE_DESCRIPCION"=>$reservas[$i]->SEDE_DESCRIPCION,
				"ESTA_DESCRIPCION" => $reservas[$i]->ESTA_DESCRIPCION,
				"AUTO_ID" => $reservas[$i]->AUTO_ID,
				"count_reservas" => Autorizacion::find($reservas[$i]->AUTO_ID)->reservas->count(),
				"RESE_CREADOPOR" => ($reservas[$i]->RESE_USUARIOUNIAJC !=NULL) ? $reservas[$i]->RESE_USUARIOUNIAJC : $reservas[$i]->RESE_CREADOPOR,
				"RESE_CODFACULTAD"=>$reservas[$i]->RESE_CODFACULTAD,
				"RESE_NOMFACULTAD"=>$reservas[$i]->RESE_NOMFACULTAD,
				"RESE_CODPROGRAMA"=>$reservas[$i]->RESE_CODPROGRAMA,
				"RESE_NOMPROGRAMA"=>$reservas[$i]->RESE_NOMPROGRAMA,
				"RESE_CODGRUPO"=>$reservas[$i]->RESE_CODGRUPO,
				"RESE_NOMGRUPO"=>$reservas[$i]->RESE_NOMGRUPO,
				"RESE_CODMATERIA"=>$reservas[$i]->RESE_CODMATERIA,
				"RESE_NOMMATERIA"=>$reservas[$i]->RESE_NOMMATERIA,
				"RESE_CODFRANJA"=>$reservas[$i]->RESE_CODFRANJA,
				"RESE_NOMFRANJA"=>$reservas[$i]->RESE_NOMFRANJA,
				//en el campo "url" concatenamos el el URL con el id del evento para luego
				//en el evento onclick de JS hacer referencia a este y usar el método show
				//para mostrar los datos completos de un evento
			];
		}

		 //convertimos el array principal $data a un objeto Json
	   return json_encode($data); //para luego retornarlo y estar listo para consumirlo
	}

	public function consultarReservas($sala = null)
	{

		$data = array(); //declaramos un array principal que va contener los datos

		$reservas = \reservas\Reserva::todas()
									->join('SALAS', 'SALAS.SALA_ID', '=', 'RESERVAS.SALA_ID')
									->join('SEDES', 'SEDES.SEDE_ID', '=', 'SALAS.SEDE_ID')
									->join('RESERVAS_AUTORIZADAS AS RES_AUT', 'RES_AUT.RESE_ID', '=', 'RESERVAS.RESE_ID')
									->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RESERVAS_AUTORIZADAS.AUTO_ID')
									->join('ESTADOS', 'ESTADOS.ESTA_ID', '=', 'AUTORIZACIONES.ESTA_ID')
					->where('RESERVAS.SALA_ID', $sala)
						->get();

		$count = count($reservas); //contamos los ids obtenidos para saber el numero exacto de eventos

		//hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
		for($i=0;$i<$count;$i++){

			//Se calcula el color de la reserva según el estado de la autorización
			$ESTA_ID = $reservas[$i]->autorizaciones->first()->ESTA_ID;
			switch ($ESTA_ID) {
				case Estado::RESERVA_PENDIENTE:
					$backgroundColor = Reserva::COLOR_PENDIENTE;
					break;
				case Estado::RESERVA_APROBADA:
					$backgroundColor = Reserva::COLOR_APROBADO;
					break;
				case Estado::RESERVA_RECHAZADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				case Estado::RESERVA_ANULADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				default:
					$backgroundColor = Reserva::COLOR_FINALIZADO;
					break;
			}

			$data[$i] = [
				"title"=>substr($reservas[$i]->MATE_NOMBRE, 0, 10) . "..", //obligatoriamente "title", "start" y "url" son campos requeridos
				"start"=>$reservas[$i]->RESE_FECHAINI, //por el plugin asi que asignamos a cada uno el valor correspondiente
				"end"=>$reservas[$i]->RESE_FECHAFIN,
				"allDay"=>$reservas[$i]->ALLDAY,
				//"backgroundColor"=>$reservas[$i]->RESE_COLOR,
				"backgroundColor"=>$backgroundColor,
				//"borderColor"=>$borde[$i],
				"RESE_ID"=>$reservas[$i]->RESE_ID,
				"SALA_DESCRIPCION"=>$reservas[$i]->SALA_DESCRIPCION,
				"SALA_CAPACIDAD"=>$reservas[$i]->SALA_CAPACIDAD,
				"SEDE_DESCRIPCION"=>$reservas[$i]->SEDE_DESCRIPCION,
				"ESTA_ID" => $reservas[$i]->ESTA_ID,
				"ESTA_DESCRIPCION" => $reservas[$i]->ESTA_DESCRIPCION,
				"AUTO_ID" => $reservas[$i]->AUTO_ID,
				"count_reservas" => Autorizacion::find($reservas[$i]->AUTO_ID)->reservas->count(),
				"RESE_CREADOPOR" => $reservas[$i]->RESE_CREADOPOR,
				"RESE_CODFACULTAD"=>$reservas[$i]->RESE_CODFACULTAD,
				"RESE_NOMFACULTAD"=>$reservas[$i]->RESE_NOMFACULTAD,
				"RESE_CODPROGRAMA"=>$reservas[$i]->RESE_CODPROGRAMA,
				"RESE_NOMPROGRAMA"=>$reservas[$i]->RESE_NOMPROGRAMA,
				"RESE_CODGRUPO"=>$reservas[$i]->RESE_CODGRUPO,
				"RESE_NOMGRUPO"=>$reservas[$i]->RESE_NOMGRUPO,
				"RESE_CODMATERIA"=>$reservas[$i]->RESE_CODMATERIA,
				"RESE_NOMMATERIA"=>$reservas[$i]->RESE_NOMMATERIA,
				"RESE_CODFRANJA"=>$reservas[$i]->RESE_CODFRANJA,
				"RESE_NOMFRANJA"=>$reservas[$i]->RESE_NOMFRANJA,
				//en el campo "url" concatenamos el el URL con el id del evento para luego
				//en el evento onclick de JS hacer referencia a este y usar el método show
				//para mostrar los datos completos de un evento
			];
		}

		 //convertimos el array principal $data a un objeto Json
	   return json_encode($data); //para luego retornarlo y estar listo para consumirlo
	}

	public function consultarReservasFiltro()
	{
		$sala = Input::get("sala");
		$facultad = Input::get("cboxFacultades");
		$docente = Input::get("cBoxDocentes");
		$grupo = Input::get("cBoxGrupos");
		$asignatura = Input::get("cboxAsignaturas");
		$estado = Input::get("cboxEstados");

		$data = array(); //declaramos un array principal que va contener los datos

		$reservas = \reservas\Reserva::join('SALAS', 'SALAS.SALA_ID', '=', 'RESERVAS.SALA_ID')
									->join('SEDES', 'SEDES.SEDE_ID', '=', 'SALAS.SEDE_ID')
									->join('RESERVAS_AUTORIZADAS AS RES_AUT', 'RES_AUT.RESE_ID', '=', 'RESERVAS.RESE_ID')
									->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RES_AUT.AUTO_ID')
									->join('ESTADOS', 'ESTADOS.ESTA_ID', '=', 'AUTORIZ.ESTA_ID')
									->join('MATERIAS', 'MATERIAS.MATE_CODIGOMATERIA', '=', 'AUTORIZ.MATE_CODIGOMATERIA')
									->join('GRUPOS', 'GRUPOS.GRUP_ID', '=', 'AUTORIZ.GRUP_ID')
									->join('UNIDADES', 'UNIDADES.UNID_ID', '=', 'AUTORIZ.UNID_ID')
					->join('PERSONANATURALGENERAL', 'PERSONANATURALGENERAL.PEGE_ID', '=', 'AUTORIZ.PEGE_ID')
					->where('RESERVAS.SALA_ID', '=' , 3);

		if($sala != null)
			$reservas->where('RESERVAS.SALA_ID', '=', $sala);
		if($facultad != null)
			$reservas->where('AUTORIZ.UNID_ID', '=', $facultad);
		if($docente != null)
			$reservas->where('AUTORIZ.PEGE_ID', '=', $docente);
		if($grupo != null)
			$reservas->where('AUTORIZ.GRUP_ID', '=', $grupo);
		if($asignatura != null)
			$reservas->where('AUTORIZ.MATE_CODIGOMATERIA', '=', $asignatura);
		if($estado)
			$reservas->where('AUTORIZ.ESTA_ID', '=', $estado);

		$reservas = $reservas->get();


		$count = count($reservas); //contamos los ids obtenidos para saber el numero exacto de eventos

		//hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
		for($i=0;$i<$count;$i++){

			//Se calcula el color de la reserva según el estado de la autorización
			$ESTA_ID = $reservas[$i]->autorizaciones->first()->ESTA_ID;
			switch ($ESTA_ID) {
				case Estado::RESERVA_PENDIENTE:
					$backgroundColor = Reserva::COLOR_PENDIENTE;
					break;
				case Estado::RESERVA_APROBADA:
					$backgroundColor = Reserva::COLOR_APROBADO;
					break;
				case Estado::RESERVA_RECHAZADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				case Estado::RESERVA_ANULADA:
					$backgroundColor = Reserva::COLOR_RECHAZADO;
					break;
				default:
					$backgroundColor = Reserva::COLOR_FINALIZADO;
					break;
			}

			$data[$i] = [
				"title"=>substr($reservas[$i]->MATE_NOMBRE, 0, 10) . "..", //obligatoriamente "title", "start" y "url" son campos requeridos
				"start"=>$reservas[$i]->RESE_FECHAINI, //por el plugin asi que asignamos a cada uno el valor correspondiente
				"end"=>$reservas[$i]->RESE_FECHAFIN,
				"allDay"=>$reservas[$i]->ALLDAY,
				//"backgroundColor"=>$reservas[$i]->RESE_COLOR,
				"backgroundColor"=>$backgroundColor,
				//"borderColor"=>$borde[$i],
				"RESE_ID"=>$reservas[$i]->RESE_ID,
				"SALA_DESCRIPCION"=>$reservas[$i]->SALA_DESCRIPCION,
				"SALA_CAPACIDAD"=>$reservas[$i]->SALA_CAPACIDAD,
				"SEDE_DESCRIPCION"=>$reservas[$i]->SEDE_DESCRIPCION,
				"ESTA_ID" => $reservas[$i]->ESTA_ID,
				"ESTA_DESCRIPCION" => $reservas[$i]->ESTA_DESCRIPCION,
				"AUTO_ID" => $reservas[$i]->AUTO_ID,
				"count_reservas" => Autorizacion::find($reservas[$i]->AUTO_ID)->reservas->count(),
				"RESE_CREADOPOR" => $reservas[$i]->RESE_CREADOPOR,
				"RESE_CODFACULTAD"=>$reservas[$i]->RESE_CODFACULTAD,
				"RESE_NOMFACULTAD"=>$reservas[$i]->RESE_NOMFACULTAD,
				"RESE_CODPROGRAMA"=>$reservas[$i]->RESE_CODPROGRAMA,
				"RESE_NOMPROGRAMA"=>$reservas[$i]->RESE_NOMPROGRAMA,
				"RESE_CODGRUPO"=>$reservas[$i]->RESE_CODGRUPO,
				"RESE_NOMGRUPO"=>$reservas[$i]->RESE_NOMGRUPO,
				"RESE_CODMATERIA"=>$reservas[$i]->RESE_CODMATERIA,
				"RESE_NOMMATERIA"=>$reservas[$i]->RESE_NOMMATERIA,
				"RESE_DOCENTE"=>$reservas[$i]->RESE_DOCENTE,
				//en el campo "url" concatenamos el el URL con el id del evento para luego
				//en el evento onclick de JS hacer referencia a este y usar el método show
				//para mostrar los datos completos de un evento
			];
		}

		 //convertimos el array principal $data a un objeto Json
		return json_encode($data); //para luego retornarlo y estar listo para consumirlo



	}



	public function create()
	{
		// Carga el formulario para crear un nuevo registro (views/create.blade.php)
		return view('reservas/create');
	}

	public function store()
	{
		//Validación de datos

		$this->validate(request(), [
				'start' => ['required', 'max:50'],
				'end' => ['required', 'max:50'],
				'background' => ['required', 'max:100'],
				'title' => ['required', 'max:100'],
				'sala' => ['required', 'max:100'],
			]);

		$titulo = Input::get('title');

		$reserva = new Reserva;
		$reserva->RESE_FECHAINI = Input::get('start');
		$reserva->RESE_FECHAFIN = Input::get('end');
		$reserva->RESE_TODOELDIA = false;

		$sala = \reservas\Sala::findOrFail(Input::get('sala'));
		$reserva->SALA_ID = $sala->SALA_ID;


		if(Input::get('equipo') != 0){
			$equipo = $this->getEquipoDisp($sala->SALA_ID, $reserva->RESE_FECHAINI, $reserva->RESE_FECHAFIN);
			$titulo = "R.E";
			$reserva->EQUI_ID = $equipo->EQUI_ID;
		}

		//Se guarda modelo
		$reserva->RESE_TITULO = $titulo;
		$reserva->RESE_CREADOPOR = (session('useracademusoft')!=NULL) ? session('useracademusoft') : auth()->user()->username;

		$reserva->save();

		// redirecciona al index de controlador
		Session::flash('alert-info', 'Reserva creada exitosamente!');
		return redirect()->to('reservas');
	}


	/* Crea las reservas recibidas por ajax y su respectiva autorización.
	 *
	*/
	public function guardarReservas(Request $request)
	{


		$ROLE_ID = auth()->check() ? auth()->user()->ROLE_ID : 0;
		$fechaactual = Carbon::now();

		$rawReservasInput = $request->get('reservas');

		//Arreglo para almacenar los id´s de las reservas creadas
		$arrRESE_ID = [];

		if(!isset($rawReservasInput) || !is_array($rawReservasInput) || empty($rawReservasInput)){
			return response()->json([
				'ERROR' => 'Datos incompletos.',
				'reservas' => json_encode($rawReservasInput)
			], 400); //400 Bad Request: La solicitud contiene sintaxis errónea y no debería repetirse
		}

		foreach ($rawReservasInput as $rawReserva) {

			//El color no se guarda en la BD sino que se calcula dependiento el estado de la reserva

			//Crear reserva:
			$reserva = Reserva::create(
				array_only($rawReserva, [
					'RESE_TITULO',
					'RESE_FECHAINI',
					'RESE_TODOELDIA',
					'RESE_FECHAFIN',
					'SALA_ID',
					'RESE_PERIODO',
			        'RESE_CODFRANJA',
			        'RESE_NOMFRANJA',
			        'RESE_CODFACULTAD',
			        'RESE_NOMFACULTAD',
			        'RESE_CODPROGRAMA',
			        'RESE_NOMPROGRAMA',
			        'RESE_CODGRUPO',
			        'RESE_NOMGRUPO',
			        'RESE_CODMATERIA',
			        'RESE_NOMMATERIA',
			        'RESE_DOCENTE'
				])
			);

			$reservaaux = Reserva::findOrFail($reserva->RESE_ID);
			$valSessionUser=session('useracademusoft');
			if ((empty($valSessionUser)) || 	(is_null($valSessionUser))){
			$reservaaux->RESE_CREADAPORUNIAJC=false;
		}else{
			$reservaaux->RESE_CREADAPORUNIAJC=true;
		}


		//datos de sesión del inicio con un usuario de academusoft
			$reservaaux->RESE_USUARIOUNIAJC=(session('useracademusoft')!=NULL) ? session('useracademusoft') : NULL;
			$reservaaux->RESE_EMAILUSERUNIAJC=(session('emailacademusoft')!=NULL) ? session('emailacademusoft') : NULL;
			$reservaaux->RESE_IDENTIFICACIONUNIAJC=(session('identifacademusoft')!=NULL) ? session('identifacademusoft') : NULL;
			$reservaaux->RESE_NOMBREUSERUNIAJC=(session('primernombreacademusoft')!=NULL) ? session('primernombreacademusoft') : NULL;
			$reservaaux->RESE_APELLIDOUSERNUNIAJC=(session('primerapellidoacademusoft')!=NULL) ? session('primerapellidoacademusoft') : NULL;
			$reservaaux->RESE_MODIFICADOPOR=(session('useracademusoft')!=NULL) ? session('useracademusoft') : auth()->user()->username;
			$reservaaux->RESE_CREADOPOR=(session('useracademusoft')!=NULL) ? session('useracademusoft') : auth()->user()->username;
			$reservaaux->save();
		//	\Log::debug('VARSESSION' . $reserva->RESE_ID);
			//Se adiciona el ID al arreglo de reservas
			array_push($arrRESE_ID, $reserva->RESE_ID);

		}
		$reserType=false;
		$rolType=false;

		$usersAdmon = User::join('ROLES', 'ROLES.ROLE_ID', '=', 'USERS.ROLE_ID')
									->select('USERS.email')
									->where('USERS.ROLE_ID','=',1)
								->whereNull('USERS.USER_FECHAELIMINADO')
								->whereNull('ROLES.ROLE_FECHAELIMINADO')
								->get();
					//$array_num = count($userrr);
//\Log::debug('EMAILUSERSS' . $array_num);
//$dataEmails =array();
		$dataEmails = [];
								foreach($usersAdmon as $t){
									array_push($dataEmails, $t->email);
									}
					//\Log::debug('EMAILUSERSS' . $dataEmails);

		//\Log::debug('EMAILUSERSS' . $userrr->email);
		//Si se crearon reservas...
		if(count($arrRESE_ID) == 1){
			$reserType=true;

			//Recopiando datos para la autorización...
			$datosAutoriz = $request->only([
				]) + [
				'AUTO_FECHASOLICITUD' => $fechaactual,
			];
			$userSessionActiva=(session('useracademusoft')!=NULL) ? session('useracademusoft') : auth()->user()->username;
			//\Log::debug('user create' . $userCaso);
			//Si el usuario es ADMIN, la reserva se autoriza automáticamente.
			if($ROLE_ID != \reservas\Rol::ADMIN){
				$rolType=true;

				$datosAutoriz = $datosAutoriz + [
					'ESTA_ID' => Estado::RESERVA_PENDIENTE,
					'AUTO_USERAUTORIZADOR' => $userSessionActiva,
				];
			} else {
				$datosAutoriz = $datosAutoriz + [
					'ESTA_ID' => Estado::RESERVA_APROBADA,
					'AUTO_USERAUTORIZADOR' => $userSessionActiva,
					'AUTO_FECHAAPROBACION' => $fechaactual,
				];
			}

			//Crear Autorización:
			$autorizacion = Autorizacion::create($datosAutoriz);
			//Creando registros de relación entre AUTORIZACIONES y RESERVAS
			$autorizacion->reservas()->sync($arrRESE_ID, false);

		} elseif(count($arrRESE_ID) > 1) {
			$reserType=true;

			//Recopiando datos para la autorización...
			$datosAutoriz = $request->only([
				]) + [
				'AUTO_FECHASOLICITUD' => $fechaactual,
			];

			//Si el usuario es ADMIN, la reserva se autoriza automáticamente.
			if($ROLE_ID != \reservas\Rol::ADMIN){
				$rolType=true;
				$datosAutoriz = $datosAutoriz + [
					'ESTA_ID' => Estado::RESERVA_PENDIENTE,
					'AUTO_FECHAAPROBACION' => $fechaactual,
				];
			} else {
				$datosAutoriz = $datosAutoriz + [
					'ESTA_ID' => Estado::RESERVA_APROBADA,
					'AUTO_FECHAAPROBACION' => $fechaactual,
				];
			}

			//Crear Autorización:
			$autorizacion = Autorizacion::create($datosAutoriz);
			//Creando registros de relación entre AUTORIZACIONES y RESERVAS
			$autorizacion->reservas()->sync($arrRESE_ID, false);

		} else {
			return response()->json([
				'ERROR' => 'No se crearon reservas.',
				'request' => json_encode($request->all())
			]);
			\Log::debug('ERROR create Reserva EMAIL');
		}

   if((!$reserType) || (!$rolType)){
		 $user = auth()->user();
		 $emailUser = $user->email;
		 $asunto = 'Reserva creada en '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION;
		 $this->sendEmail($autorizacion, 'emails.info_reserva_creada', $asunto, $emailUser);

	 }else{
		 $asunto = 'Reserva creada en '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION;
		 $this->sendEmail($autorizacion, 'emails.info_reserva_pendiente', $asunto, $dataEmails);

	 }


		return $arrRESE_ID;
	}

	protected function sendEmail($autorizacion, $view, $asunto, $emails)
    {
			//echo($emails);
//			\Log::debug('ERROR Send EMAIL' .$emails);
    	try{
				//$emailsss = implode(',', $emails);
				//$separado_por_comas = implode(",", $emails);
				//print implode(", ", $emailsss);
    		\Mail::send($view, compact('autorizacion'), function($message) use ($asunto, 	$emails){
	            //Se obtiene el usuario que creó la encuesta
	            //$user = auth()->user();
							//\Log::debug('USERRR' .  $user);
	            //remitente
	            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
	            //asunto
	            $message->subject($asunto);
	            //receptor
							$message->to($emails);
        	});
    	}
    	catch(Exception $e){
				    \Log::debug('ERROR Send EMAIL' . $e->getMessage());

    	}

    }

	public function consultaEstados(){

		$estados = \DB::table('ESTADOS')
							->select(
									'ESTADOS.ESTA_ID',
									'ESTADOS.ESTA_DESCRIPCION')
							->where('ESTADOS.TIES_ID','=',3)
							->get();

		return json_encode($estados);

	}


	public function guardarReservasDocente(Request $request)
	{
	  $reservas = Input::all();
	  $fechaactual = Carbon::now();

	  $cont = 0;
	  $idauto = null;

	  foreach ($reservas as $res) {

		foreach ($res as $k) {

			if($k[0] != null){


				if($cont == 0){
					$idauto = \DB::table('AUTORIZACIONES')->insertGetId(
						[
						'AUTO_FECHASOLICITUD' => $fechaactual,
						'ESTA_ID' => 'NAP'
						]
					);
				}

				$cont++;

				//Insertando evento a base de datos
				$reserva = new Reserva;
		//		dd((session('useracademusoft')!=NULL),session('useracademusoft'));
				$reserva->RESE_TITULO = $k[0];
				$reserva->RESE_FECHAINI = $k[1];
				$reserva->RESE_TODOELDIA = $k[2];
				$reserva->RESE_COLOR = $k[3];
				$reserva->RESE_FECHAFIN = $k[4];
				$reserva->SALA_ID = $k[5];
				$reserva->EQUI_ID = NULL;
				$reserva->RESE_CREADOPOR = auth()->user()->username;
				$reserva->save();

				$reservaid = $reserva->RESE_ID;

				\DB::table('RESERVAS_AUTORIZADAS')->insertGetId(
						[
						'RESE_ID' => $reservaid,
						'AUTO_ID' => $idauto
						]
				);


			}

		}

	  }

	  return $reserva;

	}

	protected function getEquipoDisp($SALA_ID, $start, $end){

		$ids_EqReservados = Reserva::where('SALA_ID', $SALA_ID)

							->orWhere(function ($query) use ($start, $end) {
									$query->where('RESE_FECHAINI', '>', $start)
										->where('RESE_FECHAFIN', '<', $end);
								})->get(['EQUI_ID','RESE_FECHAINI','RESE_FECHAFIN'])->toArray();

		return \reservas\Equipo::orderBy('EQUI_ID')
							->where('ESTA_ID', 2)
							->where('SALA_ID', $SALA_ID)
							->whereNotIn('EQUI_ID', $ids_EqReservados)
							->get()
							->first();

	}





	public function create2(){
		//Valores recibidos via ajax
		$title = $_POST['title'];
		$start = $_POST['start'];
		$back = $_POST['background'];
		$end = $_POST['end'];
		$sala = $_POST['sala'];
		$equipo = $_POST['equipo'];

		//Insertando evento a base de datos
		$reserva = new Reserva;
		$reserva->RESE_FECHAINI = $start;
		$reserva->RESE_FECHAFIN = $end;
		$reserva->RESE_TODOELDIA =false;
		$reserva->RESE_COLOR = $back;
		$reserva->RESE_TITULO = $title;
		$reserva->SALA_ID = $sala;

		if($equipo != 0){
			$equipo = $this->getEquipoDisp($sala, $reserva->RESE_FECHAINI, $reserva->RESE_FECHAFIN);
			$reserva->EQUI_ID = $equipo->EQUI_ID;
		}

		$reserva->save();
   }

   public function update(){
		//Valores recibidos via ajax
		$id = $_POST['id'];
		$title = $_POST['title'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$allDay = $_POST['allday'];
		$back = $_POST['background'];

		$evento=Reserva::find($id);
		if($end=='NULL'){
			$evento->fechafin=NULL;
		}else{
			$evento->fechafin=$end;
		}
		$evento->fechaini=$start;
		$evento->todoeldia=$allDay;
		$evento->color=$back;
		$evento->titulo=$title;

		$evento->save();
   }

   public function delete(){
		//Valor id recibidos via ajax
		$id = $_POST['id'];

		Reserva::destroy($id);
   }

}

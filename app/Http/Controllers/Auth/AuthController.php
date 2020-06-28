<?php

namespace reservas\Http\Controllers\Auth;

use reservas\User;
use reservas\Rol;
use Validator;
use reservas\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	const USERNAME = 'username';
	const EMAIL    = 'email';
	const ROLE     = 'ROLE_ID';
	const USUARIOS = 'usuarios';

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(Redirector $redirect=null)
	{

		//Lista de acciones que no requieren autenticación
		$arrActionsLogin = [
			'logout',
			'login',
			'getLogout',
			'showLoginForm',
		];

		//Lista de acciones que solo puede realizar los administradores
		$arrActionsAdmin = [
			'index',
			'edit',
			'show',
			'update',
			'destroy',
			'register',
			'showRegistrationForm',
			'getRegister',
			'postRegister',
		];


		//Requiere que el usuario inicie sesión, excepto en la vista logout.
		$this->middleware('auth', [ 'except' => $arrActionsLogin ]);


		if(auth()->check() && isset($redirect)){ //Compatibilidad con el comando "php artisan route:list", ya que ingresa como guest y la ruta es nula.		
			$action = Route::currentRouteAction();
			$ROLE_ID = auth()->check() ? auth()->user()->ROLE_ID : 0;

			if(in_array(explode("@", $action)[1], $arrActionsAdmin) && ! in_array($ROLE_ID , [\reservas\Rol::ADMIN]))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				abort(403, 'Usuario no tiene permisos!.');
			}
		}
	}

	 /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
    	//Convierte a minúsculas el usuario
        $request->username = strtolower($request->username);
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
    }


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			AuthController::USERNAME => 'required|max:15|unique:USERS',
			AuthController::EMAIL	 => 'required|email|max:255|unique:USERS',
			'password' => 'required|min:6|confirmed',
			AuthController::ROLE	 => 'required',
		]);
	}


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

		//Se crea una colección con los posibles roles.
		$roles = Rol::orderBy(AuthController::ROLE)
						->select(AuthController::ROLE, 'ROLE_DESCRIPCION')
						->get();

        return view('auth.register', compact('roles'));
    }

	/**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

		if( $validator->fails() ) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$usuario = $this->create($request->all());

		Session::flash('alert-info', 'Usuario '.$usuario->username.' creado exitosamente!');
		return redirect(AuthController::USUARIOS);
    }

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			AuthController::USERNAME => $data['username'],
			AuthController::EMAIL	 => $data['email'],
			'password' => bcrypt($data['password']),
			AuthController::ROLE	 => $data[AuthController::ROLE],
			'USER_CREADOPOR' => auth()->user()->username,
		]);
	}


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
    	//Se modifica para que la autenticación se realice por username y no por email
        return property_exists($this, AuthController::USERNAME) ? $this->username : AuthController::USERNAME;
    }


	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$usuarios = User::orderBy('USER_ID')->get();

		//Se carga la vista y se pasan los registros
		return view('auth/index', compact(AuthController::USUARIOS));
	}

	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $USER_ID
	 * @return Response
	 */
	public function show($USER_ID)
	{
		// Se obtiene el registro
		$usuario = User::findOrFail($USER_ID);

		// Muestra la vista y pasa el registro
		return view('auth/show', compact('usuario'));
	}

	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $USER_ID
	 * @return Response
	 */
	public function edit($USER_ID)
	{
		// Se obtiene el registro
		$usuario = User::findOrFail($USER_ID);

		//Se crea una colección con los posibles roles.
		$roles = Rol::orderBy(AuthController::ROLE)
						->select(AuthController::ROLE, 'ROLE_DESCRIPCION')
						->get();

		// Muestra el formulario de edición y pasa el registro a editar
		return view('auth/edit', compact('usuario', 'roles'));
	}

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $USER_ID
     * @return Response
     */
    public function update($USER_ID)
    {


        //Validación de datos
        $this->validate(request(), [
			'name' => 'required|max:255',
			AuthController::EMAIL => 'required|email|max:255',
			AuthController::ROLE	 => 'required',
			AuthController::EMAIL	 => 'required|email|max:255|unique:USERS,email,'.$USER_ID.',USER_ID'
        ]);

        // Se obtiene el registro
        $usuario = User::findOrFail($USER_ID);

        $usuario->name = Input::get('name');
        $usuario->email = Input::get(AuthController::EMAIL);
        $usuario->ROLE_ID = Input::get(AuthController::ROLE); //Relación con Rol
        $usuario->USER_MODIFICADOPOR = auth()->user()->username;
        //Se guarda modelo
        $usuario->save();

        // redirecciona al index de controlador
        Session::flash('alert-info', 'Usuario '.$usuario->username.' modificado exitosamente!');
        return redirect(AuthController::USUARIOS);
    }

    /**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $USER_ID
	 * @return Response
	 */
	public function destroy($USER_ID)
	{
		$usuario = User::findOrFail($USER_ID);

		//Si el usuario fue creado por SYSTEM, no se puede borrar.
		if($usuario->USER_CREADOPOR == 'SYSTEM'){
			Session::flash('alert-danger', '¡Usuario '.$usuario->username.' no se puede borrar!');
	    } else {

			if($usuario->personaGeneral){
				$usuario->personaGeneral->delete();
			}

			$usuario->USER_ELIMINADOPOR = auth()->user()->username;
			$usuario->save();
			$usuario->delete();
			
			Session::flash('alert-warning', ['¡Usuario '.$usuario->username.' borrado!']);
		}

	    return redirect(AuthController::USUARIOS);
	}
}

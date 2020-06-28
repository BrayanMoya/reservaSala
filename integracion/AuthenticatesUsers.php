<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

//use SGH\Http\Controllers\App\MenuController;
use reservas\Http\Controllers\SoapController;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return $this->showLoginForm();
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $this->clearSessionWsAcademusoft();

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        
        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }else{
            $flag = $this->autenticarWsAcademusoft($credentials['username'], $credentials['password']);
            if($flag){
                return $this->handleUserWasAuthenticated($request, $throttles);
            }else{
                return $this->sendFailedLoginResponse($request); //add by KevinR
            }
            
        }

        if(true) {
            $request->session()->put('authenticated', time());
            return redirect()->intended('success');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function autenticarWsAcademusoft($user, $password){

        $rolesnormal = array_unique(getGlobalParameterToArrayNormal('ROLES_OPERATIVOS_ACADEMUSOFT', 'Academico_estudiante'));
        $rolesadmin  = array_unique(getGlobalParameterToArrayNormal('ROLES_ADMINISTRADORES_ACADEMUSOFT', 'Administrador'));
        $rolesestudiante  = array_unique(getGlobalParameterToArrayNormal('ROLES_ESTUDIANTES_ACADEMUSOFT', 'Estudiante'));

        $iduseradmin   = getGlobalParameter('ID_USUARIO_ADMINISTRADOR', '1');
        $idusernormal  = getGlobalParameter('ID_USUARIO_OPERATIVO', '2');
        $iduserestudiante  = getGlobalParameter('ID_USUARIO_ESTUDIANTE', '4');
        $statuspermitido  = getGlobalParameter('ESTADOS_USERSACADEMUSOFT_VALIDOS', 'USUARIO ACTIVO');

        $soap = (new SoapController);
        @ $userstatus = $soap->getValidacionUsuarionWs($user);
        //dd($userstatus[0]);
        @ $data = $soap->getAutenticacionWs($user, $password);
        //dd($data);
        if(isset($userstatus[0]) && strtoupper($userstatus[0])==strtoupper($statuspermitido)){
            if(isset($data)){

                request()->session()->put('useracademusoft', $data['login']);
                request()->session()->put('identifacademusoft', $data['identificacion']);
                request()->session()->put('emailacademusoft', $data['correoElectronico']);
                request()->session()->put('primernombreacademusoft', $data['primernombre']);
                request()->session()->put('segundonombreacademusoft', $data['segundonombre']);
                request()->session()->put('primerapellidoacademusoft', $data['primerapellido']);
                request()->session()->put('segundoapellidoacademusoft', $data['segundoapellido']);

                $isAdmin = false; $isNormal = false; $isStudent = false;
                foreach ($data['listadoroles'] as $rol) {
                    if(in_array(strtoupper($rol['vRolTipo']), $rolesestudiante)){
                        $isStudent = true;
                    }
                    if(in_array(strtoupper($rol['vRolTipo']), $rolesnormal)){
                        $isNormal = true;
                        $isStudent = false;
                    }
                    if(in_array(strtoupper($rol['vRolTipo']), $rolesadmin)){
                        $isAdmin = true;
                        $isNormal = false;
                        $isStudent = false;
                    }
                }
                
                if($isAdmin){
                    \Auth::loginUsingId((int) $iduseradmin, true);
					$isNormal=false;
					$isStudent=false;
                    $this->clearSessionWsAcademusoft();
                }
                if($isNormal){
					$isAdmin=false;
					$isStudent=false;
                    \Auth::loginUsingId((int) $idusernormal, true);
                }
                if($isStudent){
                    \Auth::loginUsingId((int) $iduserestudiante, true);
                }

                return true;
            }else{
                $this->clearSessionWsAcademusoft();
            }
        }else{
                $this->clearSessionWsAcademusoft();
                return false;
        }
    }

    public function clearSessionWsAcademusoft(){
        //\Session::flush();
        request()->session()->forget('useracademusoft');
        request()->session()->forget('identifacademusoft');
        request()->session()->forget('emailacademusoft');
        request()->session()->forget('primernombreacademusoft');
        request()->session()->forget('segundonombreacademusoft');
        request()->session()->forget('primerapellidoacademusoft');
        request()->session()->forget('segundoapellidoacademusoft');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        return $this->logout();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the guest middleware for the application.
     */
    public function guestMiddleware()
    {
        $guard = $this->getGuard();

        return $guard ? 'guest:'.$guard : 'guest';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(static::class)
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }
}

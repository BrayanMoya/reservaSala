<?php

namespace reservas\Http\Controllers\Auth;

use reservas\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use reservas\Http\Controllers\SoapController;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    protected $subject = "Cambio de contraseña";

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function sendEmail($USER_ID){
                dump($USER_ID);
        $user = \reservas\User::findOrFail($USER_ID);


        $this->sendResetLinkEmail($user);

    }


    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     *
     * @return Response
     */
    public function showResetForm( $token = null )
    {
        //Si no está autenticado y no llegó un token, redirige a recuperar por email.
        if (auth()->guest() && is_null( $token )) {
            return view( 'auth.passwords.email' );
        }


        $email = Input::get('email');
        //Si está autenticado y no llegó un token...
        if ( auth()->check() && is_null($token) ){
            //Si el rol es admin y el id recibido por GET no es null...
            if( auth()->user()->rol->ROLE_ROL == 'admin' && Input::get('USER_ID') !== null){
                $user = \reservas\User::findOrFail(Input::get('USER_ID'));
            }
            else{
                $user = auth()->user();
            }

            $email = $user->email;
            $token = \Password::getRepository()->create( $user );
        }

        return view( 'auth.passwords.reset' )
                ->with( 'email', $email )
                ->with( 'token', $token );

    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $soap = (new SoapController);
        $username = session('useracademusoft')!==null ? session('useracademusoft')  : $user->username;
        $isuseracademusoft = $this->isUserAcademusfot($username);
        $mensajeconfirmacion  = getGlobalParameter('MENSAJE_CHANGEPASSWORD_CONFIRMACION', 'Error');

        $confirmarpassword = $this->confirmarPassword(request()->password, request()->password_confirmation);

        if($isuseracademusoft){

            if($confirmarpassword){
                @ $changepassword = $soap->getCambiarContrasenaWs($username, request()->password, request()->passwordold);

                if($changepassword==$mensajeconfirmacion){
                    Session::flash('alert-info', '¡Contraseña de SmartCampus modificada para '.session('useracademusoft').'!');
                }else{
                    Session::flash('alert-danger', $changepassword);
                }
            } 
        }else{

            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();

            Session::flash('alert-info', '¡Contraseña modificada para '.$user->username.'!');
            
        }

        
    }

    public function isUserAcademusfot($user){
        $soap = (new SoapController);
        @ $userstatus = $soap->getValidacionUsuarionWs($user);
        
        $statuspermitido  = getGlobalParameter('ESTADOS_USERSACADEMUSOFT_VALIDOS', 'USUARIO ACTIVO');

        if(isset($userstatus[0]) && strtoupper($userstatus[0])==strtoupper($statuspermitido)){
            $userstatus=true;
        }else{
            $userstatus=false;
        }
        
        return $userstatus;
    }

    public function confirmarPassword($passwordold, $passwordnew){
        return $passwordold===$passwordnew;
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response)
    {
        if( auth()->check() && auth()->user()->rol->ROLE_ROL == 'admin' ){
            return redirect('usuarios')->with('status', trans($response));
        }
        else{
            return redirect($this->redirectPath())->with('status', trans($response));
        }

    }
}

<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;

use reservas\Http\Requests;
use reservas\Reserva;
use reservas\Autorizacion;
use reservas\Estado;
use Carbon\Carbon;
use Auth;
use reservas\User;
use reservas\Rol;

use reservas\Mail;

use Illuminate\Support\Facades\Log;

use Session;
use Illuminate\Support\Facades\Input;

class AutorizacionesController extends Controller
{
    const AUTOFECHACREADO = 'AUTO_FECHACREADO';
    const AUTOOBSERVACIONES = 'AUTO_OBSERVACIONES';

    protected $index = 'autorizarReservas';

    /**
     * Genera listado de reservas pendientes por autorizar.
     *
     * @return Response
     */
    public function index()
    {

        $user= Auth::user()->username;
        $userSessionActiva=(session('useracademusoft')!=NULL) ? session('useracademusoft') : $user;

        $rol=Auth::user()->rol->ROLE_ROL;

        if($rol=='docente' || $rol=='estudiante'){
             $pendientesAprobar = Autorizacion::pendientesAprobar()
                            ->where('AUTO_USERAUTORIZADOR', $userSessionActiva)
                            ->orderBy(AutorizacionesController::AUTOFECHACREADO, 'desc')
                            ->get();
        }

        if($rol=='admin'){
              $pendientesAprobar = Autorizacion::pendientesAprobar()
                            ->orderBy(AutorizacionesController::AUTOFECHACREADO, 'desc')
                            ->get();
        }

        //Se carga la vista y se pasan los registros.
        return view('reservas/autorizar', compact('pendientesAprobar'));
    }

    /**
     * Aprueba una reserva o grupo de reservas.
     *
     * @param  int  $AUTO_ID
     * @return Response
     */
    public function aprobar($AUTO_ID)
    {
        // Se obtiene el registro
        $fechaactual = Carbon::now();
        $autorizacion = Autorizacion::findOrFail($AUTO_ID);

        $autorizacion->ESTA_ID = Estado::RESERVA_APROBADA;
        $autorizacion->AUTO_OBSERVACIONES = Input::get(AutorizacionesController::AUTOOBSERVACIONES);
        $autorizacion->AUTO_MODIFICADOPOR = auth()->user()->username;
        $autorizacion->AUTO_FECHAAPROBACION=$fechaactual;
        $autorizacion->save();
        $emailSend=null;

        //Se obtiene el usuario que creo la reserva.
        $userCreador = Autorizacion::select('AUTORIZACIONES.AUTO_USERAUTORIZADOR')
                      ->where('AUTORIZACIONES.AUTO_ID','=',$AUTO_ID)
                    ->whereNull('AUTORIZACIONES.AUTO_FECHAELIMINADO')
                    ->get()
                    ->first();

        //Se obtiene el email del usuario que creo la reserva.
        $usersEmail = User::join('ROLES', 'ROLES.ROLE_ID', '=', 'USERS.ROLE_ID')
    									->select('USERS.email')
    									->where('USERS.username','=',$userCreador->AUTO_USERAUTORIZADOR)
    								->whereNull('USERS.USER_FECHAELIMINADO')
                    ->whereNull('ROLES.ROLE_FECHAELIMINADO')
    								->get()
                    ->first();

                    //Si es un usuario de academusoft
                    if ((empty($usersEmail)) || 	(is_null($usersEmail))){
                      $usersReserva = Reserva::join('RESERVAS_AUTORIZADAS', 'RESERVAS_AUTORIZADAS.RESE_ID', '=', 'RESERVAS.RESE_ID')
                                    ->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RESERVAS_AUTORIZADAS.AUTO_ID')
                                    ->select('RESERVAS.RESE_EMAILUSERUNIAJC')
                                    ->where('AUTORIZ.AUTO_ID','=',$AUTO_ID)
                                    ->where('RESERVAS.RESE_USUARIOUNIAJC','=',$userCreador->AUTO_USERAUTORIZADOR)
                                    ->get()
                                    ->first();
                                //  \Log::debug('emailReservas' .  $usersReserva);

                    $emailSend= $usersReserva->RESE_EMAILUSERUNIAJC;
                    }else{
                    $emailSend= $usersEmail->email;
                    }


        //\Log::debug('EMAILUSERSS' . $usersEmail);

        // redirecciona al index de controlador
        $asunto = 'Reserva Aprobada '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION;
        $this->sendEmail($autorizacion, 'emails.info_reserva_aprobada', $asunto, $emailSend);

        Session::flash('modal-success', 'Autorización aprobada, código: ' .$AUTO_ID);
        return redirect()->to($this->index);
    }


    /**
     * Rechaza una reserva o grupo de reservas.
     *
     * @param  int  $AUTO_ID
     * @return Response
     */
    public function rechazar($AUTO_ID)
    {
        // Se obtiene el registro
        $fechaactual = Carbon::now();
        $autorizacion = Autorizacion::findOrFail($AUTO_ID);

        $autorizacion->ESTA_ID = Estado::RESERVA_RECHAZADA;
        $autorizacion->AUTO_OBSERVACIONES = Input::get(AutorizacionesController::AUTOOBSERVACIONES);
        $autorizacion->AUTO_MODIFICADOPOR = auth()->user()->username;
        $autorizacion->AUTO_FECHACANCELACION = $fechaactual;
        $autorizacion->save();
        $emailSend=null;


                //Se obtiene el usuario que creo la reserva.
                $userCreador = Autorizacion::select('AUTORIZACIONES.AUTO_USERAUTORIZADOR')
                              ->where('AUTORIZACIONES.AUTO_ID','=',$AUTO_ID)
                            ->whereNull('AUTORIZACIONES.AUTO_FECHAELIMINADO')
                            ->get()
                            ->first();

                          //  \Log::debug('USERRREMAL' .  $userCreador->AUTO_USERAUTORIZADOR);

                //Se obtiene el email del usuario que creo la reserva.
                $usersEmail = User::join('ROLES', 'ROLES.ROLE_ID', '=', 'USERS.ROLE_ID')
            									->select('USERS.email')
            									->where('USERS.username','=',$userCreador->AUTO_USERAUTORIZADOR)
            								->whereNull('USERS.USER_FECHAELIMINADO')
                            ->whereNull('ROLES.ROLE_FECHAELIMINADO')
            								->get()
                            ->first();

          //Si es un usuario de academusoft
          if ((empty($usersEmail)) || 	(is_null($usersEmail))){
            $usersReserva = Reserva::join('RESERVAS_AUTORIZADAS', 'RESERVAS_AUTORIZADAS.RESE_ID', '=', 'RESERVAS.RESE_ID')
                          ->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RESERVAS_AUTORIZADAS.AUTO_ID')
                          ->select('RESERVAS.RESE_EMAILUSERUNIAJC')
                          ->where('AUTORIZ.AUTO_ID','=',$AUTO_ID)
                          ->where('RESERVAS.RESE_USUARIOUNIAJC','=',$userCreador->AUTO_USERAUTORIZADOR)
                          ->get()
                          ->first();
                      //  \Log::debug('emailReservas' .  $usersReserva);

          $emailSend= $usersReserva->RESE_EMAILUSERUNIAJC;
      		}else{
          $emailSend= $usersEmail->email;
      		}

          $asunto = 'Reserva Rechazada '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION;
          $this->sendEmail($autorizacion, 'emails.info_reserva_rechazada', $asunto, $emailSend);



        // redirecciona al index de controlador
        Session::flash('modal-warning', 'Autorización rechazada, código: '.$AUTO_ID);
        return redirect()->to($this->index);
    }

    /**
     * Rechaza una reserva o grupo de reservas.
     *
     * @param  int  $AUTO_ID
     * @return Response
     */
    public function anular($AUTO_ID)
    {
        // Se obtiene el registro
        $fechaactual = Carbon::now();
        $autorizacion = Autorizacion::findOrFail($AUTO_ID);

        $autorizacion->ESTA_ID = Estado::RESERVA_ANULADA;
        $autorizacion->AUTO_OBSERVACIONES = Input::get(AutorizacionesController::AUTOOBSERVACIONES);
        $autorizacion->AUTO_MODIFICADOPOR = auth()->user()->username;
        $autorizacion->AUTO_FECHACANCELACION = $fechaactual;
        $autorizacion->save();
        $emailSend=null;

        $rol=Auth::user()->rol->ROLE_ROL;
        if($rol=='admin'){
          //Se obtiene el usuario que creo la reserva.
          $userCreador = Autorizacion::select('AUTORIZACIONES.AUTO_USERAUTORIZADOR')
                        ->where('AUTORIZACIONES.AUTO_ID','=',$AUTO_ID)
                      ->whereNull('AUTORIZACIONES.AUTO_FECHAELIMINADO')
                      ->get()
                      ->first();

          //Se obtiene el email del usuario que creo la reserva.
          $usersEmail = User::join('ROLES', 'ROLES.ROLE_ID', '=', 'USERS.ROLE_ID')
                        ->select('USERS.email')
                        ->where('USERS.username','=',$userCreador->AUTO_USERAUTORIZADOR)
                      ->whereNull('USERS.USER_FECHAELIMINADO')
                      ->whereNull('ROLES.ROLE_FECHAELIMINADO')
                      ->get()
                      ->first();

                      //Si es un usuario de academusoft
                      if ((empty($usersEmail)) || 	(is_null($usersEmail))){
                        $usersReserva = Reserva::join('RESERVAS_AUTORIZADAS', 'RESERVAS_AUTORIZADAS.RESE_ID', '=', 'RESERVAS.RESE_ID')
                                      ->join('AUTORIZACIONES AS AUTORIZ', 'AUTORIZ.AUTO_ID', '=', 'RESERVAS_AUTORIZADAS.AUTO_ID')
                                      ->select('RESERVAS.RESE_EMAILUSERUNIAJC')
                                      ->where('AUTORIZ.AUTO_ID','=',$AUTO_ID)
                                      ->where('RESERVAS.RESE_USUARIOUNIAJC','=',$userCreador->AUTO_USERAUTORIZADOR)
                                      ->get()
                                      ->first();
                                  //  \Log::debug('emailReservas' .  $usersReserva);

                      $emailSend= $usersReserva->RESE_EMAILUSERUNIAJC;
                      }else{
                      $emailSend= $usersEmail->email;
                      }

          $asunto = 'Reserva Anulada '.$autorizacion->reservas->first()->sala->SALA_DESCRIPCION;
          $this->sendEmail($autorizacion, 'emails.info_reserva_anulada', $asunto, $emailSend);
        }




        // redirecciona al index de controlador
        Session::flash('alert-warning', ['Autorización anulada, código'.$AUTO_ID]);
        return redirect()->back();
    }


    	protected function sendEmail($autorizacion, $view, $asunto, $emails)
        {
        	try{
        		\Mail::send($view, compact('autorizacion'), function($message) use ($asunto, $emails){
    	            //Se obtiene el usuario que creó la encuesta
    	            $user = auth()->user();
    							//\Log::debug('USERRR' .  $user);
    	            //remitente
    	            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
    	            //asunto
    	            $message->subject($asunto);
                  //receptor
                  \Log::debug('EMAIL TO SEND' .  $emails);
                  $message->to($emails);
    	            //$message->to($user->email, $user->name);
            	});
        	}
        	catch(Exception $e){
    				    \Log::debug('ERROR Send EMAIL AUTORIZACIONES' . $e->getMessage());

        	}

        }

}

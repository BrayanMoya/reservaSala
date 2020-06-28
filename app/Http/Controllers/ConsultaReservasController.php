<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;

use reservas\Http\Requests;
use reservas\Equipo;
use reservas\Reserva;
use reservas\Sede;
use reservas\Sala;
use reservas\Estado;
use Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

class ConsultaReservasController extends Controller
{

      public function __construct(Redirector $redirect=null)
    {
        //Requiere que el usuario inicie sesión.
        $this->middleware('auth');
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

        $reservas = \reservas\Reserva::orderBy('RESE_ID')
                        ->select('RESERVAS.*')
                       // ->where('PRES_FECHAFIN', null)
                        ->get();

        //Para el filtro
        $salas = Sala::select([
                              'SALAS.SALA_ID',
                              'SALAS.SALA_DESCRIPCION'
                            ])
                            ->orderBy('SALA_ID', 'ASC')
                            ->get()
                            ->toArray();

        $keys[]=null; $values[]=null;
        $cont=0;
        foreach ($salas as $key) {
           $keys[$cont] = $key['SALA_ID'];
           $values[$cont] = $key['SALA_DESCRIPCION'];
           $cont++;
        }

        $arrSalas = array_combine($keys, $values);


        $sedes = Sede::select([
                              'SEDES.SEDE_ID',
                              'SEDES.SEDE_DESCRIPCION'
                            ])
                            ->orderBy('SEDE_ID', 'ASC')
                            ->get()
                            ->toArray();

        $keys2[]=null; $values2[]=null;
        $cont=0;
        foreach ($sedes as $key) {
           $keys2[$cont] = $key['SEDE_ID'];
           $values2[$cont] = $key['SEDE_DESCRIPCION'];
           $cont++;
        }

        $arrSedes = array_combine($keys2, $values2);


        $estados = Estado::select([
                              'ESTADOS.ESTA_ID',
                              'ESTADOS.ESTA_DESCRIPCION'
                            ])
                            ->where('ESTADOS.TIES_ID', 3)
                            ->orderBy('ESTA_ID', 'ASC')
                            ->get()
                            ->toArray();

        $keys3[]=null; $values3[]=null;
        $cont=0;
        foreach ($estados as $key) {
           $keys3[$cont] = $key['ESTA_ID'];
           $values3[$cont] = $key['ESTA_DESCRIPCION'];
           $cont++;
        }

        $arrEstados = array_combine($keys3, $values3);

      //Covertir imagen en base64
      $image = asset('assets/img/Logo_opt1.png');
      $type = pathinfo($image, PATHINFO_EXTENSION);
      $data = file_get_contents($image);
      $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

      //Se carga la vista y se pasan los registros
      return view('consultas/reservas/index', compact('reservas','fechaRegistro','dataUri', 'arrSalas', 'arrSedes', 'arrEstados'));
    }

}

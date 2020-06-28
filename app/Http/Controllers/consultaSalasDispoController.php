<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;

use reservas\Http\Requests;
use Illuminate\Support\Facades\Log;
use reservas\Equipo;
use reservas\Reserva;
use reservas\Sede;
use reservas\Sala;
use reservas\Recurso;
use Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

class consultaSalasDispoController extends Controller
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

            if(in_array(explode("@", $action)[1], $arrActionsAdmin) && ! in_array($role , ['admin','editor','docente']))//Si la acción del controlador se encuentra en la lista de acciones de admin...
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

/*
        $salasIndex = \reservas\Sala::orderBy('SALA_ID')
                ->select('SALAS.*')
                ->where('ESTA_ID', null)
                ->get();
*/

  		$salasIndexx = \reservas\Sala::join('ESTADOS', 'ESTADOS.ESTA_ID', '=', 'SALAS.ESTA_ID')
  									->select([
                      'SALA_ID',
                      'SALA_DESCRIPCION',
          'SALA_CAPACIDAD',
          'SALA_OBSERVACIONES',
          'SEDE_ID',
          'SALAS.ESTA_ID',
          'SALA_PRESTAMO',
                    ])
  									->where('SALAS.ESTA_ID','=',1)
                    ->where('SALAS.SALA_PRESTAMO','=',0)
  								->whereNull('SALAS.SALA_FECHAELIMINADO')
  								->get();


            $salasIndex = \reservas\Sala::with('recursos','reservas')->orderBy('SALA_ID')
                                  ->select([
                                  	'SALA_ID',
                                  	'SALA_DESCRIPCION',
          							'SALA_CAPACIDAD',
          							'SALA_OBSERVACIONES',
          							'SEDE_ID',
          							'ESTA_ID',
          							'SALA_PRESTAMO',
                                  ])
                                  ->where('SALAS.ESTA_ID','=',1)
                                  ->where('SALAS.SALA_PRESTAMO','=',0)
                								->whereNull('SALAS.SALA_FECHAELIMINADO')
                                  ->get();

//\Log::debug('SALASDISPOS' . $salasIndex);

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

        $recursos = Recurso::select([
                              'RECURSOS.RECU_ID',
                              'RECURSOS.RECU_DESCRIPCION'
                            ])
                            ->whereNull('RECURSOS.RECU_FECHAELIMINADO')
                            ->orderBy('RECU_ID', 'ASC')
                            ->get()
                            ->toArray();

        $keys3[]=null; $values3[]=null;
        $cont=0;
        foreach ($recursos as $key) {
           $keys3[$cont] = $key['RECU_ID'];
           $values3[$cont] = $key['RECU_DESCRIPCION'];
           $cont++;
        }

        $arrRecursos = array_combine($keys3, $values3);

        //\Log::debug('RECURSDISPOS' . $recursos);

      //Covertir imagen en base64
      $image = asset('assets/img/Logo_opt1.png');
      $type = pathinfo($image, PATHINFO_EXTENSION);
      $data = file_get_contents($image);
      $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

      //Se carga la vista y se pasan los registros
      return view('consultas/salasdisponibles/index', compact('salasIndex','fechaRegistro','dataUri', 'arrSalas', 'arrSedes','arrRecursos'));
    }

}

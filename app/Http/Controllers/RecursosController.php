<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;

use reservas\Http\Requests;
use reservas\Recurso;

use Session;
use Illuminate\Support\Facades\Input;


class RecursosController extends Controller
{
    const RECURSOS = 'recursos';
    const SALAS = 'SALAS';
    const REQUIRED = 'required';
    const RECURSODESC = 'RECU_DESCRIPCION';
    const MAX50 = 'max:50';
    const RECURSOVERS = 'RECU_VERSION';
    const RECURSOOBSE = 'RECU_OBSERVACIONES';
    const SALAKEY = 'SALA_ID';
    const ALERTINFO = 'alert-info';

    public function __construct(Redirector $redirect=null)
    {
        //Requiere que el usuario inicie sesión.
        $this->middleware('auth');
        if(!auth()->guest() && isset($redirect)){

            $action = Route::currentRouteAction();
            $role = isset(auth()->user()->rol->ROLE_ROL) ? auth()->user()->rol->ROLE_ROL : 'guest';

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
        //Se obtienen todas los contratos.
        $recursos = \reservas\Recurso::getRecursos();


        //Se carga la vista y se pasan los registros. ->paginate($cantPages)
        return view('recursos/index', compact(RecursosController::RECURSOS));
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     *
     * @return Response
     */
    public function create()
    {

        $salas = \DB::table(EquiposController::SALAS)
                            ->select(EquiposController::SALAS.'.*')
                            ->whereNull('SALA_FECHAELIMINADO')
                            ->get();

        $sedes = \DB::table(EquiposController::SEDES)
                            ->select(EquiposController::SEDES.'.*')
                            ->whereNull('SEDE_FECHAELIMINADO')
                            ->get();


                            $arrSedes = [];
                            foreach ($sedes as $sedes) {
                                $arrSedes = array_add(
                                    $arrSedes,
                                    $sedes->SEDE_ID,
                                    $sedes->SEDE_DESCRIPCION
                                );
                            }

                            $arrSalas = [];
                            foreach ($salas as $sala) {
                                $arrSalas = array_add(
                                    $arrSalas,
                                    $sala->SALA_ID,
                                    $sala->SALA_DESCRIPCION
                                );
                            }



        // Carga el formulario para crear un nuevo registro (views/create.blade.php)
        return view('recursos/create', compact('arrSalas','arrSedes'));
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
                RecursosController::RECURSODESC => [RecursosController::REQUIRED, RecursosController::MAX50],
                RecursosController::RECURSOVERS => [RecursosController::REQUIRED, RecursosController::MAX50],
                RecursosController::RECURSOOBSE => [RecursosController::REQUIRED, 'max:100'],
                RecursosController::SALAKEY => [RecursosController::REQUIRED]
            ]);

        //Guarda todos los datos recibidos del formulario
        $recurso = new Recurso(request()->except(['_token']));
        $recurso->RECU_CREADOPOR = auth()->user()->username;
        $recurso->save();

        /*
        request()->merge(['RECU_CREADOPOR' => auth()->user()->username]);
        $recurso = request()->except(['_token']);
        $recurso = Recurso::create($recurso);
        $recurso->save();
        */

        $idsSalas = is_array(Input::get(RecursosController::SALAKEY)) ? Input::get(RecursosController::SALAKEY) : [];
        $recurso->salas()->sync($idsSalas);

        // redirecciona al index de controlador
        Session::flash(RecursosController::ALERTINFO, 'Recurso creado exitosamente!');
        return redirect()->to(RecursosController::RECURSOS);
    }


    /**
     * Muestra información de un registro.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($RECU_ID)
    {
        // Se obtiene el registro
        $recurso = Recurso::findOrFail($RECU_ID);
        // Muestra la vista y pasa el registro
        return view('recursos/show', compact('recurso'));
    }

    /**
     * Muestra el formulario para editar un registro en particular.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($RECU_ID)
    {
        // Se obtiene el registro
        $recurso = Recurso::find($RECU_ID);

        $idsSalas = $recurso->salas()->getRelatedIds()->toArray();

        $salas = \DB::table(EquiposController::SALAS)
                            ->select(EquiposController::SALAS.'.*')
                            ->whereNull('SALA_FECHAELIMINADO')
                            ->get();

        $sedes = \DB::table(EquiposController::SEDES)
                            ->select(EquiposController::SEDES.'.*')
                            ->whereNull('SEDE_FECHAELIMINADO')
                            ->get();

        // Muestra el formulario de edición y pasa el registro a editar
        return view('recursos/edit', compact('recurso','idsSalas','salas','sedes'));
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($RECU_ID)
    {
        //Validación de datos
        $this->validate(request(), [
            RecursosController::RECURSODESC => [RecursosController::REQUIRED, RecursosController::MAX50],
            RecursosController::RECURSOVERS => [RecursosController::REQUIRED, RecursosController::MAX50],
            RecursosController::RECURSOOBSE => [RecursosController::REQUIRED, 'max:100']
        ]);

        // Se obtiene el registro
        $recurso = Recurso::findOrFail($RECU_ID);
        $recurso->RECU_DESCRIPCION = Input::get(RecursosController::RECURSODESC);
        $recurso->RECU_VERSION = Input::get(RecursosController::RECURSOVERS);
        $recurso->RECU_OBSERVACIONES = Input::get(RecursosController::RECURSOOBSE);
        $recurso->RECU_MODIFICADOPOR = auth()->user()->username;
        $recurso->save();

        $idsSalas = is_array(Input::get(RecursosController::SALAKEY)) ? Input::get(RecursosController::SALAKEY) : [];
        $recurso->salas()->sync($idsSalas);

        // redirecciona al index de controlador
        Session::flash(RecursosController::ALERTINFO, 'Recurso actualizado exitosamente!');
        return redirect()->to('recursos/');
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($RECU_ID)
    {
        // delete

        $recurso = Recurso::findOrFail($RECU_ID);

        $recurso->RECU_ELIMINADOPOR = auth()->user()->username;
        $recurso->save();
        $recurso->delete();

        // redirecciona al index de controlador
        Session::flash(RecursosController::ALERTINFO, 'Recurso '.$RECU_ID.' borrado!');
        return redirect()->to(RecursosController::RECURSOS);
    }


    public function consultaSalasR(){

        $SEDE_ID = $_POST['sede'];

        $salas = \DB::table(RecursosController::SALAS)
                            ->select('SALAS.SALA_ID','SALAS.SALA_DESCRIPCION')
                            ->where('SALAS.SEDE_ID','=',$SEDE_ID)
                            ->whereNull('SALAS.SALA_FECHAELIMINADO')
                            ->get();

        return json_encode($salas);
    }

}

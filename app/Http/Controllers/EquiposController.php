<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use reservas\Equipo;

class EquiposController extends Controller
{
    
    const SALAS = 'SALAS';
    const SEDES = 'SEDES';
    const SALASMIN = 'salas';
    const SEDESMIN = 'sedes';
    const EQUIPOSMIN = 'equipos';
    const REQUIRED = 'required';
    const MAX300 = 'max:300';
    const EQUIDESCRIPCION = 'EQUI_DESCRIPCION';
    const EQUIOBSERVACION = 'EQUI_OBSERVACIONES';
    const SALAKEY = 'SALA_ID';
    const ESTADOKEY = 'ESTA_ID';
    const NUMERIC = 'numeric';
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
        //Se genera paginación cada $cantPages registros.
        $equipos = Equipo::join('SALAS', 'SALAS.SALA_ID', '=', 'EQUIPOS.SALA_ID')
                    ->join('SEDES', 'SEDES.SEDE_ID', '=', 'SALAS.SEDE_ID')
                    ->join('ESTADOS', 'ESTADOS.ESTA_ID', '=', 'EQUIPOS.ESTA_ID')
                    ->whereNull('SALA_FECHAELIMINADO')
                    ->whereNull('EQUI_FECHAELIMINADO')
                    ->get();

        $salas = \DB::table(EquiposController::SALAS)
                            ->select(EquiposController::SALAS.'.*')
                            ->whereNull('SALA_FECHAELIMINADO')
                            ->get();

        $sedes = \DB::table(EquiposController::SEDES)
                           ->select(EquiposController::SEDES.'.*')
                           ->whereNull('SEDE_FECHAELIMINADO')
                           ->get();

        //Covertir imagen en base64
        $image = asset('assets/img/Logo_opt1.png');
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        //Se carga la vista y se pasan los registros. ->paginate($cantPages)
        return view('equipos/index', compact(EquiposController::EQUIPOSMIN,EquiposController::SEDESMIN, EquiposController::SALASMIN,'dataUri'));
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

        $estados = \DB::table('ESTADOS')
                            ->select('ESTADOS.*')
                            ->where('ESTADOS.TIES_ID','=',2)
                            ->whereNull('ESTA_FECHAELIMINADO')
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

        $arrEstados = [];
        foreach ($estados as $estado) {
            $arrEstados = array_add(
                $arrEstados,
                $estado->ESTA_ID,
                $estado->ESTA_DESCRIPCION
            );
        }

        // Carga el formulario para crear un nuevo registro (views/create.blade.php)
        return view('equipos/create', compact(EquiposController::SALASMIN,'estados',EquiposController::SEDESMIN, 'arrSedes','arrSalas','arrEstados'));
    }

    public function consultaSalas(){

        $SEDE_ID = $_POST['sede'];

        $salas = \DB::table(EquiposController::SALAS)
                            ->select('SALAS.SALA_ID','SALAS.SALA_DESCRIPCION')
                            ->where('SALAS.SEDE_ID','=',$SEDE_ID)
                            ->whereNull('SALAS.SALA_FECHAELIMINADO')
                            ->get();

        return json_encode($salas);
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
                EquiposController::EQUIDESCRIPCION => [EquiposController::REQUIRED, EquiposController::MAX300],
                EquiposController::EQUIOBSERVACION => [EquiposController::MAX300],
                EquiposController::SALAKEY => [EquiposController::REQUIRED, EquiposController::NUMERIC],
                EquiposController::ESTADOKEY => [EquiposController::REQUIRED, EquiposController::NUMERIC]
            ]);
        //Guarda todos los datos recibidos del formulario
        request()->merge(['EQUI_CREADOPOR' => auth()->user()->username]);
        $equipo = request()->except(['_token']);
        $equipo = Equipo::create($equipo);
        $equipo->save();

        // redirecciona al index de controlador
        Session::flash(EquiposController::ALERTINFO, 'Equipo creado exitosamente!');
        return redirect()->to(EquiposController::EQUIPOSMIN);
    }


    /**
     * Muestra información de un registro.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // Se obtiene el registro
        $equipo = Equipo::join('SALAS', 'SALAS.SALA_ID', '=', 'EQUIPOS.SALA_ID')
                  ->join('SEDES', 'SEDES.SEDE_ID', '=', 'SALAS.SEDE_ID')
                  ->whereNull('SALA_FECHAELIMINADO')
                  ->whereNull('SEDE_FECHAELIMINADO')
                  ->where('EQUIPOS.EQUI_ID', $id)
                  ->get()
                  ->first();
        
        // Muestra la vista y pasa el registro
        return view('equipos/show', compact('equipo'));
    }

    /**
     * Muestra el formulario para editar un registro en particular.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Se obtiene el registro
        $equipo = Equipo::find($id);

        $salas = \DB::table(EquiposController::SALAS)
                            ->select(EquiposController::SALAS.'.*')
                            ->whereNull('SALA_FECHAELIMINADO')
                            ->get();

        $estados = \DB::table('ESTADOS')
                            ->select('ESTADOS.*')
                            ->where('ESTADOS.TIES_ID','=',2)
                            ->whereNull('ESTA_FECHAELIMINADO')
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

        $arrEstados = [];
        foreach ($estados as $estado) {
            $arrEstados = array_add(
                $arrEstados,
                $estado->ESTA_ID,
                $estado->ESTA_DESCRIPCION
            );
        }

        // Muestra el formulario de edición y pasa el registro a editar
        return view('equipos/edit', compact('equipo',EquiposController::SALASMIN,'estados',EquiposController::SEDESMIN,'arrSedes','arrSalas','arrEstados'));
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //Validación de datos
        $this->validate(request(), [
                EquiposController::EQUIDESCRIPCION => [EquiposController::REQUIRED, EquiposController::MAX300],
                EquiposController::EQUIOBSERVACION => [EquiposController::MAX300],
                EquiposController::SALAKEY => [EquiposController::REQUIRED, EquiposController::NUMERIC],
                EquiposController::ESTADOKEY => [EquiposController::REQUIRED, EquiposController::NUMERIC]
        ]);

        // Se obtiene el registro
        $equipo = Equipo::findOrFail($id);
        $equipo->EQUI_DESCRIPCION = Input::get(EquiposController::EQUIDESCRIPCION);
        $equipo->EQUI_OBSERVACIONES = Input::get(EquiposController::EQUIOBSERVACION);
        $equipo->SALA_ID = Input::get(EquiposController::SALAKEY);
        $equipo->ESTA_ID = Input::get(EquiposController::ESTADOKEY);
        $equipo->EQUI_MODIFICADOPOR = auth()->user()->username;
        $equipo->save();

        // redirecciona al index de controlador
        Session::flash(EquiposController::ALERTINFO, 'Equipo actualizado exitosamente!');
        return redirect()->to(EquiposController::EQUIPOSMIN);
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $equipo = Equipo::findOrFail($id);
        $equipo->EQUI_ELIMINADOPOR = auth()->user()->username;
        $equipo->save();
        $equipo->delete();

        // redirecciona al index de controlador
        Session::flash(EquiposController::ALERTINFO, 'Equipo '.$id.' borrado!');
        return redirect()->to(EquiposController::EQUIPOSMIN);
    }

}

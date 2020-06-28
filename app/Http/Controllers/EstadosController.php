<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;

use reservas\Http\Requests;
use reservas\Estado;
use reservas\Tipoestado;

use Session;
use Illuminate\Support\Facades\Input;
use DB;


class EstadosController extends Controller
{
    const ESTADOS = 'estados';
    const TIPOESTADOKEY = 'TIES_ID';
    const ESTADODESC = 'ESTA_DESCRIPCION';
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
       $estados=Estado::all();

       return view('estados/index')->with(EstadosController::ESTADOS, $estados);
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     *
     * @return Response
     */
    public function create()
    {
        $tipoestados = \reservas\TipoEstado::orderBy(EstadosController::TIPOESTADOKEY)
                        ->select(EstadosController::TIPOESTADOKEY, 'TIES_DESCRIPCION')
                        ->get();

        $arrTipoEstados = [];
        foreach ($tipoestados as $tipoestado) {
            $arrTipoEstados = array_add(
                $arrTipoEstados,
                $tipoestado->TIES_ID,
                $tipoestado->TIES_DESCRIPCION
            );
        }

        return view('estados/create',compact('arrTipoEstados'));
    }

    /**
     * Guarda el registro nuevo en la base de datos.
     *
     * @return Response
     */
    public function store()
    {
        $this->validate(request(), [
                EstadosController::ESTADODESC => ['required', 'max:50']
            ]);

        request()->merge(['ESTA_CREADOPOR' => auth()->user()->username]);
        $estado = request()->except(['_token']);

        $estado= Estado::create($estado);
        $estado->save();

        Session::flash(EstadosController::ALERTINFO, 'Estado creado exitosamente!');
        return redirect()->to(EstadosController::ESTADOS);
    }


    /**
     * Muestra información de un registro.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($ESTA_ID)
    {
        $estado = Estado::findOrFail($ESTA_ID);

        return view('estados/show', compact('estado'));
    }

  

    /**
     * Muestra el formulario para editar un registro en particular.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($ESTA_ID)
    {
        $estado = Estado::find($ESTA_ID);

        $tipoestados = \reservas\TipoEstado::orderBy(EstadosController::TIPOESTADOKEY)
                        ->select(EstadosController::TIPOESTADOKEY, 'TIES_DESCRIPCION')
                        ->get();

        $arrTipoEstados = [];
        foreach ($tipoestados as $tipoestado) {
            $arrTipoEstados = array_add(
                $arrTipoEstados,
                $tipoestado->TIES_ID,
                $tipoestado->TIES_DESCRIPCION
            );
        }

        return view('estados/edit',compact('estado','arrTipoEstados'));
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($ESTA_ID)
    {
        $this->validate(request(), [
            EstadosController::ESTADODESC => ['required', 'max:100']
            
        ]);

        $estado = Estado::findOrFail($ESTA_ID);

        $estado->ESTA_DESCRIPCION = Input::get(EstadosController::ESTADODESC);
        $estado->TIES_ID = Input::get(EstadosController::TIPOESTADOKEY);

        $estado->ESTA_MODIFICADOPOR = auth()->user()->username;
        $estado->save();

        Session::flash(EstadosController::ALERTINFO, 'Estado actualizado exitosamente!');
        return redirect()->to('estados/');
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($ESTA_ID)
    {

        $estado = Estado::findOrFail($ESTA_ID);

        if($estado->ESTA_CREADOPOR == 'SYSTEM'){
            Session::flash('alert-danger', 'Estado '.$estado->ESTA_DESCRIPCION.' no se puede borrar!');
        }else{
            $estado->ESTA_ELIMINADOPOR = auth()->user()->username;
            $estado->save();
            $estado->delete();
            Session::flash(EstadosController::ALERTINFO, 'estado '.$ESTA_ID.' borrado!');
        }
        
        return redirect()->to(EstadosController::ESTADOS);
    }

}


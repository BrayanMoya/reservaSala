<?php

namespace reservas\Http\Controllers;

use Illuminate\Http\Request;

use reservas\Http\Requests;
use reservas\Prestamo;
use reservas\Equipo;
use reservas\Sede;
use reservas\Sala;
use Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

class PrestamoEquiposController extends Controller
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
    public function index(Request $request)
    {
        //Se obtienen todos los registros.
        

        $equipoPrestamos = \reservas\Prestamo::orderBy('PRES_ID')
                        ->select('PRES_ID', 'PRES_IDUSARIO','PRES_NOMBREUSARIO','EQUI_ID','PRES_CREADOPOR',
                            'PRES_FECHAINI', 'PRES_FECHAFIN');

        if(! $request->get('all')){
            $equipoPrestamos->where('PRES_FECHAFIN', null);
        }

        $equipoPrestamos = $equipoPrestamos->get();

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

                           //Covertir imagen en base64
        $image = asset('assets/img/Logo_opt1.png');
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        //Se carga la vista y se pasan los registros
        return view('consultas/prestamos/index', compact('equipoPrestamos','arrSedes','arrSalas','fechaRegistro','dataUri'));
    }


    /**
     * Muestra información de un registro.
     *
     * @param  int  $ESFI_ID
     * @return Response
     */


	public function crearPrestamo()
	{    
        //Recibe parametros por metodo POST
        $equipo = $_POST['equipo'];
        $doc_usuario = $_POST['doc_usuario'];
        $nombre = $_POST['nombre'];

        $prestamo = new Prestamo;
        $prestamo->PRES_IDUSARIO = $doc_usuario;
        $prestamo->PRES_NOMBREUSARIO = $nombre;
        $prestamo->EQUI_ID = $equipo;
        $prestamo->PRES_FECHAINI = \Carbon\Carbon::now()->toDateTimeString(); 
        $prestamo->PRES_CREADOPOR = auth()->user()->username;

         $prestamo->save();

        //Cambia el estado del equipo, una vez es prestado
        $equipo = Equipo::findOrFail($equipo);
        $equipo->ESTA_ID = 4;
        $equipo->EQUI_MODIFICADOPOR = auth()->user()->username;
        $equipo->save();



   		Session::flash('modal-success', 'Equipo ' . $equipo->EQUI_ID . ' ha sido prestado exitosamente!');
        return redirect()->back();


	}


        public function finalizarPrestamo($PRES_ID, $showMsg=true)
    {
        $prestamo = Prestamo::findOrFail($PRES_ID);
        $idquipo= $prestamo -> EQUI_ID;

            $prestamo ->PRES_FECHAFIN = \Carbon\Carbon::now()->toDateTimeString();  
            $prestamo->PRES_MODIFICADOPOR = auth()->user()->username;
            $prestamo->save();       

             //Cambia el estado del equipo, una vez es liberado
            $equipo = Equipo::findOrFail($idquipo);
            $equipo->ESTA_ID = 3;
            $equipo->EQUI_MODIFICADOPOR = auth()->user()->username;
            $equipo->save();

                // redirecciona al index de controlador
        if($showMsg){
            Session::flash('modal-success', 'Prestamo #'.$prestamo->PRES_ID.' ha finalizado exitosamente!');
            return redirect()->to('consultaPrestamos');
        }
    }
}

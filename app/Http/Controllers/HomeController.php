<?php

namespace reservas\Http\Controllers;

use reservas\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const EQUIPOKEY = 'EQUI_ID';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sedes = \reservas\Sede::getSedes();
        $salas = \reservas\Sala::getSalas();


        //Se crea un array con las sedes disponibles
        $equipos = \reservas\Equipo::orderBy(HomeController::EQUIPOKEY)
                        ->select(HomeController::EQUIPOKEY, 'EQUI_DESCRIPCION', 'SALA_ID')
                        ->get();


        return view('home', compact('sedes', 'salas', 'equipos'));
    }

    public function calreservas()
    {
        $sedes = \reservas\Sede::getSedes();
        $salas = \reservas\Sala::getSalas();


        //Se crea un array con las sedes disponibles
        $equipos = \reservas\Equipo::orderBy(HomeController::EQUIPOKEY)
                        ->select(HomeController::EQUIPOKEY, 'EQUI_DESCRIPCION', 'SALA_ID')
                        ->get();


        return view('/calreservas', compact('sedes', 'salas', 'equipos'));
    }
}

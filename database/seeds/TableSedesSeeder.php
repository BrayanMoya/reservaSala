<?php

use Illuminate\Database\Seeder;

class TableSedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

       $sede = new \reservas\Sede;
       $sede->SEDE_DESCRIPCION = 'SEDE CENTRAL';
       $sede->SEDE_DIRECCION =  'Avenida 6 Norte # 28N - 102';
       $sede->SEDE_OBSERVACIONES =  'UBICACIÓN CENTRAL DE LA INSTITUCIÓN UNIVERSITARIA ANTONIO JOSÉ CAMACHO.';
       $sede->SEDE_CREADOPOR =  'USER_PRUEBA';
       $sede->save();

       $sede = new \reservas\Sede;
       $sede->SEDE_DESCRIPCION = 'SEDE ESTACIÓN 1';
       $sede->SEDE_DIRECCION =  'Av. 3A # 23CN - 84';
       $sede->SEDE_OBSERVACIONES =  'SEDE IDIOMAS Y SISTEMAS';
       $sede->SEDE_CREADOPOR =  'USER_PRUEBA';
       $sede->save();

       $sede = new \reservas\Sede;
       $sede->SEDE_DESCRIPCION = 'SEDE SUR';
       $sede->SEDE_DIRECCION =  'Calle 25 No. 127-220';
       $sede->SEDE_OBSERVACIONES =  'Ubicación Sur UNIAJC';
       $sede->SEDE_CREADOPOR =  'USER_PRUEBA';
       $sede->save();

	}

}

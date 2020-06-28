<?php

use Illuminate\Database\Seeder;

class TableFestivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    Public function run() {

          $feriados = [
            [ 'FEST_FECHA' => '2020-01-01', 'FEST_DESCRIPCION' => 'Año Nuevo' ],
            [ 'FEST_FECHA' => '2020-01-06', 'FEST_DESCRIPCION' => 'Día de los Reyes Magos' ],
            [ 'FEST_FECHA' => '2020-03-23', 'FEST_DESCRIPCION' => 'Día de San José' ],
            [ 'FEST_FECHA' => '2020-04-09', 'FEST_DESCRIPCION' => 'Jueves Santo' ],
            [ 'FEST_FECHA' => '2020-04-10', 'FEST_DESCRIPCION' => 'Viernes Santo' ],
            [ 'FEST_FECHA' => '2020-05-01', 'FEST_DESCRIPCION' => 'Día del Trabajo' ],
            [ 'FEST_FECHA' => '2020-05-25', 'FEST_DESCRIPCION' => 'Día de la Ascensión' ],
            [ 'FEST_FECHA' => '2020-06-15', 'FEST_DESCRIPCION' => 'Corpus Christi' ],
            [ 'FEST_FECHA' => '2020-06-22', 'FEST_DESCRIPCION' => 'Sagrado Corazón' ],
            [ 'FEST_FECHA' => '2020-06-29', 'FEST_DESCRIPCION' => 'San Pedro y San Pablo' ],
            [ 'FEST_FECHA' => '2020-07-20', 'FEST_DESCRIPCION' => 'Día de la Independencia' ],
            [ 'FEST_FECHA' => '2020-08-07', 'FEST_DESCRIPCION' => 'Batalla de Boyacá' ],
            [ 'FEST_FECHA' => '2020-08-17', 'FEST_DESCRIPCION' => 'La asunción de la Virgen' ],
            [ 'FEST_FECHA' => '2020-10-12', 'FEST_DESCRIPCION' => 'Día de la Raza' ],
            [ 'FEST_FECHA' => '2020-11-02', 'FEST_DESCRIPCION' => 'Todos los Santos' ],
            [ 'FEST_FECHA' => '2020-11-16', 'FEST_DESCRIPCION' => 'Independencia de Cartagena' ],
            [ 'FEST_FECHA' => '2020-12-08', 'FEST_DESCRIPCION' => 'Día de la Inmaculada Concepción' ],
            [ 'FEST_FECHA' => '2020-12-25', 'FEST_DESCRIPCION' => 'Día de Navidad' ],
          ];

          foreach ($feriados as $feriado) {
                    \reservas\Festivo::create(
                      $feriado + [ 'FEST_CREADOPOR' => 'SYSTEM' ]
                    );
          }

	}
}

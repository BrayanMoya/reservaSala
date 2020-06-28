<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservas extends Migration
{

  private $nomTabla = 'RESERVAS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $commentTabla = 'RESERVAS: contiene todas la reservas cargadas en el sistema, completas e individuales.';

        Schema::create('RESERVAS', function (Blueprint $table) {

            $table->increments('RESE_ID')
                ->comment = "Valor autonumerico, llave primaria de la tabla RESERVAS.";

            $table->integer('SALA_ID')->unsigned()
                ->comment = 'Campo foráneo de la tabla SALAS.';

            $table->string('RESE_TITULO')->nullable()
                ->comment = "titulo de la reserva";

            $table->datetime('RESE_FECHAINI')
                ->comment = "fecha inicio de la reserva";

            $table->datetime('RESE_FECHAFIN')->nullable()
                ->comment = "fecha fin de la reserva";

            $table->string('RESE_PERIODO')->nullable()
                ->comment = "Periodo academico de la reserva";

            $table->string('RESE_CODFRANJA')->nullable()
                ->comment = "Código de Franja horaria de la reserva";

            $table->string('RESE_NOMFRANJA')->nullable()
                ->comment = "Nombre de Franja horaria de la reserva";

            $table->string('RESE_CODFACULTAD')->nullable()
                ->comment = "Código de Facultad de la reserva";

            $table->string('RESE_NOMFACULTAD')->nullable()
                ->comment = "Facultad de la reserva";

            $table->string('RESE_CODPROGRAMA')->nullable()
                ->comment = "Código de Programa de la reserva";

            $table->string('RESE_NOMPROGRAMA')->nullable()
                ->comment = "Programa de la reserva";

            $table->string('RESE_CODGRUPO')->nullable()
                ->comment = "Código Grupo de la reserva";

            $table->string('RESE_NOMGRUPO')->nullable()
                ->comment = "Grupo de la reserva";

            $table->string('RESE_CODMATERIA')->nullable()
                ->comment = "Código Materia o asignatura de la reserva";

            $table->string('RESE_NOMMATERIA')->nullable()
                ->comment = "Materia o asignatura de la reserva";

            $table->boolean('RESE_TODOELDIA')->nullable()
                ->comment = "indica si la reunion es todo el día";

            /*$table->string('RESE_COLOR')->nullable()
                ->comment = "color de la reserva.";*/


            $table->integer('EQUI_ID')->unsigned()->nullable()
                ->comment = 'Campo foráneo de la tabla EQUIPOS.';

              //indicaciones si la reserva la realizo un usuario local o usuario uniajc
              $table->boolean('RESE_CREADAPORUNIAJC')->nullable()
                  ->comment = "indica si la reserva es creado por un usuario uniajc true o false";

                //Traza user uniajc academusoft
               $table->string('RESE_USUARIOUNIAJC')->nullable()
                   ->comment('Usuario  en sesion uniajc');
               $table->string('RESE_EMAILUSERUNIAJC')->nullable()
                   ->comment('Email del usuario uniajc .');
              $table->string('RESE_IDENTIFICACIONUNIAJC')->nullable()
                 ->comment('Identificación del usuario uniajc .');
              $table->string('RESE_NOMBREUSERUNIAJC')->nullable()
                ->comment('Primer Nombre del usuario uniajc .');
              $table->string('RESE_APELLIDOUSERNUNIAJC')->nullable()
                 ->comment('Primer Apellido del usuario uniajc .');


             //Traza
            $table->string('RESE_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('RESE_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('RESE_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('RESE_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('RESE_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('RESE_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');


            //Relaciones
            $table->foreign('SALA_ID')
                    ->references('SALA_ID')->on('SALAS')
                    ->onDelete('cascade');



        });

        if(env('DB_CONNECTION') == 'pgsql')
            DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA').".\"".$this->nomTabla."\" IS '".$commentTabla."'");
        elseif(env('DB_CONNECTION') == 'mysql')
            DB::statement("ALTER TABLE ".$this->nomTabla." COMMENT = '".$commentTabla."'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('RESERVAS');
    }

}

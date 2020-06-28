<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSala extends Migration
{

  private $nomTabla = 'SALAS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $commentTabla = 'SALAS: contiene las salas de sistema asociadas a cada sede.';
        //
        Schema::create('SALAS', function (Blueprint $table) {

            $table->increments('SALA_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla SALAS.";
            $table->string('SALA_DESCRIPCION', 300)
            ->comment = "Descripción corta de la Sala.";
            $table->integer('SALA_CAPACIDAD')
            ->comment = "Valor autonumerico, Cantidad de equipos que tiene la sala.";
            $table->string('SALA_FOTOSALA', 500)
            ->comment = "Imagen general de la sala.";
            $table->string('SALA_FOTOCROQUIS', 500)
            ->comment = "Imagen tipo Croquis de la sala.";
            $table->string('SALA_OBSERVACIONES', 300)
            ->comment = "Observaciones de la instalación.";
            $table->integer('SALA_PRESTAMO')
            ->comment = "Valor autonumerico, que indica si la sala esta habilitada para prestamos de equipos.";
            $table->integer('ESTA_ID')->unsigned()
            ->comment = "Relación con los ESTADOS del sistema";
            $table->integer('SEDE_ID')->unsigned()
            ->comment = "Relación con las SEDES de la institución";



             //Traza
            $table->string('SALA_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('SALA_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('SALA_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('SALA_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('SALA_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('SALA_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');


          //Relaciones
            $table->foreign('ESTA_ID')
                  ->references('ESTA_ID')->on('ESTADOS')
                  ->onDelete('cascade');


            $table->foreign('SEDE_ID')
                  ->references('SEDE_ID')->on('SEDES')
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
        Schema::drop('SALAS');
    }
}

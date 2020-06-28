<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEquipos extends Migration
{
  private $nomTabla = 'EQUIPOS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $commentTabla = 'EQUIPOS: contiene los equipos de computo asociados a cada sala.';

        //
        Schema::create('EQUIPOS', function (Blueprint $table) {

            $table->increments('EQUI_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla EQUIPOS.";
            $table->string('EQUI_DESCRIPCION', 300)
            ->comment = "Descripción corta del equipo.";
            $table->string('EQUI_OBSERVACIONES', 300)
            ->comment = "Observaciones del equipo.";
            $table->integer('SALA_ID')->unsigned()
            ->comment = "Campo foráneo de la tabla SALAS.";
            $table->integer('ESTA_ID')->unsigned()
            ->comment = "Campo foráneo de la tabla ESTADOS.";

             //Traza
            $table->string('EQUI_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('EQUI_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('EQUI_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('EQUI_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('EQUI_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('EQUI_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');


           //Relaciones
            $table->foreign('ESTA_ID')
                  ->references('ESTA_ID')->on('ESTADOS')
                  ->onDelete('cascade');


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
        Schema::drop('EQUIPOS');
    }
}

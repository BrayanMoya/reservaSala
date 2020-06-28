<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoestado extends Migration
{
  private $nomTabla = 'TIPOESTADOS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $commentTabla = 'TIPOESTADOS: contiene todos los tipo de estados del sistema.';

        Schema::create('TIPOESTADOS', function (Blueprint $table) {

            $table->increments('TIES_ID')
                ->comment = "Valor autonumerico, llave primaria de la tabla TIPOESTADOS.";

            $table->string('TIES_DESCRIPCION', 300)
                ->comment = "Descripcion del tipo estado que puede tener, una sala, equipo u recursos";

            $table->string('TIES_OBSERVACIONES', 300)
                ->comment = "Observaciones varias del tipo de estado";


                       //Traza
            $table->string('TIES_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('TIES_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('TIES_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('TIES_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('TIES_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('TIES_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');

           // $table->timestamps();

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
        Schema::drop('TIPOESTADOS');
    }
}

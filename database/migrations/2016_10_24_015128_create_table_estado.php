<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEstado extends Migration
{

  private $nomTabla = 'ESTADOS';
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
      $commentTabla = 'ESTADOS: contiene todos los estados del sistema.';

        Schema::create('ESTADOS', function (Blueprint $table) {

            $table->increments('ESTA_ID')
                ->comment = "Valor autonumerico, llave primaria de la tabla ESTADOS.";

             $table->string('ESTA_DESCRIPCION', 300)
                ->comment = "Descripcion del estado que puede tener, una sala, equipo u recursos";

            $table->integer('TIES_ID')->unsigned()
                ->comment = "Campo foráneo de la tabla TIPOESTADOS.";


             //Traza
            $table->string('ESTA_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('ESTA_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('ESTA_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('ESTA_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('ESTA_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('ESTA_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');


          //Relaciones

            $table->foreign('TIES_ID')
                  ->references('TIES_ID')->on('TIPOESTADOS')
                  ->onDelete('cascade');

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
        Schema::drop('ESTADOS');
    }
}

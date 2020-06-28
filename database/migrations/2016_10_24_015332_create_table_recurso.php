<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecurso extends Migration
{

  private $nomTabla = 'RECURSOS';
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {

     $commentTabla = 'RECURSOS: contiene todos los recursos. Software y/o Hardware.';

        Schema::create('RECURSOS', function (Blueprint $table) {

            $table->increments('RECU_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla RECURSOS.";
            $table->string('RECU_DESCRIPCION', 300)
            ->comment = "Descripción corta del recurso.";
            $table->string('RECU_VERSION', 50)
            ->comment = "Versión o tipo del Recurso.";
            $table->string('RECU_OBSERVACIONES', 300)
            ->comment = "Observaciones del recurso.";



            //Traza
            $table->string('RECU_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('RECU_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('RECU_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('RECU_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('RECU_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('RECU_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');


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
        Schema::drop('RECURSOS');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSede extends Migration
{
  private $nomTabla = 'SEDES';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {

     $commentTabla = 'SEDES: contiene las sedes de la Institución.';

        Schema::create('SEDES', function (Blueprint $table) {

            $table->increments('SEDE_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla SEDES.";
            $table->string('SEDE_DESCRIPCION', 300)
            ->comment = "Descripción corta de la SEDE que puede tener.";
            $table->string('SEDE_DIRECCION', 300)
            ->comment = "Dirección y/o ubicación de la SEDE.";
            $table->string('SEDE_OBSERVACIONES', 300)
            ->comment = "Observaciones  de la SEDE que puede tener.";


            //Traza
            $table->string('SEDE_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('SEDE_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('SEDE_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('SEDE_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('SEDE_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('SEDE_FECHAELIMINADO')->nullable()
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
        Schema::drop('SEDES');
    }
}

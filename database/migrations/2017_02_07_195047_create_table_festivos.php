<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFestivos extends Migration
{

  private $nomTabla = 'FESTIVOS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $commentTabla = 'FESTIVOS: contiene los días festivos del país.';
        //
        Schema::create('FESTIVOS', function (Blueprint $table) {

            $table->increments('FEST_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla FESTIVOS.";
            $table->date('FEST_FECHA')
            ->comment = "Valor fecha, indica el día festivo.";
            $table->string('FEST_DESCRIPCION', 300)->nullable()
            ->comment = "Descripción del día festivo.";

             //Traza
            $table->string('FEST_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('FEST_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('FEST_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('FEST_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('FEST_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('FEST_FECHAELIMINADO')->nullable()
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
        Schema::drop('FESTIVOS');
    }
}

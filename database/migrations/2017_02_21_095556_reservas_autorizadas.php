<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservasAutorizadas extends Migration
{
  private $nomTabla = 'RESERVAS_AUTORIZADAS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $commentTabla = 'RESERVAS_AUTORIZADAS: contiene la relación entre las reservas y la autorizaciones cargadas.';
        //
        Schema::create('RESERVAS_AUTORIZADAS', function (Blueprint $table) {

            $table->increments('REAU_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla RESERVAS_AUTORIZADAS.";
            $table->integer('AUTO_ID')->unsigned()
            ->comment = "Campo foráneo de la tabla AUTORIZACIONES.";
            $table->integer('RESE_ID')->unsigned()
            ->comment = "Campo foráneo de la tabla RESERVAS.";


            //Relaciones
            $table->foreign('AUTO_ID')
                  ->references('AUTO_ID')->on('AUTORIZACIONES')
                  ->onDelete('cascade');


            $table->foreign('RESE_ID')
                  ->references('RESE_ID')->on('RESERVAS')
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
        Schema::drop('RESERVAS_AUTORIZADAS');
    }

}

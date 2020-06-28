<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecursoSalas extends Migration
{

  private $nomTabla = 'RECURSOSALAS';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $commentTabla = 'RECURSOSALAS: contiene todas la relación entre las recursos y la salas.';
        //
        Schema::create('RECURSOSALAS', function (Blueprint $table) {

         $table->increments('RESA_ID')
         ->comment = "Valor autonumerico, llave primaria de la tabla RECURSOSALAS.";
         $table->integer('SALA_ID')->unsigned()->nullable()
         ->comment = "Campo foráneo de la tabla SALAS.";
         $table->integer('RECU_ID')->unsigned()->nullable()
         ->comment = "Campo foráneo de la tabla RECURSOS.";

            $table->foreign('SALA_ID')
                  ->references('SALA_ID')->on('SALAS')
                  ->onDelete('cascade');

            $table->foreign('RECU_ID')
                  ->references('RECU_ID')->on('RECURSOS')
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
         Schema::drop('RECURSOSALAS');
    }
}

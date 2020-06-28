<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAutorizacion extends Migration
{

  private $nomTabla = 'AUTORIZACIONES';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $commentTabla = 'AUTORIZACIONES: contiene todas las autorizaciones creadas.';
        //
        Schema::create('AUTORIZACIONES', function (Blueprint $table) {

            $table->increments('AUTO_ID')
            ->comment = "Valor autonumerico, llave primaria de la tabla AUTORIZACIONES.";
            $table->datetime('AUTO_FECHASOLICITUD')
            ->comment = "Valor fecha. Fecha de solicitud.";
            $table->datetime('AUTO_FECHAAPROBACION')->nullable()
            ->comment = "Valor fecha. Fecha de Aprobación.";
            $table->datetime('AUTO_FECHACANCELACION')->nullable()
            ->comment = "Valor fecha. Fecha de cancelación, ya sea anulada o rechazada.";
            $table->unsignedInteger('ESTA_ID')
            ->comment = "Campo foráneo de la tabla ESTADOS.";
            $table->string('AUTO_OBSERVACIONES', 300)->nullable()
            ->comment = "Observaciones o comentarios de la autorización cuando se realizar una acción.";

            $table->foreign('ESTA_ID')
                  ->references('ESTA_ID')->on('ESTADOS')
                  ->onDelete('cascade');

                  $table->string('AUTO_USERAUTORIZADOR')->nullable()
                      ->comment('Usuario que creó la autorizacion iniciado desde uniajc.');

             //Traza
            $table->string('AUTO_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('AUTO_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('AUTO_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('AUTO_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('AUTO_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('AUTO_FECHAELIMINADO')->nullable()
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
        Schema::drop('AUTORIZACIONES');
    }

}

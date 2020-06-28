<?php

namespace reservas;

use reservas\ModelWithSoftDeletes;

class Autorizacion extends ModelWithSoftDeletes
{
	const AUTOKEY = 'AUTO_ID';
	const ESTAKEY = 'ESTA_ID';
    protected $table = 'AUTORIZACIONES';
    protected $primaryKey = Autorizacion::AUTOKEY;


	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'AUTO_FECHACREADO';
	const UPDATED_AT = 'AUTO_FECHAMODIFICADO';
	const DELETED_AT = 'AUTO_FECHAELIMINADO';
	protected $dates = ['AUTO_FECHAELIMINADO'];

	protected $fillable = [
		'AUTO_FECHASOLICITUD',
		'AUTO_FECHAAPROBACION',
		'AUTO_FECHACANCELACION',
		Autorizacion::ESTAKEY,
		'UNID_ID',
		'PEGE_ID',
		'GRUP_ID',
		'MATE_CODIGOMATERIA', //hacia abajo todos son nuevos campos
		'AUTO_USERAUTORIZADOR'
	];

    protected $hidden = [
      	"AUTO_ID"
    ];

	/*
	 * Las reservas que están autorizadas.
	 */
	public function reservas()
	{
		$foreingKey = Autorizacion::AUTOKEY;
		$otherKey   = 'RESE_ID';
		return $this->belongsToMany(Reserva::class, 'RESERVAS_AUTORIZADAS', $foreingKey,  $otherKey);
	}

	//Una autorización tiene un Estado
	public function estado()
	{
		$foreingKey = Autorizacion::ESTAKEY;
		return $this->belongsTo(Estado::class, $foreingKey);
	}

	//Una autorización tiene una materia
	public function materia()
	{
		$foreingKey = 'MATE_CODIGOMATERIA';
		return $this->belongsTo(Materia::class, $foreingKey);
	}

    //Scope Reservas aprobadas
    public function scopeAprobadas($query)
    {
        return $query->where(Autorizacion::ESTAKEY, Estado::RESERVA_APROBADA);
    }
    //Scope Reservas pendientes por aprobar
    public function scopePendientesAprobar($query)
    {
        return $query->where(Autorizacion::ESTAKEY, Estado::RESERVA_PENDIENTE);
    }
}

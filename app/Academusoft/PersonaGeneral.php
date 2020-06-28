<?php

namespace reservas\Academusoft;

use Illuminate\Database\Eloquent\Model;

class PersonaGeneral extends Model
{
	//Nombre de la tabla en la base de datos
	const PEGEKEY = 'PEGE_ID';
	protected $table = 'PERSONAGENERAL';
    protected $primaryKey = PersonaGeneral::PEGEKEY;
	
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'PEGE_fechacreado';
	const UPDATED_AT = 'PEGE_fechamodificado';
	
	protected $fillable = [
		PersonaGeneral::PEGEKEY,
		'PEGE_DOCUMENTOIDENTIDAD',
	];

	public function personaNaturalGeneral()
	{
		$foreingKey = PersonaGeneral::PEGEKEY;
		return $this->belongsTo(PersonaNaturalGeneral::class, $foreingKey);
	}
}

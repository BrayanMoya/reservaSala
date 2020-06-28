<?php

namespace reservas\Academusoft;

use Illuminate\Database\Eloquent\Model;

class PersonaNaturalGeneral extends Model
{
	//Nombre de la tabla en la base de datos
	const PEGEKEY = 'PEGE_ID';
	protected $table = 'PERSONANATURALGENERAL';
    protected $primaryKey = PersonaNaturalGeneral::PEGEKEY;
	
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'PENG_fechacreado';
	const UPDATED_AT = 'PENG_fechamodificado';
					
	protected $fillable = [
		PersonaNaturalGeneral::PEGEKEY,
		'PENG_PRIMERAPELLIDO',
		'PENG_SEGUNDOAPELLIDO',
		'PENG_PRIMERNOMBRE',
		'PENG_SEGUNDONOMBRE',
		'PENG_SEXO',
	];

	public function personaGeneral()
	{
		$foreingKey = PersonaNaturalGeneral::PEGEKEY;
		return $this->belongsTo(PersonaGeneral::class, $foreingKey);
	}
}

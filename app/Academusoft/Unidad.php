<?php

namespace reservas\Academusoft;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
	//Nombre de la tabla en la base de datos
	const UNIDKEY = 'UNID_ID';
	protected $table = 'UNIDADES';
    protected $primaryKey = Unidad::UNIDKEY;
	
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'UNID_fechacreado';
	const UPDATED_AT = 'UNID_fechamodificado';

	protected $fillable = [
		Unidad::UNIDKEY,
		'UNID_NOMBRE',
		'UNID_CODIGO',
	];

	public function materias()
	{
		$foreingKey = Unidad::UNIDKEY;
		return $this->hasMany(Materia::class, $foreingKey);
	}

}

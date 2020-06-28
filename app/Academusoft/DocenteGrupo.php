<?php

namespace reservas\Academusoft;

use Illuminate\Database\Eloquent\Model;

class DocenteGrupo extends Model
{
	//Nombre de la tabla en la base de datos
	const DOUNKEY = 'DOUN_ID';
	protected $table = 'DOCENTESGRUPOS';
    protected $primaryKey = DocenteGrupo::DOUNKEY;
	
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'DOGR_fechacreado';
	const UPDATED_AT = 'DOGR_fechamodificado';

	protected $fillable = [
		DocenteGrupo::DOUNKEY,
		'GRUP_ID',
	];

	public function grupo()
	{
		$foreingKey = 'GRUP_ID';
		return $this->belongsTo(Grupo::class, $foreingKey);
	}

	public function docenteUnidad()
	{
		$foreingKey = DocenteGrupo::DOUNKEY;
		return $this->belongsTo(DocenteUnidad::class, $foreingKey);
	}
}

<?php

namespace reservas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametroGeneral extends ModelWithSoftDeletes
{
	
	//Nombre de la tabla en la base de datos
	protected $table = 'PARAMETROSGENERALES';
	protected $primaryKey = 'PAGE_ID';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'PAGE_FECHACREADO';
	const UPDATED_AT = 'PAGE_FECHAMODIFICADO';
	const DELETED_AT = 'PAGE_FECHAELIMINADO';
	protected $dates = ['PAGE_FECHACREADO', 'PAGE_FECHAMODIFICADO', 'PAGE_FECHAELIMINADO'];

	protected $fillable = [
		'PAGE_DESCRIPCION',
		'PAGE_VALOR',
		'PAGE_OBSERVACIONES',
	];

}

<?php

namespace reservas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{

	const EQUIKEY = 'EQUI_ID';
	const SALAKEY = 'SALA_ID';

    protected $table = 'EQUIPOS';
    protected $primaryKey = Equipo::EQUIKEY;
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'EQUI_FECHACREADO';
	const UPDATED_AT = 'EQUI_FECHAMODIFICADO';
	use SoftDeletes;
	const DELETED_AT = 'EQUI_FECHAELIMINADO';
	protected $dates = ['EQUI_FECHAELIMINADO'];
	
	protected $fillable = [
		'EQUI_DESCRIPCION',
		'EQUI_OBSERVACIONES',
		Equipo::SALAKEY,
		'ESTA_ID',
		'EQUI_CREADOPOR'
	];

    //Una Equipo se encuentra en una Sala
	public function sala()
	{
		$foreingKey = Equipo::SALAKEY;
		return $this->belongsTo(Sala::class, $foreingKey);
	}

    //Una Equipo tiene muchas reservas
	public function reservas()
	{
		$foreingKey = Equipo::SALAKEY;
		return $this->hasMany(Reservas::class, $foreingKey);
	}

	//Un Equipo tiene un Estado
	public function estado()
	{
		$foreingKey = 'ESTA_ID';
		return $this->belongsTo(Estado::class, $foreingKey);
	}
	
	public function prestamo()
	{
		$foreingKey = Equipo::EQUIKEY;
		return $this->hasMany(Prestamo::class, $foreingKey);
	}

	public static function getEquipos()
    {
        return self::with('sala')->orderBy(Equipo::EQUIKEY)
                ->select([
                	Equipo::EQUIKEY,
                	'EQUI_DESCRIPCION',							
					'EQUI_OBSERVACIONES',							
					Equipo::SALAKEY,							
                ])
                ->get();
                        
    }

}

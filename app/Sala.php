<?php
namespace reservas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
	//Nombre de la tabla en la base de datos
	protected $table = 'SALAS';
    protected $primaryKey = 'SALA_ID';
	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'SALA_FECHACREADO';
	const UPDATED_AT = 'SALA_FECHAMODIFICADO';
	use SoftDeletes;
	const DELETED_AT = 'SALA_FECHAELIMINADO';
	protected $dates = ['SALA_FECHAELIMINADO'];

	protected $appends = ['equipos_disp'];

	protected $fillable = [
		'SALA_DESCRIPCION',
		'SALA_CAPACIDAD',
		'SALA_FOTOSALA',
		'SALA_FOTOCROQUIS',
		'SALA_OBSERVACIONES',
		'ESTA_ID',
		'SEDE_ID',
		'RECU_ID',
		'SALA_CREADOPOR',
		'SALA_PRESTAMO',
	];
    protected $hidden = [
      	//"SALA_ID"
    ];


	//Una Sala se encuentra en una Sede
	public function sede()
	{
		$foreingKey = 'SEDE_ID';
		return $this->belongsTo(Sede::class, $foreingKey);
	}

	//Una Sala tiene muchos equipos
	public function equipos()
	{
		$foreingKey = 'SALA_ID';
		return $this->hasMany(Equipo::class, $foreingKey);
	}

	//Una Sala tiene muchas reservas
	public function reservas()
	{
		$foreingKey = 'SALA_ID';
		return $this->hasMany(Reserva::class, $foreingKey);
	}

	//Una Sala tiene un Estado
	public function estado()
	{
		$foreingKey = 'ESTA_ID';
		return $this->belongsTo(Estado::class, $foreingKey);
	}

		/*
	 * Muchos a muchos...
	 */
	public function recursos()
	{
		$foreingKey = 'SALA_ID';
		$otherKey   = 'RECU_ID';
		return $this->belongsToMany(Recurso::class, 'RECURSOSALAS', $foreingKey,  $otherKey);
	}

    /**
     * Retorna un array de las salas existentes. Se utiliza en Form::select
     *
     * @param  null
     * @return Array
     */
    public static function getSalas()
    {
        return self::with('recursos','equipos')->orderBy('SALA_ID')
                        ->select([
                        	'SALA_ID',
                        	'SALA_DESCRIPCION',
							'SALA_CAPACIDAD',
							'SALA_OBSERVACIONES',
							'SEDE_ID',
							'ESTA_ID',
							'SALA_PRESTAMO',
                        ])
                        ->get();               
    } 
    


    /**
     * Retorna la cantidad de equipos disponibles en la sala.
     *
     * @param  null
     * @return integer
     */
    public function getEquiposDispAttribute()
    {
    	  return \DB::table('EQUIPOS')
                            ->select('ESTADOS.*')
                            ->where('EQUIPOS.SALA_ID','=',$this->SALA_ID)
                            ->where('EQUIPOS.ESTA_ID','=',3) //Estado 3 Disponibles
                            ->where('EQUIPOS.EQUI_FECHAELIMINADO','=',null)
                            ->count();
	}


	
}

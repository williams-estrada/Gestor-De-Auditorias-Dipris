<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'usuario',
        'correo_electronico',
        'tipo_usuario',
        'contraseña',
    ];
    //sobreescritura de las convenciones
    protected $table = 'usuarios';
    /**
    * The name of the "created at" column.
    * @var string
    */
    const CREATED_AT = 'fecha_creado';
    /**
    * The name of the "updated at" column.
    * @var string
    */
    const UPDATED_AT = 'fecha_modificado';

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class,"id","usuario_id");
    }

    public function getJWTIdentifier()
    {
    	return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
    	return [];
    }
}

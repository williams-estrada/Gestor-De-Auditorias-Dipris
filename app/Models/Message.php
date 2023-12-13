<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'contenido',
        'user_id',
        'to_user_id'
    ];

    public function user(){
        return $this->belongsTo(Usuarios::class);
    }
}

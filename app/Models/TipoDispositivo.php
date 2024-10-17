<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDispositivo extends Model
{
    use HasFactory;
    protected $table = 'tipoDispositivos';
    protected $primaryKey = 'idTipoDispositivo';
    protected $fillable = ['idTipoDispositivo', 'nombre'];

    public function dispositivo(){
        return $this->hasMany('App\Models\Dispositivo', 'tipoDispositivo');
    }

    
}

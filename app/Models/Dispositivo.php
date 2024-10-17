<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;
    protected $table = 'dispositivos';
    protected $primaryKey = 'idDispositivos';
    protected $fillable = ['idDispositivos', 'tipoDispositivo', 'modeloDispositivo',
    'cantidad','marca'];

    public function detallePrestamoDispositvo(){
        return $this->hasMany('App\Models\DetallePresDispositivo', 'dispositivosPrestado');
    }

    public function tipoDispositivo()
    {
        return $this->belongsTo('App\Models\TipoDispositivo', 'idTipoDispositivo');
    }
}

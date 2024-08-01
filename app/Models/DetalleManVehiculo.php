<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleManVehiculo extends Model
{
    use HasFactory;
    protected $table='detallemantenimientovehiculos';
    protected $primaryKey = 'idDetalleMantenimiento';
    protected $fillable=['idDetalleMantenimiento', 'mantenimiento', 'observaciones'];

    public function mantenimiento(){
        return $this->belongsTo('App\Models\Mantenimiento', 'idMantenimiento');
    }

}

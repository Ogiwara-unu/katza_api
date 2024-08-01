<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos';
    protected $primaryKey = 'idMantenimiento';
    protected $fillable = [
        'idMantenimiento',
        'idVehiculo', 
        'tipoMantenimiento', 
        'empleadoEncargado', 
        'fechaMantenimiento', 
        'duracionMantenimiento'
    ];

    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Vehiculo', 'placaVehiculo');
    }

    public function tipoMantenimiento()
    {
        return $this->belongsTo('App\Models\TipoMantenimiento', 'idTipoMantenimiento');
    }

    public function empleadoEncargado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }


    public function detalleManVehiculos()
    {
        return $this->hasMany('App\Models\DetalleManVehiculo', 'mantenimiento');

    }
}
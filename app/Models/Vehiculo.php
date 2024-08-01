<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table='vehiculos';
    protected $primaryKey = 'placaVehiculo';
    protected $fillable=['placaVehiculo', 'modelo', 'marca'];

    public function mantenimientos(){
        return $this->hasMany('App\Models\Mantenimiento', 'idVehiculo');
    }

    public function detallePrestamoVehiculos(){
        return $this->hasMany('App\Models\DetallePresVehiculo', 'VehiculoPrestado');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePresVehiculo extends Model
{
    use HasFactory;
    protected $table = 'detallePrestamoVehiculos';
    protected $primaryKey = 'idDetallePrestamo';
    protected $fillable = ['idDetallePrestamo', 'prestamo', 'observaciones',
    'kmInicial','kmFinal','vehiculoPrestado','fechaDevolucion'];

    public function prestamo()
    {
        return $this->belongsTo('App\Models\Prestamo', 'idPrestamo');
    }

    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Vehiculo', 'placaVehiculo');
    }

}

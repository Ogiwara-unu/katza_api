<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePresDispositivo extends Model
{
    use HasFactory;
    protected $table = 'detallePrestamoDispositivo';
    protected $primaryKey = 'idDetallePrestamoDispositivo';
    protected $fillable = ['idDetallePrestamoDispositivo', 'observaciones', 'prestamo',
    'dispositivosPrestado','fechaDevolucion'];

    public function prestamo()
    {
        return $this->belongsTo('App\Models\Prestamo', 'idPrestamo');
    }

    public function dispositivo()
    {
        return $this->belongsTo('App\Models\Dispositivo', 'placaVehiculo');
    }

}

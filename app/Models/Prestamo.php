<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $table = 'prestamos';
    protected $primaryKey = 'idPrestamo';
    protected $fillable = ['idPrestamo', 'empleadoEmisor', 'empleadoReceptor',
    'estadoPrestamo','fechaPrestamo','fechaLimite'];

     
     public function empleadoEmisor()
     {
         return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
     }
 
     
     public function empleadoReceptor()
     {
         return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
     }

    public function detallePrestamos()
    {
        return $this->hasMany('App\Models\DetallePresVehiculo', 'prestamo');
    }

}

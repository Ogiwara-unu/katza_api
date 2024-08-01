<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table='empleados';
    protected $primaryKey = 'idEmpleado';
    protected $fillable=['idEmpleado', 'nombre', 'apellidos', 'correo', 'telefono','departamento','fechaContratacion'];

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento', 'idDepartamento');
    }

}

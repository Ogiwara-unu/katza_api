<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'idDepartamento';
    protected $fillable = ['idDepartamento', 'nombre', 'descripcion'];

    public function empleados()
    {
        return $this->hasMany('App\Models\Empleado', 'departamento');

    }
}


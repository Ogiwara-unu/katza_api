<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRepuesto extends Model
{
    use HasFactory;
    protected $table = 'tipoRepuestos';
    protected $primaryKey = 'idtipoRepuesto';
    protected $fillable = ['idtipoRepuesto', 'nombre'];

    public function repuestosInventario()
    {
        return $this->hasMany('App\Models\Repuesto','idtipoRepuesto');
    }
            
}

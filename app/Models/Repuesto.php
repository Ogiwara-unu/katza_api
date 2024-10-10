<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;
    protected $table = 'repuestos';
    protected $primaryKey = 'idRepuesto';
    protected $fillable = ['idRepuesto','cantidadInv','tipoRepuesto', 'modeloRepuesto'];

    public function tipoRepuesto()
    {
        return $this->belongsTo('App\Models\TipoRepuesto', 'idtipoRepuesto');
    }
    
    public function modeloRepuesto()
    {
        return $this->belongsTo('App\Models\ModeloRepuesto', 'idModeloRepuesto');
    }
}

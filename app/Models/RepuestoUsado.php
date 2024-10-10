<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepuestoUsado extends Model
{
    use HasFactory;
    protected $table = 'repuestosUsados';
    protected $primaryKey = 'idRepuestosUsados';
    protected $fillable = ['idRepuestosUsados','repuesto', 'cantidadUsada', 'mantenimiento'];

    public function repuesto(){
        return $this->belongsTo('App\Models\Repuesto', 'idRepuesto');
    }
    
    public function mantenimiento(){
        return $this->belongsTo('App\Models\Mantenimiento', 'idMantenimiento');
    }
    
}

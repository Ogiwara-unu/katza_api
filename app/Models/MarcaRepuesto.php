<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcaRepuesto extends Model
{
    use HasFactory;
    protected $table = 'marcaRepuestos';
    protected $primaryKey = 'idMarcaRepuesto';
    protected $fillable = ['idMarcaRepuesto','nombre'];

    public function modelos(){
        return $this->hasMany('App\Models\ModeloRpuesto','idMarcaRepuesto');
    }

}

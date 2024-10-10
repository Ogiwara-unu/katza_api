<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloRepuesto extends Model
{
    use HasFactory;
    protected $table = 'modeloRepuestos';
    protected $primaryKey = 'idModeloRepuesto';
    protected $fillable = ['idModeloRepuesto','modelo','marca'];

    public function marcaRepuesto()
    {
        return $this->belongsTo('App\Models\MarcaRepuesto', 'idMarcaRepuesto');
    }

    public function inventarioRepuestos()
    {
        return $this->hasMany('App\Models\InventarioRepuesto', 'idModeloRepuesto');
    }
    
}

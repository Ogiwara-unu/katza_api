<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMantenimiento extends Model
{
    use HasFactory;
    protected $table = 'tipoMantenimientos';
    protected $primaryKey = 'idTipoMantenimiento';
    protected $fillable = ['idTipoMantenimiento','nombre'];

    public function mantenimientos()
    {
        return $this->hasMany('App\Models\Mantenimiento', 'tipoMantenimiento');

    }

}
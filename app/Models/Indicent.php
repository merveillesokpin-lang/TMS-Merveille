<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indice extends Model
{
    use HasFactory;

    protected $table = 'indicent';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    
}

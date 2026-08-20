<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouvemennt_parc extends Model
{
    use HasFactory;

    protected $table = 'mouvement_parc';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}

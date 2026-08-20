<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipemet_geoloc extends Model
{
    use HasFactory;

    protected $table = 'equipement_geoloc';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->hasMany(Vehicule::class);
    }
}

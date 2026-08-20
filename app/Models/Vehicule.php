<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pierce_rechange()
    {
        return $this->hasMany(Pierce_rechange::class);
    }
    public function voyage()
    {
        return $this->hasMany(Voyage::class);
    }
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
    public function mouvement_parc()
    {
        return $this->hasMany(Mouvement_Parc::class);
    }
    public function categorie_vehicule()
    {
        return $this->hasMany(Categorie_Vehicule::class);
    }
    public function equipement_geoloc()
    {
        return $this->belongsTo(Equipement_geoloc::class);
    }
    public function alerte()
    {
        return $this->hasMany(Alerte::class);
    }
    public function indicent()
    {
        return $this->hasMany(Indicent::class);
    }
    public function bon_travail()
    {
        return $this->hasMany(Bon_travail::class);
    }

    


}

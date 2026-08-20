<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie_Vehicule extends Model
{
    use HasFactory;

    protected $table = 'categorie_vehicule';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function bonTravail()
    {
        return $this->hasMany(Bon_travail::class);
    }
}

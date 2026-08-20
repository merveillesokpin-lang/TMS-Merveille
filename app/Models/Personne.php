<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory;

    protected $table = 'personnel';
    protected $guarded = [];

    public function categorie_personne()
    {
        return $this->belongsTo(Categorie_Personnne::class, 'categorie_personnel_id');
    }
    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id');
    }
    public function prestation_externe()
    {
        return $this->hasMany(Prestataire_Externe::class);
    }
}

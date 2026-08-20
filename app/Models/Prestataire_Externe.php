<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire_Externe extends Model
{
    use HasFactory;

    protected $table = 'prestataire_externe';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}

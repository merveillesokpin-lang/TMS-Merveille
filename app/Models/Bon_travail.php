<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon_travail extends Model
{
    use HasFactory;

    protected $table = 'bon_travail';
    protected $guarded = [];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
    public function categorieVehicule()
    {
        return $this->belongsTo(Categorie_Vehicule::class);
    }
    public function pieceRechange()
    {
        return $this->belongsTo(Piece_Rechange::class);
    }    

}

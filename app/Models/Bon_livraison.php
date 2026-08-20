<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon_livraison extends Model
{
    use HasFactory;

    protected $table = 'bon_livraison';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}

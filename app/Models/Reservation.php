<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';
    protected $guarded = [];
    
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class);
    }
    public function voyage()
    {
        return $this->hasMany(Voyage::class);
    }
    
}

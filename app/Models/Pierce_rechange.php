<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pierce_rechange extends Model
{
    use HasFactory;

    protected $table = 'piece_rechange';
    protected $guarded = [];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function bon_travail()
    {
        return $this->hasMany(Bon_travail::class);
    }
}

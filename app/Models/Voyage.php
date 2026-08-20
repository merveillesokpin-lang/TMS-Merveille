<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $table = 'voyage';
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTO(Reservation::class);
    }
    public function bon_livraison()
    {
        return $this->hasMany(Bon_Livraison::class);
    }
}

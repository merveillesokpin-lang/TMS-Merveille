<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'facture';
    protected $guarded = [];

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class);
    }

    public function reglement()
    {
        return $this->belongsTo(Reglement::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

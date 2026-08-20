<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaire';
    protected $guarded = [];

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
    public function contrat_partenaire()
    {
        return $this->hasMany(Contrat_Partenaire::class);
    }
}

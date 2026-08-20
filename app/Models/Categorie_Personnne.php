<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie_Personnne extends Model
{
    use HasFactory;

    protected $table = 'equipement_categorie_personnel';
    protected $guarded = [];

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}

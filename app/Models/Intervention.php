<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervetion extends Model
{
    use HasFactory;

    protected $table = 'intervention';
    protected $guarded = [];

    public function bon_travail()
    {
        return $this->hasMany(Bon_travail::class);
    }
    public function personnel()
    {
        return $this->hasMany(Personne::class);
    }
}

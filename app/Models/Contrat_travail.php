<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat_travail extends Model
{
    use HasFactory;

    protected $table = 'contrat_travail';
    protected $guarded = [];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chronogramme_chauffeur extends Model
{
    use HasFactory;

    protected $table = 'chronogramme_chauffeur';
    protected $guarded = [];

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}

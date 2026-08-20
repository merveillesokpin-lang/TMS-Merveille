<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conntrat_partenaire extends Model
{
    use HasFactory;

    protected $table = 'contrat_partenariat';
    protected $guarded = [];

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class);
    }
}

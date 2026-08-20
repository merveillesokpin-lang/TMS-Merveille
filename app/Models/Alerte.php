<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;

    protected $table = 'alerte';

    protected $fillable = [
        'TypeAlerte',
        'vehicule_id',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $guarded = [];

    protected $casts = [
        'date_expiration' => 'date',
    ];

    public function entite()
    {
        return $this->morphTo();
    }
}

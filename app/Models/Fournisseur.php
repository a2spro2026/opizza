<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'date_creation',
        'code',
        'nom',
        'ville',
        'contact',
        'type_reglement',
        'echeance',
        'solde_initial',
    ];

    protected function casts(): array
    {
        return [
            'date_creation' => 'date',
            'echeance' => 'integer',
            'solde_initial' => 'decimal:2',
        ];
    }
}

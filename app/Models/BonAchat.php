<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonAchat extends Model
{
    protected $fillable = [
        'date',
        'ref_bn',
        'fournisseur_id',
        'ref_article',
        'designation',
        'qte',
        'prix_u',
        'sous_total',
        'type_reglement',
        'montant_reglement',
        'echeance',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'qte' => 'decimal:2',
            'prix_u' => 'decimal:2',
            'sous_total' => 'decimal:2',
            'montant_reglement' => 'decimal:2',
            'echeance' => 'integer',
        ];
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function reglements(): HasMany
    {
        return $this->hasMany(Reglement::class);
    }
}

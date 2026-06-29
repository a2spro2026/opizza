<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reglement extends Model
{
    protected $fillable = [
        'date',
        'fournisseur_id',
        'bon_achat_id',
        'montant_bon',
        'ref_reglement',
        'type_reglement',
        'numero',
        'banque',
        'nom_tire',
        'montant_reglement',
        'date_decaissement',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'date_decaissement' => 'date',
            'montant_bon' => 'decimal:2',
            'montant_reglement' => 'decimal:2',
        ];
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function bonAchat(): BelongsTo
    {
        return $this->belongsTo(BonAchat::class);
    }

    public function getSoldeAttribute(): float
    {
        return (float) $this->montant_bon - (float) $this->montant_reglement;
    }
}

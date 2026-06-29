<?php

namespace App\Http\Controllers;

use App\Models\BonAchat;
use App\Models\Fournisseur;
use App\Models\Reglement;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    public const TYPES_REGLEMENT = ['Espèces', 'Chèque', 'Virement', 'Traite', 'Carte'];

    public function index()
    {
        return view('reglement.fiche', $this->sharedData(null));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Reglement::create($this->prepare($data));

        return redirect()->route('reglement.fiche');
    }

    public function edit(Reglement $reglement)
    {
        return view('reglement.fiche', $this->sharedData($reglement));
    }

    public function update(Request $request, Reglement $reglement)
    {
        $data = $this->validateData($request);
        $reglement->update($this->prepare($data));

        return redirect()->route('reglement.fiche');
    }

    public function print(Reglement $reglement)
    {
        $reglement->load(['fournisseur', 'bonAchat']);

        return view('reglement.print', [
            'reglement' => $reglement,
        ]);
    }

    public function destroy(Reglement $reglement)
    {
        $reglement->delete();

        return redirect()->route('reglement.fiche');
    }

    private function sharedData(?Reglement $editing): array
    {
        $bons = BonAchat::with('fournisseur')
            ->withSum('reglements as regle_total', 'montant_reglement')
            ->orderByDesc('id')
            ->get()
            ->filter(function ($bon) use ($editing) {
                $reste = (float) $bon->sous_total - (float) ($bon->regle_total ?? 0);

                // Non soldé, ou bon rattaché au règlement en cours d'édition.
                return $reste > 0.001 || ($editing && (int) $editing->bon_achat_id === (int) $bon->id);
            })
            ->values();

        return [
            'active' => 'fournisseur-reglement',
            'reglements' => Reglement::with(['fournisseur', 'bonAchat'])->orderByDesc('id')->get(),
            'fournisseurs' => Fournisseur::orderBy('nom')->get(),
            'bons' => $bons,
            'typesReglement' => self::TYPES_REGLEMENT,
            'prochaineRef' => $editing ? $editing->ref_reglement : $this->prochaineRef(),
            'editing' => $editing,
        ];
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'date' => ['required', 'date'],
            'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
            'bon_achat_id' => ['required', 'exists:bon_achats,id'],
            'ref_reglement' => ['required', 'string', 'max:50'],
            'type_reglement' => ['nullable', 'in:'.implode(',', self::TYPES_REGLEMENT)],
            'numero' => ['nullable', 'string', 'max:100'],
            'banque' => ['nullable', 'string', 'max:100'],
            'nom_tire' => ['nullable', 'string', 'max:255'],
            'montant_reglement' => ['required', 'numeric', 'min:0'],
            'date_decaissement' => ['nullable', 'date'],
        ], [
            'date.required' => 'La date est obligatoire.',
            'fournisseur_id.required' => 'Le fournisseur est obligatoire.',
            'bon_achat_id.required' => 'La référence du bon est obligatoire.',
            'ref_reglement.required' => 'La référence du règlement est obligatoire.',
            'montant_reglement.required' => 'Le montant du règlement est obligatoire.',
        ]);
    }

    private function prepare(array $data): array
    {
        $bon = BonAchat::find($data['bon_achat_id']);
        $data['montant_bon'] = $bon ? (float) $bon->sous_total : 0;

        return $data;
    }

    private function prochaineRef(): string
    {
        $count = Reglement::count() + 1;

        return 'REG-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}

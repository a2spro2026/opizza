<?php

namespace App\Http\Controllers;

use App\Models\BonAchat;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class BonAchatController extends Controller
{
    public const TYPES_REGLEMENT = ['Espèces', 'Chèque', 'Virement', 'Traite', 'Carte'];

    public function index()
    {
        return view('bon-achat.fiche', [
            'active' => 'fournisseur-bon-achat',
            'bons' => BonAchat::with('fournisseur')->orderByDesc('id')->get(),
            'fournisseurs' => Fournisseur::orderBy('nom')->get(),
            'typesReglement' => self::TYPES_REGLEMENT,
            'prochaineRef' => $this->prochaineRef(),
            'editing' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        BonAchat::create($this->prepare($data));

        return redirect()->route('bon-achat.fiche');
    }

    public function edit(BonAchat $bonAchat)
    {
        return view('bon-achat.fiche', [
            'active' => 'fournisseur-bon-achat',
            'bons' => BonAchat::with('fournisseur')->orderByDesc('id')->get(),
            'fournisseurs' => Fournisseur::orderBy('nom')->get(),
            'typesReglement' => self::TYPES_REGLEMENT,
            'prochaineRef' => $bonAchat->ref_bn,
            'editing' => $bonAchat,
        ]);
    }

    public function update(Request $request, BonAchat $bonAchat)
    {
        $data = $this->validateData($request);
        $bonAchat->update($this->prepare($data));

        return redirect()->route('bon-achat.fiche');
    }

    public function print(BonAchat $bonAchat)
    {
        $bonAchat->load('fournisseur');

        return view('bon-achat.print', [
            'bon' => $bonAchat,
        ]);
    }

    public function destroy(BonAchat $bonAchat)
    {
        $bonAchat->delete();

        return redirect()->route('bon-achat.fiche');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'date' => ['required', 'date'],
            'ref_bn' => ['required', 'string', 'max:50'],
            'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
            'ref_article' => ['nullable', 'string', 'max:50'],
            'designation' => ['required', 'string', 'max:255'],
            'qte' => ['required', 'numeric', 'min:0'],
            'prix_u' => ['required', 'numeric', 'min:0'],
            'type_reglement' => ['nullable', 'in:'.implode(',', self::TYPES_REGLEMENT)],
            'echeance' => ['nullable', 'integer', 'min:0', 'max:3650'],
        ], [
            'date.required' => 'La date est obligatoire.',
            'ref_bn.required' => 'La référence du bon est obligatoire.',
            'fournisseur_id.required' => 'Le fournisseur est obligatoire.',
            'designation.required' => 'La désignation est obligatoire.',
            'qte.required' => 'La quantité est obligatoire.',
            'prix_u.required' => 'Le prix unitaire est obligatoire.',
        ]);
    }

    private function prepare(array $data): array
    {
        $data['sous_total'] = round(((float) $data['qte']) * ((float) $data['prix_u']), 2);

        return $data;
    }

    private function prochaineRef(): string
    {
        $count = BonAchat::count() + 1;

        return 'BA-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}

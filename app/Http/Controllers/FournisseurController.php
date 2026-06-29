<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FournisseurController extends Controller
{
    public const TYPES_REGLEMENT = ['Espèces', 'Chèque', 'Virement', 'Traite', 'Carte'];

    public function index()
    {
        return view('fournisseur.fiche', [
            'active' => 'fournisseur-fiche',
            'fournisseurs' => Fournisseur::orderByDesc('id')->get(),
            'typesReglement' => self::TYPES_REGLEMENT,
            'prochainCode' => $this->prochainCode(),
            'editing' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['solde_initial'] = $data['solde_initial'] ?? 0;

        Fournisseur::create($data);

        return redirect()->route('fournisseur.fiche');
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseur.fiche', [
            'active' => 'fournisseur-fiche',
            'fournisseurs' => Fournisseur::orderByDesc('id')->get(),
            'typesReglement' => self::TYPES_REGLEMENT,
            'prochainCode' => $fournisseur->code,
            'editing' => $fournisseur,
        ]);
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $data = $this->validateData($request, $fournisseur->id);

        $data['solde_initial'] = $data['solde_initial'] ?? 0;

        $fournisseur->update($data);

        return redirect()->route('fournisseur.fiche');
    }

    public function print(Fournisseur $fournisseur)
    {
        return view('fournisseur.print', [
            'fournisseur' => $fournisseur,
        ]);
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return redirect()->route('fournisseur.fiche');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'date_creation' => ['required', 'date'],
            'code' => ['required', 'string', 'max:50', Rule::unique('fournisseurs', 'code')->ignore($ignoreId)],
            'nom' => ['required', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'type_reglement' => ['nullable', 'in:'.implode(',', self::TYPES_REGLEMENT)],
            'echeance' => ['nullable', 'integer', 'min:0', 'max:3650'],
            'solde_initial' => ['nullable', 'numeric'],
        ], [
            'date_creation.required' => 'La date de création est obligatoire.',
            'code.required' => "L'ID du fournisseur est obligatoire.",
            'code.unique' => 'Cet ID fournisseur existe déjà.',
            'nom.required' => 'Le nom du fournisseur est obligatoire.',
        ]);
    }

    private function prochainCode(): string
    {
        $count = Fournisseur::count() + 1;

        return 'FRN-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}

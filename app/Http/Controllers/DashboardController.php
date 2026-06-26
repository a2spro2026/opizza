<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'active' => 'dashboard',
            'stats' => [
                ['label' => "Chiffre D'affaire", 'value' => '2 480.00', 'change' => '+12,5%', 'up' => true, 'grad' => 'from-emerald-400 via-emerald-500 to-teal-600', 'glow' => 'shadow-emerald-500/40', 'icon' => 'M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'],
                ['label' => 'Total recettes', 'value' => '18 650.00', 'change' => '+8,2%', 'up' => true, 'grad' => 'from-orange-400 via-brand-500 to-rose-500', 'glow' => 'shadow-brand-500/40', 'icon' => 'M2.25 18 9 11.25l4.306 4.307a11.95 11.95 0 0 1 5.814-5.519l2.74-1.22m0 0-5.94-2.28m5.94 2.28-2.28 5.941'],
                ['label' => 'Total Charges', 'value' => '7 320.00', 'change' => '-3,4%', 'up' => false, 'grad' => 'from-indigo-400 via-violet-500 to-purple-600', 'glow' => 'shadow-violet-500/40', 'icon' => 'M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181'],
                ['label' => 'Serveur Actif', 'value' => '6 actifs', 'extra' => '4 980.00 réalisés', 'change' => '+5,1%', 'up' => true, 'grad' => 'from-amber-400 via-orange-500 to-amber-600', 'glow' => 'shadow-amber-500/40', 'icon' => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z'],
            ],
            'stock' => [
                ['name' => 'Mozzarella', 'level' => 15, 'qty' => '3 kg'],
                ['name' => 'Farine T55', 'level' => 42, 'qty' => '12 kg'],
                ['name' => 'Tomates pelées', 'level' => 28, 'qty' => '8 boîtes'],
                ['name' => 'Basilic frais', 'level' => 12, 'qty' => '4 bottes'],
                ['name' => "Huile d'olive", 'level' => 55, 'qty' => '6 L'],
                ['name' => 'Pâte à pizza', 'level' => 18, 'qty' => '20 pâtons'],
            ],
        ]);
    }

    public function section(string $section)
    {
        $navigation = config('navigation');

        $found = null;
        foreach ($navigation as $group) {
            if (! empty($group['children']) && isset($group['children'][$section])) {
                $found = [
                    'group' => $group['label'],
                    'title' => $group['children'][$section]['label'],
                    'icon' => $group['children'][$section]['icon'],
                ];
                break;
            }
        }

        abort_unless($found, 404);

        return view('dashboard-section', [
            'active' => $section,
            'group' => $found['group'],
            'title' => $found['title'],
            'icon' => $found['icon'],
        ]);
    }
}

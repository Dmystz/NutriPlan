<?php

namespace App\Http\Controllers;

use App\Models\KatalogResep;
use App\Models\User;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    /**
     * Tampilkan halaman nutrition.
     * Bisa dengan ?resep_id=X untuk melihat resep spesifik.
     */
    public function index(Request $request)
    {
        $user = User::find(session('user_id'));

        // Resep yang ditampilkan: dari query string atau resep pertama
        $resepId = $request->get('resep_id');

        if ($resepId) {
            $resep = KatalogResep::findOrFail($resepId);
        } else {
            // Default: tampilkan resep pertama yang ada
            $resep = KatalogResep::public()->first();
        }

        // Target harian user
        $targetMakro  = $user ? $user->targetMakro()  : [];
        $targetKalori = $user ? $user->targetKalori()  : 2000;

        // Hitung persentase dari target harian
        $pctKalori  = $targetKalori > 0 && $resep
            ? round(($resep->calories / $targetKalori) * 100, 1)
            : 0;

        // Parse ingredients ke array
        $ingredients = [];
        if ($resep && $resep->ingredients) {
            $decoded = json_decode($resep->ingredients, true);
            $ingredients = is_array($decoded) ? $decoded : [];
        }

        // Parse cara masak ke array
        $steps = [];
        if ($resep && $resep->cara_masak) {
            $decoded = json_decode($resep->cara_masak, true);
            $steps = is_array($decoded) ? $decoded : [];
        }

        // Breakdown nutrisi lengkap (untuk tabel breakdown)
        $breakdown = $resep ? $this->buildBreakdown($resep, $targetMakro) : [];

        return view('layout.nutrition', compact(
            'user',
            'resep',
            'targetKalori',
            'targetMakro',
            'pctKalori',
            'ingredients',
            'steps',
            'breakdown',
        ));
    }

    private function buildBreakdown(KatalogResep $resep, array $target): array
    {
        $dailyCals    = $target['kalori']  ?? 2000;
        $dailyProtein = $target['protein'] ?? 150;
        $dailyCarbs   = $target['carbs']   ?? 200;
        $dailyFat     = $target['fat']     ?? 65;

        return [
            [
                'label' => 'Calories',
                'val'   => $resep->calories . ' kcal',
                'pct'   => $dailyCals    > 0 ? min(round($resep->calories / $dailyCals    * 100), 100) : 0,
                'color' => '#FF6900',
            ],
            [
                'label' => 'Protein',
                'val'   => $resep->protein . ' g',
                'pct'   => $dailyProtein > 0 ? min(round($resep->protein  / $dailyProtein * 100), 100) : 0,
                'color' => '#00A63E',
            ],
            [
                'label' => 'Carbohydrates',
                'val'   => $resep->carbs . ' g',
                'pct'   => $dailyCarbs   > 0 ? min(round($resep->carbs    / $dailyCarbs   * 100), 100) : 0,
                'color' => '#FBBF24',
            ],
            [
                'label' => 'Fat',
                'val'   => $resep->fat . ' g',
                'pct'   => $dailyFat     > 0 ? min(round($resep->fat      / $dailyFat     * 100), 100) : 0,
                'color' => '#FB923C',
            ],
            [
                'label' => 'Fiber',
                'val'   => ($resep->fiber ?? 0) . ' g',
                'pct'   => 25, // default estimasi, sesuaikan jika ada data fiber di database
                'color' => '#A78BFA',
            ],
        ];
    }
}
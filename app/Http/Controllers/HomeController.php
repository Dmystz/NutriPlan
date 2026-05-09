<?php

namespace App\Http\Controllers;

use App\Models\Jadwalmakanan;
use App\Models\KatalogResep;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $user   = User::find($userId);

        // ── Jadwal makan HARI INI ──
        $jadwalHariIni = Jadwalmakanan::with('recipe')
            ->where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->orderByRaw("FIELD(meal_type, 'breakfast','snack','lunch','dinner')")
            ->get();

        // ── Hitung total kalori & nutrisi hari ini ──
        $totalKalori  = 0;
        $totalProtein = 0;
        $totalCarbs   = 0;
        $totalFat     = 0;

        foreach ($jadwalHariIni as $j) {
            if ($j->recipe) {
                $s = $j->servings ?? 1;
                $totalKalori  += $j->recipe->calories * $s;
                $totalProtein += $j->recipe->protein  * $s;
                $totalCarbs   += $j->recipe->carbs    * $s;
                $totalFat     += $j->recipe->fat      * $s;
            }
        }

        // ── Target nutrisi dari profil user ──
        $targetKalori  = $user ? $user->targetKalori() : (session('target_kalori', 2000));
        $targetMakro   = $user ? $user->targetMakro()  : [
            'protein' => session('target_protein', 150),
            'carbs'   => session('target_carbs',   200),
            'fat'     => session('target_fat',      65),
        ];

        // ── BMI dari session (sudah dihitung saat login) ──
        $bmi         = session('bmi', $user?->hitungBmi() ?? 0);
        $bmiKategori = session('bmi_kategori', $user?->kategoriBmi() ?? 'Normal');

        // ── Rekomendasi resep (4 resep populer) ──
        $rekomendasi = KatalogResep::public()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // ── Shopping list: ingredients dari jadwal minggu ini ──
        $shoppingList = $this->buildShoppingList($userId);

        return view('layout.home', compact(
            'user',
            'jadwalHariIni',
            'totalKalori',
            'totalProtein',
            'totalCarbs',
            'totalFat',
            'targetKalori',
            'targetMakro',
            'bmi',
            'bmiKategori',
            'rekomendasi',
            'shoppingList',
        ));
    }

    // ══════════════════════════════
    //  PRIVATE: Shopping list builder
    // ══════════════════════════════

    private function buildShoppingList(int $userId): array
    {
        $jadwalMingguIni = Jadwalmakanan::with('recipe')
            ->where('user_id', $userId)
            ->whereBetween('tanggal', [today()->startOfWeek(), today()->endOfWeek()])
            ->get();

        $items = [];
        foreach ($jadwalMingguIni as $j) {
            if ($j->recipe && $j->recipe->ingredients) {
                // ingredients tersimpan sebagai JSON atau plain text
                $bahan = json_decode($j->recipe->ingredients, true);
                if (is_array($bahan)) {
                    foreach ($bahan as $b) {
                        $items[] = is_array($b) ? ($b['name'] ?? '') : (string) $b;
                    }
                }
            }
        }

        return array_unique(array_filter($items));
    }
}
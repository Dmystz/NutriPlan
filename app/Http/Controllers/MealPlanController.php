<?php

namespace App\Http\Controllers;

use App\Models\JadwalMakanan;
use App\Models\MealLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MealPlanPreference;

class MealPlanController extends Controller
{
    /* ── Helper: ambil user_id dari session ────────────────
       Konsisten dengan AuthController yang menyimpan
       user_id ke session (bukan Auth facade / Sanctum).
       ──────────────────────────────────────────────────── */
    private function userId(): int
    {
        return auth()->id() ?? session('user_id');
    }

    /* ══════════════════════════════════════════════════════
       GET /meal_plan
       Render halaman Meal Plan.
       Kirim data ke:
         - days_meal_plan.blade.php  → $groupedLogs, $dailyTotals
         - week_meal_plan.blade.php  → $upcomingDays
       ══════════════════════════════════════════════════════ */
    public function index()
    {
        $userId = $this->userId();
        $today  = now()->toDateString();
    
        /* ── Days view ──────────────────────────────────── */
        $groupedLogs = MealLog::groupedBySlot($userId, $today);
        $dailyTotals = MealLog::dailyTotals($userId, $today);
    
        /* ── Preference (untuk Daily Goals di days_meal_plan.blade.php) ── */
        $pref = MealPlanPreference::where('user_id', $userId)->first();
    
        // Hitung target kalori & makro dari preference, atau fallback ke default
        if ($pref) {
            $targetKalori = (int) $pref->target_kalori;
            $targetMakro  = [
                'protein' => (int) round($pref->target_kalori * $pref->protein_pct / 100 / 4),
                'carbs'   => (int) round($pref->target_kalori * $pref->carbs_pct   / 100 / 4),
                'fat'     => (int) round($pref->target_kalori * $pref->fat_pct     / 100 / 9),
            ];
        } else {
            $targetKalori = 2000;
            $targetMakro  = ['protein' => 125, 'carbs' => 225, 'fat' => 67];
        }
    
        /* ── Week view: 6 hari ke depan ─────────────────── */
        $upcomingDays = collect(range(1, 6))->map(function (int $i) use ($userId) {
            $date    = now()->addDays($i);
            $dateStr = $date->toDateString();
    
            $jadwals = JadwalMakanan::forUser($userId)
                ->forDate($dateStr)
                ->with('resep')
                ->orderBy('meal_time')
                ->get();
    
            $isPlanned = $jadwals->isNotEmpty();
            $first     = $jadwals->first();
            $meal      = null;
    
            if ($isPlanned && $first?->resep) {
                $meal = [
                    'name'       => $first->resep->nama_makanan,
                    'image'      => $first->resep->image_path ?? 'meal1_home.png',
                    'ktg1_label' => ucfirst($first->resep->meal_type  ?? 'Meal'),
                    'ktg1_class' => 'ktg-ijo-home',
                    'ktg2_label' => ucfirst($first->resep->difficulty ?? ''),
                    'ktg2_class' => 'ktg-oren-home',
                    'kcal'       => $first->resep->calories ?? 0,
                    'protein'    => $first->resep->protein  ?? 0,
                ];
            }
    
            return [
                'date'       => $date,
                'is_planned' => $isPlanned,
                'meal'       => $meal,
                'jadwals'    => $jadwals,
            ];
        });
    
        return view('layout.meal_plan', compact(
            'groupedLogs',
            'dailyTotals',
            'upcomingDays',
            'targetKalori',   // ← baru
            'targetMakro',    // ← baru
        ));
    }

    /* ══════════════════════════════════════════════════════
       POST /meal_plan/jadwal
       Simpan jadwal dari modal "Plan Manually" (week view).
       ══════════════════════════════════════════════════════ */
    public function storeJadwal(Request $request)
    {
        $validated = $request->validate([
            'katalog_resep_id' => ['nullable', 'integer', 'exists:katalog_resep,id'],
            'tanggal'          => ['required', 'date_format:Y-m-d'],
            'meal_type'        => ['required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'meal_time'        => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'servings'         => ['required', 'integer', 'min:1', 'max:10'],
            'catatan'          => ['nullable', 'string', 'max:500'],
        ]);

        $jadwal = JadwalMakanan::create([
            'user_id'          => $this->userId(),
            'katalog_resep_id' => $validated['katalog_resep_id'] ?? null,
            'tanggal'          => $validated['tanggal'],
            'meal_type'        => $validated['meal_type'],
            'meal_time'        => $validated['meal_time']        ?? null,
            'servings'         => $validated['servings'],
            'catatan'          => $validated['catatan']          ?? null,
            'is_consumed'      => false,
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil disimpan.',
            'jadwal'  => $jadwal->load('resep'),
        ], 201);
    }

    /* ══════════════════════════════════════════════════════
       PUT /meal_plan/jadwal/{id}
       Update jadwal dari modal "Edit Plan".
       ══════════════════════════════════════════════════════ */
    public function updateJadwal(Request $request, int $id)
    {
        $jadwal = JadwalMakanan::forUser($this->userId())->findOrFail($id);

        $validated = $request->validate([
            'katalog_resep_id' => ['nullable', 'integer', 'exists:katalog_resep,id'],
            'tanggal'          => ['sometimes', 'date_format:Y-m-d'],
            'meal_type'        => ['sometimes', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'meal_time'        => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'servings'         => ['sometimes', 'integer', 'min:1', 'max:10'],
            'is_consumed'      => ['sometimes', 'boolean'],
            'catatan'          => ['nullable', 'string', 'max:500'],
        ]);

        $jadwal->update($validated);

        return response()->json([
            'message' => 'Jadwal diperbarui.',
            'jadwal'  => $jadwal->fresh()->load('resep'),
        ]);
    }

    /* ══════════════════════════════════════════════════════
       DELETE /meal_plan/jadwal/{id}
       Hapus jadwal dari modal "Edit Plan".
       ══════════════════════════════════════════════════════ */
    public function destroyJadwal(int $id)
    {
        $jadwal = JadwalMakanan::forUser($this->userId())->findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Jadwal dihapus.']);
    }

    /* ══════════════════════════════════════════════════════
       GET /api/meal-plan/day?date=YYYY-MM-DD
       AJAX navigasi tanggal di Days view (tombol ‹ ›).
       ══════════════════════════════════════════════════════ */
    public function dayData(Request $request)
    {
        $request->validate(['date' => ['required', 'date_format:Y-m-d']]);

        $userId = $this->userId();
        $date   = $request->date;

        return response()->json([
            'date'    => $date,
            'grouped' => MealLog::groupedBySlot($userId, $date),
            'totals'  => MealLog::dailyTotals($userId, $date),
        ]);
    }
    public function getPreferences()
    {
        $pref = MealPlanPreference::firstOrCreate(
            ['user_id' => $this->userId()],
            [
                'target_kalori' => 2200,
                'protein_pct'   => 25,
                'carbs_pct'     => 45,
                'fat_pct'       => 30,
                'diet_pref'     => 'balanced',
                'meals_per_day' => 5,
                'avoid_items'   => [],
            ]
        );

        return response()->json(['success' => true, 'data' => $pref]);
    }

    /* ══════════════════════════════════════════════════════
    POST /meal_plan/preferences
    Simpan preferensi dari modal Adjust Meal Plan
    ══════════════════════════════════════════════════════ */
    public function savePreferences(Request $request)
    {
        $validated = $request->validate([
            'target_kalori' => ['required', 'integer', 'min:1200', 'max:3500'],
            'protein_pct'   => ['required', 'integer', 'min:10', 'max:50'],
            'carbs_pct'     => ['required', 'integer', 'min:10', 'max:70'],
            'fat_pct'       => ['required', 'integer', 'min:10', 'max:60'],
            'diet_pref'     => ['required', 'string', 'in:balanced,high_protein,keto,vegan,low_carb,mediterranean'],
            'meals_per_day' => ['required', 'integer', 'min:2', 'max:6'],
            'avoid_items'   => ['nullable', 'array'],
            'avoid_items.*' => ['string', 'max:50'],
        ]);

        MealPlanPreference::updateOrCreate(
            ['user_id' => $this->userId()],
            $validated
        );

        return response()->json(['success' => true, 'message' => 'Preferensi berhasil disimpan!']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MealLogController extends Controller
{
    /* ── Helper: ambil user_id dari session ────────────────
       Karena pakai session-based auth (bukan Sanctum),
       Auth::id() mungkin null. Fallback ke session('user_id').
       ──────────────────────────────────────────────────── */
    private function userId(): int
    {
        return auth()->id() ?? session('user_id');
    }

    /* ══════════════════════════════════════════════════════
       GET /api/meal-logs?date=YYYY-MM-DD
       Daftar semua log user untuk satu tanggal,
       dikelompokkan per slot (Breakfast/Snack/Lunch/Dinner).
       Default: hari ini.
       ══════════════════════════════════════════════════════ */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $date    = $request->query('date', now()->toDateString());
        $userId  = $this->userId();

        return response()->json([
            'date'    => $date,
            'grouped' => MealLog::groupedBySlot($userId, $date),
            'totals'  => MealLog::dailyTotals($userId, $date),
        ]);
    }

    /* ══════════════════════════════════════════════════════
       GET /api/meal-logs/summary
       Total nutrisi hari ini (kalori, protein, carbs, fat).
       Dipakai untuk update panel Nutrition Summary secara live.
       ══════════════════════════════════════════════════════ */
    public function summary(Request $request): JsonResponse
    {
        $date   = $request->query('date', now()->toDateString());
        $userId = $this->userId();

        $totals = MealLog::dailyTotals($userId, $date);

        // Jumlah item per slot untuk info "X Meals"
        $countPerSlot = MealLog::forUser($userId)
            ->forDate($date)
            ->selectRaw('meal_slot, COUNT(*) as total')
            ->groupBy('meal_slot')
            ->pluck('total', 'meal_slot');

        return response()->json([
            'date'           => $date,
            'totals'         => $totals,
            'count_per_slot' => $countPerSlot,
            'total_items'    => $countPerSlot->sum(),
        ]);
    }

    /* ══════════════════════════════════════════════════════
       GET /api/meal-logs/{id}
       Detail satu log (hanya milik user sendiri).
       ══════════════════════════════════════════════════════ */
    public function show(int $id): JsonResponse
    {
        $log = MealLog::forUser($this->userId())->findOrFail($id);

        return response()->json($log);
    }

    /* ══════════════════════════════════════════════════════
       POST /api/meal-logs
       Simpan satu log dari modal "Add Meal".

       Body JSON (dari amSave() di modal_add_meal.blade.php):
         food_id?   int
         name       string
         category   meal|drink|snack
         meal_slot  Breakfast|Snack|Lunch|Dinner
         meal_time  HH:MM
         servings   int
         calories   float   ← sudah dikalikan servings di JS
         protein    float
         carbs      float
         fat        float
         log_date?  YYYY-MM-DD  (default: today)
       ══════════════════════════════════════════════════════ */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'food_id'   => ['nullable', 'integer', 'exists:foods,id'],
            'name'      => ['required', 'string', 'max:191'],
            'category'  => ['required', Rule::in(['meal', 'drink', 'snack'])],
            'meal_slot' => ['required', Rule::in(['Breakfast', 'Snack', 'Lunch', 'Dinner'])],
            'meal_time' => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'servings'  => ['required', 'integer', 'min:1', 'max:20'],
            'calories'  => ['required', 'numeric', 'min:0'],
            'protein'   => ['required', 'numeric', 'min:0'],
            'carbs'     => ['required', 'numeric', 'min:0'],
            'fat'       => ['required', 'numeric', 'min:0'],
            'log_date'  => ['nullable', 'date_format:Y-m-d'],
        ]);

        $userId  = $this->userId();
        $logDate = $validated['log_date'] ?? now()->toDateString();

        // ambil food kalau ada
        $food = null;

        if (!empty($validated['food_id'])) {
            $food = \App\Models\Food::find($validated['food_id']);
        }

        $log = MealLog::create([
            'user_id'    => $userId,

            'food_id'    => $validated['food_id'] ?? null,

            'name'       => $validated['name'],

            // TAMBAHAN
            'emoji'      => $food?->emoji,
            'image_path' => $food?->image_path,

            'category'   => $validated['category'],
            'meal_slot'  => $validated['meal_slot'],
            'meal_time'  => $validated['meal_time'] ?? null,
            'servings'   => $validated['servings'],

            'calories'   => $validated['calories'],
            'protein'    => $validated['protein'],
            'carbs'      => $validated['carbs'],
            'fat'        => $validated['fat'],

            'log_date'   => $logDate,
        ]);

        return response()->json([
            'message' => 'Meal berhasil ditambahkan.',
            'log'     => $log,
            'totals'  => MealLog::dailyTotals($userId, $logDate),
            'grouped' => MealLog::groupedBySlot($userId, $logDate),
        ], 201);
    }

    /* ══════════════════════════════════════════════════════
       PUT /api/meal-logs/{id}
       Update sebagian field (misal edit porsi/waktu).
       ══════════════════════════════════════════════════════ */
    public function update(Request $request, int $id): JsonResponse
    {
        $log = MealLog::forUser($this->userId())->findOrFail($id);

        $validated = $request->validate([
            'name'      => ['sometimes', 'string', 'max:191'],
            'category'  => ['sometimes', Rule::in(['meal', 'drink', 'snack'])],
            'meal_slot' => ['sometimes', Rule::in(['Breakfast', 'Snack', 'Lunch', 'Dinner'])],
            'meal_time' => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'servings'  => ['sometimes', 'integer', 'min:1', 'max:20'],
            'calories'  => ['sometimes', 'numeric', 'min:0'],
            'protein'   => ['sometimes', 'numeric', 'min:0'],
            'carbs'     => ['sometimes', 'numeric', 'min:0'],
            'fat'       => ['sometimes', 'numeric', 'min:0'],
            'log_date'  => ['sometimes', 'date_format:Y-m-d'],
        ]);

        $log->update($validated);

        $logDate = $log->fresh()->log_date->toDateString();
        $userId  = $this->userId();

        return response()->json([
            'message' => 'Log diperbarui.',
            'log'     => $log->fresh(),
            'totals'  => MealLog::dailyTotals($userId, $logDate),
        ]);
    }

    /* ══════════════════════════════════════════════════════
       DELETE /api/meal-logs/{id}
       Hapus satu log (hanya milik user sendiri).
       ══════════════════════════════════════════════════════ */
    public function destroy(int $id): JsonResponse
    {
        $log    = MealLog::forUser($this->userId())->findOrFail($id);
        $date   = $log->log_date->toDateString();
        $userId = $this->userId();

        $log->delete();

        return response()->json([
            'message' => 'Log dihapus.',
            'totals'  => MealLog::dailyTotals($userId, $date),
            'grouped' => MealLog::groupedBySlot($userId, $date),
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Jadwalmakanan;
use App\Models\Katalogresep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalMakananController extends Controller
{
    // ══════════════════════════════
    //  INDEX — Halaman Meal Plan
    // ══════════════════════════════

    public function index(Request $request)
    {
        $userId = session('user_id');
        $user   = User::find($userId);

        // Tanggal aktif (default: hari ini)
        $tanggal = $request->get('tanggal', today()->toDateString());
        $dateObj = Carbon::parse($tanggal);

        // ── Jadwal HARIAN (days view) ──
        $jadwalHarian = Jadwalmakanan::with('recipe')
            ->where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->orderByRaw("FIELD(meal_type, 'breakfast','snack','lunch','dinner')")
            ->get();

        // ── Jadwal MINGGUAN (week view): Senin – Minggu dari minggu ini ──
        $startOfWeek = $dateObj->copy()->startOfWeek();
        $endOfWeek   = $dateObj->copy()->endOfWeek();

        $jadwalMingguan = Jadwalmakanan::with('recipe')
            ->where('user_id', $userId)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->orderBy('tanggal')
            ->orderByRaw("FIELD(meal_type, 'breakfast','snack','lunch','dinner')")
            ->get()
            ->groupBy(fn ($j) => $j->tanggal->format('Y-m-d'));

        // ── Daftar resep (untuk modal add meal) ──
        $resepList = KatalogResep::public()->orderBy('nama_makanan')->get();

        // ── Ringkasan nutrisi hari ini ──
        $nutrisiHarian = $this->hitungNutrisiHarian($jadwalHarian, $user);

        return view('layout.meal_plan', compact(
            'jadwalHarian',
            'jadwalMingguan',
            'resepList',
            'nutrisiHarian',
            'tanggal',
            'user',
            'startOfWeek',
        ));
    }

    // ══════════════════════════════
    //  STORE — Tambah ke jadwal
    // ══════════════════════════════

    public function store(Request $request)
    {
        $request->validate([
            'katalog_resep_id' => 'required|exists:katalog_resep,id',
            'tanggal'          => 'required|date',
            'meal_type'        => 'required|in:breakfast,lunch,dinner,snack',
            'meal_time'        => 'nullable|date_format:H:i',
            'servings'         => 'nullable|integer|min:1|max:10',
        ]);

        Jadwalmakanan::create([
            'user_id'          => session('user_id'),
            'katalog_resep_id' => $request->katalog_resep_id,
            'tanggal'          => $request->tanggal,
            'meal_type'        => $request->meal_type,
            'meal_time'        => $request->meal_time,
            'servings'         => $request->servings ?? 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Meal plan ditambahkan']);
        }

        return redirect("/meal_plan?tanggal={$request->tanggal}")
            ->with('success', 'Meal berhasil ditambahkan! 🎉');
    }

    // ══════════════════════════════
    //  UPDATE — Edit jadwal
    // ══════════════════════════════

    public function update(Request $request, int $id)
    {
        $jadwal = Jadwalmakanan::where('user_id', session('user_id'))->findOrFail($id);

        $request->validate([
            'meal_type'   => 'nullable|in:breakfast,lunch,dinner,snack',
            'tanggal'     => 'nullable|date',
            'meal_time'   => 'nullable|date_format:H:i',
            'servings'    => 'nullable|integer|min:1|max:10',
            'is_consumed' => 'nullable|boolean',
            'catatan'     => 'nullable|string|max:255',
        ]);

        $jadwal->update($request->only('meal_type', 'tanggal', 'meal_time', 'servings', 'is_consumed', 'catatan'));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Diperbarui', 'data' => $jadwal]);
        }

        return back()->with('success', 'Jadwal diperbarui.');
    }

    // ══════════════════════════════
    //  DESTROY — Hapus jadwal
    // ══════════════════════════════

    public function destroy(int $id)
    {
        Jadwalmakanan::where('user_id', session('user_id'))->findOrFail($id)->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Dihapus']);
        }

        return back()->with('success', 'Meal dihapus.');
    }

    // ══════════════════════════════
    //  GENERATE OTOMATIS (weekly)
    // ══════════════════════════════

    /**
     * Buat jadwal mingguan otomatis berdasarkan target kalori user.
     * POST /meal_plan/generate
     */
    public function generate(Request $request)
    {
        $userId = session('user_id');
        $user   = User::findOrFail($userId);
        $target = $user->targetMakro();

        $startDate = Carbon::parse($request->get('start_date', today()));

        // Hapus jadwal minggu ini dulu
        Jadwalmakanan::where('user_id', $userId)
            ->whereBetween('tanggal', [
                $startDate->copy()->startOfWeek(),
                $startDate->copy()->endOfWeek(),
            ])->delete();

        // Ambil resep yang cocok
        $resepSemua = KatalogResep::public()
            ->where('calories', '>', 0)
            ->get();

        $slots = [
            'breakfast' => '08:00',
            'lunch'     => '13:00',
            'snack'     => '16:00',
            'dinner'    => '19:30',
        ];

        $jadwalBaru = [];

        // Isi 7 hari
        for ($i = 0; $i < 7; $i++) {
            $tanggal = $startDate->copy()->startOfWeek()->addDays($i);

            foreach ($slots as $slot => $jam) {
                // Filter resep yang sesuai slot
                $resepFiltered = $resepSemua->filter(
                    fn ($r) => $r->meal_type === $slot || ! $r->meal_type
                );

                $resep = $resepFiltered->isNotEmpty()
                    ? $resepFiltered->random()
                    : $resepSemua->random();

                $jadwalBaru[] = [
                    'user_id'          => $userId,
                    'katalog_resep_id' => $resep->id,
                    'tanggal'          => $tanggal->toDateString(),
                    'meal_type'        => $slot,
                    'meal_time'        => $jam,
                    'servings'         => 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }
        }

        Jadwalmakanan::insert($jadwalBaru);

        return back()->with('success', 'Jadwal mingguan berhasil digenerate! 🗓️');
    }

    // ══════════════════════════════
    //  PRIVATE HELPER
    // ══════════════════════════════

    private function hitungNutrisiHarian($jadwal, ?User $user): array
    {
        $totalKalori  = 0;
        $totalProtein = 0;
        $totalCarbs   = 0;
        $totalFat     = 0;

        foreach ($jadwal as $j) {
            if ($j->recipe) {
                $s = $j->servings ?? 1;
                $totalKalori  += $j->recipe->calories * $s;
                $totalProtein += $j->recipe->protein  * $s;
                $totalCarbs   += $j->recipe->carbs    * $s;
                $totalFat     += $j->recipe->fat      * $s;
            }
        }

        $targetKalori  = $user ? $user->targetKalori() : 2000;
        $targetMakro   = $user ? $user->targetMakro()  : ['protein' => 150, 'carbs' => 200, 'fat' => 65];

        return [
            'total_kalori'   => (int) $totalKalori,
            'total_protein'  => round($totalProtein, 1),
            'total_carbs'    => round($totalCarbs,   1),
            'total_fat'      => round($totalFat,     1),
            'target_kalori'  => (int) $targetKalori,
            'target_protein' => $targetMakro['protein'],
            'target_carbs'   => $targetMakro['carbs'],
            'target_fat'     => $targetMakro['fat'],
            'pct_kalori'     => $targetKalori > 0 ? min(round($totalKalori / $targetKalori * 100), 100) : 0,
        ];
    }
}
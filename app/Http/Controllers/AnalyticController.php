<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticController extends Controller
{
    // ══════════════════════════════
    //  HALAMAN ANALYTIC
    // ══════════════════════════════

    public function index()
    {
        $user = User::find(session('user_id'));

        $bmi          = $user ? $user->hitungBmi()     : 0;
        $bmiKategori  = $user ? $user->kategoriBmi()   : 'Normal';
        $bmr          = $user ? round($user->hitungBmr())  : 0;
        $tdee         = $user ? round($user->hitungTdee()) : 0;
        $targetKalori = $user ? $user->targetKalori()  : 2000;
        $targetMakro  = $user ? $user->targetMakro()   : [];
        $beratIdeal   = $user ? $user->beratIdeal()    : ['min' => 0, 'max' => 0];

        // Riwayat BMI 12 bulan terakhir (untuk chart)
        $bmiHistory = $this->getBmiHistory($user);

        return view('layout.analytic', compact(
            'user',
            'bmi',
            'bmiKategori',
            'bmr',
            'tdee',
            'targetKalori',
            'targetMakro',
            'beratIdeal',
            'bmiHistory',
        ));
    }

    // ══════════════════════════════
    //  SIMPAN HASIL KALKULASI BMI
    // (AJAX dari form halaman analytic)
    // ══════════════════════════════

    public function saveBmi(Request $request)
    {
        $request->validate([
            'berat_badan'   => 'required|numeric|min:10|max:500',
            'tinggi_badan'  => 'required|numeric|min:50|max:300',
            'umur'          => 'nullable|integer|min:1|max:120',
            'jenis_kelamin' => 'nullable|in:male,female',
            'activity_level'=> 'nullable|numeric',
            'target'        => 'nullable|in:maintenance,loss,gain',
        ]);

        $userId = session('user_id');

        // Update profil user
        $user = User::findOrFail($userId);
        $user->update($request->only(
            'berat_badan', 'tinggi_badan', 'umur', 'jenis_kelamin', 'activity_level', 'target'
        ));

        // Simpan ke histori BMI
        BmiRecord::create([
            'user_id'      => $userId,
            'berat_badan'  => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'recorded_at'  => today()->toDateString(),
        ]);

        $bmi     = $user->hitungBmi();
        $target  = $user->targetMakro();
        $ideal   = $user->beratIdeal();

        // Update session
        session([
            'bmi'           => $bmi,
            'bmi_kategori'  => $user->kategoriBmi(),
            'target_kalori' => $target['kalori'],
            'berat_badan'   => $user->berat_badan,
            'tinggi_badan'  => $user->tinggi_badan,
        ]);

        return response()->json([
            'bmi'          => $bmi,
            'kategori'     => $user->kategoriBmi(),
            'bmr'          => round($user->hitungBmr()),
            'tdee'         => round($user->hitungTdee()),
            'target_kalori'=> $target['kalori'],
            'target_protein'=> $target['protein'],
            'target_carbs' => $target['carbs'],
            'target_fat'   => $target['fat'],
            'berat_ideal'  => $ideal,
        ]);
    }

    // ══════════════════════════════
    //  API: Riwayat BMI per tahun
    // GET /api/analytic/bmi-history?year=2025
    // ══════════════════════════════

    public function bmiHistoryApi(Request $request)
    {
        $year = (int) $request->get('year', now()->year);
        $user = User::find(session('user_id'));

        return response()->json($this->getBmiHistory($user, $year));
    }

    // ══════════════════════════════
    //  PRIVATE HELPER
    // ══════════════════════════════

    private function getBmiHistory(?User $user, int $year = null): array
    {
        if (! $user) {
            return [];
        }

        $year = $year ?? now()->year;

        $records = BmiRecord::where('user_id', $user->id)
            ->whereYear('recorded_at', $year)
            ->orderBy('recorded_at')
            ->get(['recorded_at', 'bmi_value']);

        // Buat array 12 bulan (null jika tidak ada data)
        $bulan = collect(range(1, 12))->map(function (int $m) use ($records, $year) {
            $match = $records->first(
                fn ($r) => Carbon::parse($r->recorded_at)->month === $m
            );
            return [
                'bulan' => Carbon::create($year, $m, 1)->format('M'),
                'bmi'   => $match ? $match->bmi_value : null,
            ];
        });

        return $bulan->toArray();
    }
}
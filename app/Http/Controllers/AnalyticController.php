<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use App\Models\MealPlanPreference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticController extends Controller
{
    private function getUser(): ?User
    {
        $userId = session('user_id');
        if (! $userId && Auth::check()) {
            $userId = Auth::id();
        }
        if (! $userId) return null;
        return User::find($userId);
    }

    private function bmiStatus(float $bmi): string
    {
        return match (true) {
            $bmi < 18.5 => 'underweight',
            $bmi < 25   => 'normal',
            $bmi < 30   => 'overweight',
            $bmi < 35   => 'obese_1',
            $bmi < 40   => 'obese_2',
            default     => 'obese_3',
        };
    }

    private function getMonthlyHistory(int $userId, int $year): array
    {
        $raw = BmiRecord::where('user_id', $userId)
            ->whereYear('recorded_at', $year)
            ->selectRaw('MONTH(recorded_at) as month, AVG(bmi_value) as avg_bmi')
            ->groupByRaw('MONTH(recorded_at)')
            ->orderByRaw('MONTH(recorded_at)')
            ->pluck('avg_bmi', 'month')
            ->toArray();

        $history = [];
        for ($m = 1; $m <= 12; $m++) {
            $history[] = isset($raw[$m]) ? round((float) $raw[$m], 1) : null;
        }
        return $history;
    }

    public function index()
    {
        $user = $this->getUser();
        if (! $user) return redirect()->route('login');

        $height        = (float) ($user->tinggi_badan   ?? 165);
        $weight        = (float) ($user->berat_badan    ?? 58);
        $age           = (int)   ($user->umur           ?? 24);
        $gender        = $user->jenis_kelamin  ?? 'female';
        $activityLevel = (float) ($user->activity_level ?? 1.55);
        $target        = $user->target ?? 'maintain';

        $bmi         = $user->hitungBmi();
        $bmiStatus   = $user->kategoriBmi();
        $idealRange  = $user->beratIdeal();

        // ── Ambil targetMacro dari meal_plan_preferences jika ada ────────
        $pref = MealPlanPreference::where('user_id', $user->id)->first();

        if ($pref) {
            $kalori      = $pref->target_kalori;
            $targetMacro = [
                'kalori'  => $kalori,
                'protein' => (int) round(($kalori * $pref->protein_pct / 100) / 4),
                'carbs'   => (int) round(($kalori * $pref->carbs_pct   / 100) / 4),
                'fat'     => (int) round(($kalori * $pref->fat_pct     / 100) / 9),
            ];
        } else {
            $targetMacro = $user->targetMakro();
        }

        // ── Pakai data dari record terbaru jika ada ──────────────────────
        $latestRecord = BmiRecord::where('user_id', $user->id)
            ->latest('recorded_at')
            ->first();

        if ($latestRecord) {
            $weight = (float) $latestRecord->berat_badan;
            $height = (float) $latestRecord->tinggi_badan;
            $bmi    = (float) $latestRecord->bmi_value;
        }

        $availableYears = BmiRecord::where('user_id', $user->id)
            ->selectRaw('YEAR(recorded_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int) now()->year];
        }

        $currentYear = (int) request('year', $availableYears[0]);
        $bmiHistory  = $this->getMonthlyHistory($user->id, $currentYear);

        return view('layout.analytic', compact(
            'user', 'height', 'weight', 'age', 'gender', 'activityLevel',
            'target', 'bmi', 'bmiStatus', 'idealRange', 'targetMacro',
            'bmiHistory', 'availableYears', 'currentYear', 'pref'
        ));
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'berat_badan'  => 'required|numeric|min:1|max:300',
            'tinggi_badan' => 'required|numeric|min:50|max:250',
        ]);

        $h      = (float) $request->tinggi_badan / 100;
        $bmi    = round((float) $request->berat_badan / ($h ** 2), 2);
        $status = $this->bmiStatus($bmi);

        BmiRecord::updateOrCreate(
            [
                'user_id'     => $user->id,
                'recorded_at' => now()->toDateString(),
            ],
            [
                'berat_badan'  => (float) $request->berat_badan,
                'tinggi_badan' => (float) $request->tinggi_badan,
                'bmi_value'    => $bmi,
                'status'       => $status,
            ]
        );

        return response()->json(['success' => true, 'message' => 'BMI record saved!']);
    }

    public function history(Request $request)
    {
        $user = $this->getUser();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $year    = (int) $request->input('year', now()->year);
        $history = $this->getMonthlyHistory($user->id, $year);

        return response()->json(['data' => $history]);
    }
}
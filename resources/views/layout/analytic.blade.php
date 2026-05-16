@extends('layout.layout')

@section('title', 'Analytics - NutriPlan')

@section('content')
    <style>
        .konten {
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        @media (min-width: 768px) {
            .konten {
                padding-left: 2rem !important;
                padding-right: 2rem !important;
            }
        }
    </style>

    <div class="col-12">

        {{-- Page Header --}}
        <div class="row py-0 mb-1">
            <div class="col-12">
                <p class="mb-0 fw-semibold" style="color:#ea5c2b; font-size:0.78rem; letter-spacing:0.08em;">
                    ✦ YOUR WELLNESS SNAPSHOT
                </p>
                <h4 class="fw-bold mb-0 mt-1">BMI Analysis</h4>
                <p class="text-muted" style="font-size:0.85rem;">
                    Fill in your body data to calculate your BMI and get personalized health insights.
                </p>
            </div>
        </div>

        {{-- TOP ROW --}}
        <div class="row g-3 mb-3">

            {{-- Input Form --}}
            <div class="col-12 col-md-5 col-lg-4">
                <div class="analytic-card h-100">
                    <div class="analytic-card-header">
                        <span class="analytic-icon">🫀</span>
                        <span class="fw-bold">Enter Your Body Data</span>
                    </div>

                    {{--
                        Normalisasi jenis_kelamin dari DB:
                        'Laki-laki' → male | 'Perempuan' → female
                    --}}
                    @php
                        $genderDb = $user->jenis_kelamin ?? 'Perempuan';
                        $isFemale = $genderDb === 'Perempuan';
                        $isMale = $genderDb === 'Laki-laki';
                    @endphp

                    {{-- Gender Card Toggle --}}
                    <div class="mb-3">
                        <label class="analytic-label">Gender</label>
                        <div class="gender-card-wrap">
                            <div class="gender-card {{ $isFemale ? 'active-female' : '' }}" id="card-female">
                                <span class="gender-symbol">♀</span>
                                <span class="gender-card-label">Female</span>
                                <div class="gender-check" id="chk-female">{{ $isFemale ? '✓' : '' }}</div>
                            </div>
                            <div class="gender-card {{ $isMale ? 'active-male' : '' }}" id="card-male">
                                <span class="gender-symbol">♂</span>
                                <span class="gender-card-label">Male</span>
                                <div class="gender-check" id="chk-male">{{ $isMale ? '✓' : '' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- DOB + Activity Level --}}
                    <div class="row py-0 g-2 mb-3">
                        <div class="col-6">
                            <label class="analytic-label">Date of Birth</label>
                            <input type="date" id="dob" class="analytic-input" onchange="calcAge()">
                        </div>
                        <div class="col-6">
                            <label class="analytic-label">Activity Level</label>
                            <select id="activity" class="analytic-input">
                                <option value="1.2" {{ ($user->activity_level ?? 1.55) == 1.2 ? 'selected' : '' }}>
                                    Sedentary</option>
                                <option value="1.375" {{ ($user->activity_level ?? 1.55) == 1.375 ? 'selected' : '' }}>
                                    Lightly active</option>
                                <option value="1.55" {{ ($user->activity_level ?? 1.55) == 1.55 ? 'selected' : '' }}>
                                    Moderately active</option>
                                <option value="1.725" {{ ($user->activity_level ?? 1.55) == 1.725 ? 'selected' : '' }}>Very
                                    active</option>
                                <option value="1.9" {{ ($user->activity_level ?? 1.55) == 1.9 ? 'selected' : '' }}>
                                    Extra active</option>
                            </select>
                        </div>
                    </div>

                    {{-- Height + Weight langsung dari $user --}}
                    <div class="row py-0 g-2 mb-3">
                        <div class="col-6">
                            <label class="analytic-label">Height</label>
                            <div class="input-unit-wrap">
                                <input type="number" id="height-input" class="analytic-input pe-5"
                                    value="{{ $user->tinggi_badan ?? 165 }}" min="50" max="250"
                                    oninput="calcBMI()">
                                <span class="unit-badge">cm</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="analytic-label">Weight</label>
                            <div class="input-unit-wrap">
                                <input type="number" id="weight-input" class="analytic-input pe-5"
                                    value="{{ $user->berat_badan ?? 58 }}" min="1" max="300" step="0.1"
                                    oninput="calcBMI()">
                                <span class="unit-badge">kg</span>
                            </div>
                        </div>
                    </div>

                    {{-- Age dari $user --}}
                    <div class="mb-3">
                        <label class="analytic-label">Age</label>
                        <div class="input-unit-wrap">
                            <input type="number" id="age-input" class="analytic-input pe-5"
                                value="{{ $user->umur ?? 24 }}" min="1" max="120" oninput="calcBMI()">
                            <span class="unit-badge">years</span>
                        </div>
                    </div>

                    <button class="btn-calculate w-100" id="btn-calc" onclick="calcAndSaveBMI()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Calculate &amp; Save BMI
                    </button>

                    <div id="save-feedback" class="mt-2 text-center" style="font-size:0.78rem; display:none;"></div>
                </div>
            </div>

            {{-- Gauge + Classification --}}
            <div class="col-12 col-md-7 col-lg-8">
                <div class="row g-3 h-100">

                    {{-- Gauge --}}
                    <div class="col-12 col-sm-6">
                        <div class="analytic-card h-100 text-center">
                            <div class="analytic-card-header justify-content-center mb-2">
                                <span class="analytic-icon">🎯</span>
                                <span class="fw-bold">Your BMI Result</span>
                            </div>
                            <div class="gauge-wrap">
                                <svg viewBox="0 0 200 120" class="gauge-svg">
                                    <path d="M20,100 A80,80 0 0,1 60,26" stroke="#60A5FA" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <path d="M62,25  A80,80 0 0,1 110,20" stroke="#34D399" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <path d="M112,20 A80,80 0 0,1 155,38" stroke="#FBBF24" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <path d="M157,40 A80,80 0 0,1 180,100" stroke="#F87171" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <line id="bmi-needle" x1="100" y1="100" x2="100" y2="28"
                                        stroke="#1F2937" stroke-width="3" stroke-linecap="round"
                                        transform="rotate(0, 100, 100)" style="transition: transform 0.6s ease;" />
                                    <circle cx="100" cy="100" r="5" fill="#1F2937" />
                                </svg>
                                <div class="gauge-value-wrap">
                                    <span class="gauge-number" id="bmi-display">{{ number_format($bmi ?? 0, 1) }}</span>
                                    <span class="gauge-unit">kg/m²</span>
                                </div>
                            </div>
                            <p class="fw-bold mt-2 mb-1" id="bmi-label" style="font-size:1rem;">●
                                {{ $bmiStatus ?? 'Normal' }}</p>
                            <p class="text-muted" style="font-size:0.78rem;" id="bmi-message"></p>
                        </div>
                    </div>

                    {{-- Classification --}}
                    <div class="col-12 col-sm-6">
                        <div class="analytic-card h-100">
                            <div class="analytic-card-header mb-3">
                                <span class="analytic-icon">📊</span>
                                <span class="fw-bold">BMI Classification</span>
                            </div>
                            @php
                                $bv = $bmi ?? 0;
                                $cls = [
                                    [
                                        'id' => 'cls-underweight',
                                        'color' => '#60A5FA',
                                        'label' => 'Underweight',
                                        'range' => '< 18.5',
                                        'active' => $bv < 18.5,
                                    ],
                                    [
                                        'id' => 'cls-normal',
                                        'color' => '#34D399',
                                        'label' => 'Normal weight',
                                        'range' => '18.5 – 24.9',
                                        'active' => $bv >= 18.5 && $bv < 25,
                                    ],
                                    [
                                        'id' => 'cls-overweight',
                                        'color' => '#FBBF24',
                                        'label' => 'Overweight',
                                        'range' => '25.0 – 29.9',
                                        'active' => $bv >= 25 && $bv < 30,
                                    ],
                                    [
                                        'id' => 'cls-ob1',
                                        'color' => '#fb923c',
                                        'label' => 'Obesity I',
                                        'range' => '30.0 – 34.9',
                                        'active' => $bv >= 30 && $bv < 35,
                                    ],
                                    [
                                        'id' => 'cls-ob2',
                                        'color' => '#f97316',
                                        'label' => 'Obesity II',
                                        'range' => '35.0 – 39.9',
                                        'active' => $bv >= 35 && $bv < 40,
                                    ],
                                    [
                                        'id' => 'cls-ob3',
                                        'color' => '#ef4444',
                                        'label' => 'Obesity III',
                                        'range' => '≥ 40.0',
                                        'active' => $bv >= 40,
                                    ],
                                ];
                            @endphp
                            <div class="bmi-class-list">
                                @foreach ($cls as $c)
                                    <div class="bmi-class-row {{ $c['active'] ? 'active-class' : '' }}"
                                        id="{{ $c['id'] }}">
                                        <span class="bmi-dot" style="background:{{ $c['color'] }};"></span>
                                        <span
                                            class="bmi-class-name {{ $c['active'] ? 'fw-bold' : '' }}">{{ $c['label'] }}</span>
                                        <span class="bmi-you-badge ms-1"
                                            style="display:{{ $c['active'] ? 'inline' : 'none' }};">YOU</span>
                                        <span class="bmi-class-range ms-auto">{{ $c['range'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM ROW --}}
        <div class="row g-3 mb-4">

            {{-- Body Data Summary --}}
            <div class="col-12 col-md-4">
                <div class="analytic-card h-100">
                    <div class="analytic-card-header mb-3">
                        <span class="analytic-icon">⚖️</span>
                        <span class="fw-bold">Body Data Summary</span>
                    </div>
                    <div class="summary-list">
                        <div class="summary-row">
                            <span class="summary-icon">📏</span>
                            <span class="summary-label">Height</span>
                            <span class="summary-value" id="sum-height">{{ $user->tinggi_badan ?? 165 }} cm</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">⚖️</span>
                            <span class="summary-label">Weight</span>
                            <span class="summary-value" id="sum-weight">{{ $user->berat_badan ?? 58 }} kg</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">💓</span>
                            <span class="summary-label">BMI</span>
                            <span class="summary-value fw-bold" style="color:#ea5c2b;"
                                id="sum-bmi">{{ number_format($bmi ?? 0, 1) }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🎯</span>
                            <span class="summary-label">Category</span>
                            <span class="badge-category" id="sum-category">{{ $bmiStatus ?? 'Normal' }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🫀</span>
                            <span class="summary-label">Ideal Weight Range</span>
                            <span class="summary-value" id="sum-ideal">
                                {{ $idealRange['min'] ?? '–' }} – {{ $idealRange['max'] ?? '–' }} kg
                            </span>
                        </div>
                        {{-- GANTI JADI --}}
                        <div class="summary-row">
                            <span class="summary-icon">🔥</span>
                            <span class="summary-label">Daily Calorie Target</span>
                            <span class="summary-value">
                                {{ number_format($targetMacro['kalori'] ?? 0) }} kcal
                                @if ($pref)
                                    <span style="font-size:0.65rem; color:#95cd41; font-weight:700; margin-left:4px;">✦
                                        custom</span>
                                @endif
                            </span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🥩</span>
                            <span class="summary-label">Protein</span>
                            <span class="summary-value">
                                {{ $targetMacro['protein'] ?? 0 }} g
                                @if ($pref)
                                    <span style="font-size:0.65rem; color:#6B7280;">({{ $pref->protein_pct }}%)</span>
                                @endif
                            </span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🍚</span>
                            <span class="summary-label">Carbs</span>
                            <span class="summary-value">
                                {{ $targetMacro['carbs'] ?? 0 }} g
                                @if ($pref)
                                    <span style="font-size:0.65rem; color:#6B7280;">({{ $pref->carbs_pct }}%)</span>
                                @endif
                            </span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🫒</span>
                            <span class="summary-label">Fat</span>
                            <span class="summary-value">
                                {{ $targetMacro['fat'] ?? 0 }} g
                                @if ($pref)
                                    <span style="font-size:0.65rem; color:#6B7280;">({{ $pref->fat_pct }}%)</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <p class="mt-2 mb-0" style="font-size:0.65rem; color:#9CA3AF;">
                        * Ideal weight range = BMI 18.5–24.9 &nbsp;|&nbsp;
                        @if ($pref)
                            Macros from your <strong>meal plan preferences</strong>
                            <a href="/meal_plan" style="color:#95cd41; text-decoration:none;">· edit</a>
                        @else
                            Macros based on your <strong>{{ $user->target ?? 'maintenance' }}</strong> goal
                        @endif
                    </p>
                </div>
            </div>

            {{-- Health Insights --}}
            <div class="col-12 col-md-4">
                <div class="analytic-card h-100">
                    <div class="analytic-card-header mb-3">
                        <span class="analytic-icon">🌿</span>
                        <span class="fw-bold">Health Insights</span>
                    </div>
                    <div class="d-flex flex-column gap-2" id="health-insights-list"></div>
                </div>
            </div>

            {{-- BMI History --}}
            <div class="col-12 col-md-4">
                <div class="analytic-card h-100">
                    <div class="analytic-card-header mb-1">
                        <span class="analytic-icon">📈</span>
                        <span class="fw-bold">BMI History</span>
                        <select class="ms-auto analytic-input"
                            style="max-width:90px; font-size:0.72rem; padding:0.15rem 0.5rem;" id="history-year">
                            @foreach ($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $yr == $currentYear ? 'selected' : '' }}>
                                    {{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="bmiHistoryChart"></canvas>
                    </div>
                    <div class="insight-card insight-green mt-2">
                        <div class="insight-icon-wrap" style="background:#DCFCE7; font-size:0.9rem;">📈</div>
                        <div>
                            <p class="insight-body mb-0" id="history-insight-text">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Banner --}}
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="cta-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="cta-icon">🍽️</div>
                        <div>
                            <h6 class="fw-bold mb-0">Want to improve your health even more?</h6>
                            <p class="mb-0 text-muted" style="font-size:0.83rem;">Get a personalized meal plan that fits
                                your body and goals!</p>
                        </div>
                    </div>
                    <a href="/meal_plan" class="btn-create-plan">✦ Create My Meal Plan</a>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        /* ── Base Card ──────────────────────────────────────────────── */
        .analytic-card {
            border-radius: 18px;
            background: rgba(255, 248, 240, 0.92);
            box-shadow: 0 4px 20px rgba(140, 136, 136, 0.15);
            backdrop-filter: blur(8px);
            border: 0.8px solid rgba(0, 0, 0, 0.07);
            padding: 1.25rem;
        }

        .analytic-card-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .analytic-icon {
            font-size: 1.1rem;
        }

        /* ── Gender Card Toggle ─────────────────────────────────────── */
        .gender-card-wrap {
            display: flex;
            gap: 10px;
        }

        .gender-card {
            flex: 1;
            border: 1.5px solid #E5E7EB;
            border-radius: 14px;
            padding: 12px 8px 10px;
            cursor: pointer;
            text-align: center;
            background: #F9FAFB;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            transition: all 0.18s ease;
            user-select: none;
            -webkit-user-select: none;
        }

        .gender-card:hover {
            border-color: #D1D5DB;
            background: #fff;
        }

        .gender-card.active-female {
            border-color: #ea5c2b;
            background: #fff5f2;
            box-shadow: 0 0 0 3px rgba(234, 92, 43, 0.10);
        }

        .gender-card.active-male {
            border-color: #3B82F6;
            background: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
        }

        /* pointer-events:none pada child agar click selalu ke parent card */
        .gender-card .gender-symbol,
        .gender-card .gender-card-label,
        .gender-card .gender-check {
            pointer-events: none;
        }

        .gender-symbol {
            font-size: 22px;
            line-height: 1;
            color: #9CA3AF;
            transition: color 0.18s;
        }

        .gender-card.active-female .gender-symbol {
            color: #ea5c2b;
        }

        .gender-card.active-male .gender-symbol {
            color: #3B82F6;
        }

        .gender-card-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6B7280;
            transition: color 0.18s;
        }

        .gender-card.active-female .gender-card-label {
            color: #ea5c2b;
        }

        .gender-card.active-male .gender-card-label {
            color: #3B82F6;
        }

        .gender-check {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1.5px solid #E5E7EB;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-top: 2px;
            transition: all 0.18s;
            font-weight: 700;
        }

        .gender-card.active-female .gender-check {
            background: #ea5c2b;
            border-color: #ea5c2b;
        }

        .gender-card.active-male .gender-check {
            background: #3B82F6;
            border-color: #3B82F6;
        }

        /* ── Form Inputs ─────────────────────────────────────────────── */
        .analytic-label {
            font-size: 0.78rem;
            color: #374151;
            font-weight: 600;
            display: block;
            margin-bottom: 0.2rem;
        }

        .analytic-input {
            width: 100%;
            border-radius: 10px;
            border: 1.5px solid #E5E7EB;
            background: #F9FAFB;
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            color: #374151;
            outline: none;
            transition: border-color 0.2s;
        }

        .analytic-input:focus {
            border-color: #95cd41;
        }

        .input-unit-wrap {
            position: relative;
        }

        .unit-badge {
            position: absolute;
            right: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.72rem;
            color: #9CA3AF;
            pointer-events: none;
        }

        /* ── Calculate Button ────────────────────────────────────────── */
        .btn-calculate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            border-radius: 50px;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.65rem 1rem;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(149, 205, 65, 0.35);
            transition: all 0.25s;
        }

        .btn-calculate:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn-calculate:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ── Gauge ───────────────────────────────────────────────────── */
        .gauge-wrap {
            position: relative;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }

        .gauge-svg {
            width: 100%;
            height: auto;
        }

        .gauge-value-wrap {
            position: absolute;
            bottom: 8%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            line-height: 1.1;
        }

        .gauge-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1F2937;
        }

        .gauge-unit {
            font-size: 0.65rem;
            color: #6B7280;
            display: block;
        }

        /* ── BMI Classification ──────────────────────────────────────── */
        .bmi-class-list {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .bmi-class-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 10px;
            padding: 0.35rem 0.6rem;
            font-size: 0.83rem;
            transition: background 0.2s;
        }

        .bmi-class-row.active-class {
            background: rgba(149, 205, 65, 0.12);
        }

        .bmi-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .bmi-class-name {
            font-size: 0.83rem;
            color: #374151;
        }

        .bmi-class-range {
            font-size: 0.78rem;
            color: #6B7280;
        }

        .bmi-you-badge {
            font-size: 0.6rem;
            font-weight: 700;
            background: #95cd41;
            color: #fff;
            border-radius: 50px;
            padding: 1px 6px;
        }

        /* ── Summary ─────────────────────────────────────────────────── */
        .summary-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .summary-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0;
            border-bottom: 0.8px solid rgba(0, 0, 0, 0.06);
            font-size: 0.83rem;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-icon {
            font-size: 1rem;
        }

        .summary-label {
            color: #6B7280;
        }

        .summary-value {
            margin-left: auto;
            font-weight: 500;
            color: #1F2937;
        }

        .badge-category {
            margin-left: auto;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(149, 205, 65, 0.15);
            color: #446611;
            border-radius: 50px;
            padding: 2px 10px;
        }

        /* ── Insight Cards ───────────────────────────────────────────── */
        .insight-card {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            border-radius: 12px;
            padding: 0.65rem 0.75rem;
        }

        .insight-green {
            background: rgba(220, 252, 231, 0.6);
        }

        .insight-orange {
            background: rgba(255, 237, 213, 0.6);
        }

        .insight-blue {
            background: rgba(219, 234, 254, 0.6);
        }

        .insight-red {
            background: rgba(254, 226, 226, 0.6);
        }

        .insight-icon-wrap {
            font-size: 1.1rem;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .insight-title {
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .insight-body {
            font-size: 0.75rem;
            color: #374151;
            margin-bottom: 0;
        }

        /* ── Chart ───────────────────────────────────────────────────── */
        .chart-wrap {
            position: relative;
            height: 130px;
        }

        /* ── CTA Banner ──────────────────────────────────────────────── */
        .cta-banner {
            border-radius: 18px;
            background: rgba(255, 248, 240, 0.92);
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 20px rgba(140, 136, 136, 0.15);
            border: 0.8px solid rgba(0, 0, 0, 0.07);
            padding: 1.25rem 1.75rem;
        }

        .cta-icon {
            font-size: 2.5rem;
        }

        .btn-create-plan {
            background: linear-gradient(90deg, #ea5c2b 0%, #f97316 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            border-radius: 50px;
            padding: 0.65rem 1.5rem;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(234, 92, 43, 0.35);
            transition: all 0.25s;
            white-space: nowrap;
        }

        .btn-create-plan:hover {
            opacity: 0.88;
            transform: translateY(-1px);
            color: #fff;
        }

        /* ── Responsive ──────────────────────────────────────────────── */
        @media (max-width:767px) {
            .analytic-card {
                padding: 1rem;
            }

            .cta-banner {
                padding: 1rem 1.25rem;
            }

            .gauge-number {
                font-size: 1.4rem;
            }
        }

        @media (max-width:480px) {
            .bmi-class-row {
                font-size: 0.75rem;
            }

            .summary-row {
                font-size: 0.78rem;
            }
        }
    </style>

    <script>
        // ── Konstanta dari PHP → JS ───────────────────────────────────────
        // Normalisasi 'Laki-laki' → 'male', 'Perempuan' → 'female'
        const SERVER_GENDER = '{{ $user->jenis_kelamin === 'Laki-laki' ? 'male' : 'female' }}';
        const SERVER_HEIGHT = {{ $user->tinggi_badan ?? 165 }};
        const SERVER_WEIGHT = {{ $user->berat_badan ?? 58 }};
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const STORE_ROUTE = '{{ route('analytic.store') }}'.replace('http://', 'https://');
        const HISTORY_ROUTE = '{{ route('analytic.history') }}'.replace('http://', 'https://');
        const BMI_HISTORY = @json($bmiHistory ?? []);
        const CURRENT_YEAR = {{ $currentYear ?? now()->year }};

        // ── State ─────────────────────────────────────────────────────────
        let currentGender = SERVER_GENDER;
        let bmiChart;
        const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // ── Gender toggle ─────────────────────────────────────────────────
        // Semua child pakai pointer-events:none di CSS → click selalu naik ke card
        function setGender(g) {
            currentGender = g;
            document.getElementById('card-female').className = 'gender-card' + (g === 'female' ? ' active-female' : '');
            document.getElementById('card-male').className = 'gender-card' + (g === 'male' ? ' active-male' : '');
            document.getElementById('chk-female').textContent = (g === 'female') ? '✓' : '';
            document.getElementById('chk-male').textContent = (g === 'male') ? '✓' : '';
            calcBMI();
        }

        // ── Age dari DOB ──────────────────────────────────────────────────
        function calcAge() {
            const dob = document.getElementById('dob').value;
            if (!dob) return;
            const today = new Date(),
                birth = new Date(dob);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            document.getElementById('age-input').value = age > 0 ? age : '';
            calcBMI();
        }

        // ── Kalkulasi BMI + update UI ─────────────────────────────────────
        function calcBMI() {
            const h = parseFloat(document.getElementById('height-input').value) || SERVER_HEIGHT;
            const w = parseFloat(document.getElementById('weight-input').value) || SERVER_WEIGHT;
            const age = parseInt(document.getElementById('age-input').value) || 25;
            const hm = h / 100;
            const bmi = w / (hm * hm);
            const bmiRounded = bmi.toFixed(1);

            // ── Body Fat % — Deurenberg formula (berbeda per gender) ──────────
            // Male:   BF% = (1.20 × BMI) + (0.23 × age) − 10.8 × 1 − 5.4
            // Female: BF% = (1.20 × BMI) + (0.23 × age) − 10.8 × 0 − 5.4
            const genderFactor = (currentGender === 'male') ? 1 : 0;
            const bodyFat = (1.20 * bmi) + (0.23 * age) - (10.8 * genderFactor) - 5.4;
            const bodyFatDisplay = Math.max(0, bodyFat).toFixed(1);

            // ── Update tampilan ───────────────────────────────────────────────
            document.getElementById('bmi-display').textContent = bmiRounded;
            document.getElementById('sum-bmi').textContent = bmiRounded;
            document.getElementById('sum-height').textContent = h + ' cm';
            document.getElementById('sum-weight').textContent = w + ' kg';

            const idealMin = (18.5 * hm * hm).toFixed(1);
            const idealMax = (24.9 * hm * hm).toFixed(1);
            document.getElementById('sum-ideal').textContent = idealMin + ' – ' + idealMax + ' kg';

            // ── Label, warna, dan needle gauge ────────────────────────────────
            let label, color, msg, catText, needleAngle;
            const isMale = currentGender === 'male';

            if (bmi < 18.5) {
                label = '● Underweight';
                color = '#60A5FA';
                catText = 'Underweight';
                msg = isMale ?
                    'Your BMI is below normal. Men should aim for a healthy weight through protein-rich foods and strength training.' :
                    'Your BMI is below normal. Focus on nutrient-dense foods and consult a nutritionist for a balanced plan.';
                needleAngle = mapRange(bmi, 10, 18.5, -90, -30);
            } else if (bmi < 25) {
                label = '● Normal Weight';
                color = '#34D399';
                catText = 'Normal Weight';
                msg = isMale ?
                    'Great! Your BMI is normal. Estimated body fat: ' + bodyFatDisplay +
                    '% — healthy range for men is 8–20%.' :
                    'Great! Your BMI is normal. Estimated body fat: ' + bodyFatDisplay +
                    '% — healthy range for women is 21–33%.';
                needleAngle = mapRange(bmi, 18.5, 25, -30, 10);
            } else if (bmi < 30) {
                label = '● Overweight';
                color = '#FBBF24';
                catText = 'Overweight';
                msg = isMale ?
                    'BMI above normal. Estimated body fat: ' + bodyFatDisplay +
                    '% — men above 25% body fat carry higher metabolic risk.' :
                    'BMI above normal. Estimated body fat: ' + bodyFatDisplay +
                    '% — women above 33% body fat carry higher metabolic risk.';
                needleAngle = mapRange(bmi, 25, 30, 10, 50);
            } else if (bmi < 35) {
                label = '● Obesity I';
                color = '#fb923c';
                catText = 'Obesity I';
                msg = 'Estimated body fat: ' + bodyFatDisplay +
                    '%. Please consult a healthcare professional for a personalized plan.';
                needleAngle = mapRange(bmi, 30, 35, 50, 70);
            } else if (bmi < 40) {
                label = '● Obesity II';
                color = '#f97316';
                catText = 'Obesity II';
                msg = 'Your BMI indicates Obesity II. Medical guidance is strongly recommended.';
                needleAngle = mapRange(bmi, 35, 40, 70, 85);
            } else {
                label = '● Obesity III';
                color = '#ef4444';
                catText = 'Obesity III';
                msg = 'Your BMI indicates Obesity III. Please seek medical advice promptly.';
                needleAngle = 90;
            }

            document.getElementById('bmi-label').textContent = label;
            document.getElementById('bmi-label').style.color = color;
            document.getElementById('bmi-message').textContent = msg;
            document.getElementById('bmi-needle').setAttribute('transform', 'rotate(' + needleAngle + ', 100, 100)');
            document.getElementById('sum-category').textContent = catText;

            // ── Highlight classification row ──────────────────────────────────
            const rowIds = ['cls-underweight', 'cls-normal', 'cls-overweight', 'cls-ob1', 'cls-ob2', 'cls-ob3'];
            const active = [bmi < 18.5, bmi >= 18.5 && bmi < 25, bmi >= 25 && bmi < 30, bmi >= 30 && bmi < 35, bmi >= 35 &&
                bmi < 40, bmi >= 40
            ];
            rowIds.forEach(function(id, i) {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.toggle('active-class', active[i]);
                var nameEl = el.querySelector('.bmi-class-name');
                if (nameEl) nameEl.classList.toggle('fw-bold', active[i]);
                var badge = el.querySelector('.bmi-you-badge');
                if (badge) badge.style.display = active[i] ? 'inline' : 'none';
            });

            updateInsights(bmi, currentGender, bodyFatDisplay);
        }

        function mapRange(v, inMin, inMax, outMin, outMax) {
            return (v - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
        }

        // BARU
        function updateInsights(bmi, gender, bodyFatPct) {
            const isMale = gender === 'male';
            const container = document.getElementById('health-insights-list');
            var insights = [];

            if (bmi < 18.5) {
                insights = [{
                        cls: 'insight-blue',
                        bg: '#DBEAFE',
                        icon: '🍽️',
                        color: '#2563EB',
                        title: isMale ? 'Increase protein & calories' : 'Focus on nutrient-dense foods',
                        body: isMale ?
                            'Prioritize lean protein (chicken, eggs, legumes) and complex carbs to build mass.' :
                            'Include healthy fats, whole grains, and iron-rich foods to reach a healthy weight.'
                    },
                    {
                        cls: 'insight-orange',
                        bg: '#FFEDD5',
                        icon: '🏋️',
                        color: '#ea5c2b',
                        title: isMale ? 'Add resistance training' : 'Gentle strength exercises',
                        body: isMale ? 'Weight training helps build muscle — target 3× per week with compound lifts.' :
                            'Light resistance exercises like yoga or bodyweight training help build lean mass.'
                    },
                    {
                        cls: 'insight-green',
                        bg: '#DCFCE7',
                        icon: '💧',
                        color: '#16A34A',
                        title: 'Stay hydrated!',
                        body: 'Drink enough water every day to support nutrient absorption.'
                    },
                ];
            } else if (bmi < 25) {
                insights = [{
                        cls: 'insight-green',
                        bg: '#DCFCE7',
                        icon: '🫀',
                        color: '#16A34A',
                        title: "You're in the healthy range!",
                        body: 'Estimated body fat ' + bodyFatPct + '%. ' +
                            (isMale ? 'Healthy men typically have 8–20% body fat.' :
                                'Healthy women typically have 21–33% body fat.')
                    },
                    {
                        cls: 'insight-orange',
                        bg: '#FFEDD5',
                        icon: '🏃',
                        color: '#ea5c2b',
                        title: isMale ? 'Maintain with cardio + lifting' : 'Stay active with balanced exercise',
                        body: isMale ? 'Combine cardio and strength training to stay lean and maintain muscle mass.' :
                            'Mix cardio with strength training to maintain bone density and energy levels.'
                    },
                    {
                        cls: 'insight-blue',
                        bg: '#DBEAFE',
                        icon: '💧',
                        color: '#2563EB',
                        title: 'Stay hydrated!',
                        body: 'Drink 2–3 L of water daily to support your overall health.'
                    },
                ];
            } else if (bmi < 30) {
                insights = [{
                        cls: 'insight-orange',
                        bg: '#FFEDD5',
                        icon: '⚠️',
                        color: '#ea5c2b',
                        title: 'Consider lifestyle changes',
                        body: 'Estimated body fat ' + bodyFatPct + '%. ' +
                            (isMale ? 'Men above 25% body fat face higher risk of metabolic syndrome.' :
                                'Women above 33% body fat have higher cardiovascular risk.')
                    },
                    {
                        cls: 'insight-green',
                        bg: '#DCFCE7',
                        icon: '🥗',
                        color: '#16A34A',
                        title: 'Eat more vegetables & fiber',
                        body: 'Add fiber-rich foods to your meals to feel full longer and reduce calorie intake.'
                    },
                    {
                        cls: 'insight-blue',
                        bg: '#DBEAFE',
                        icon: '🚶',
                        color: '#2563EB',
                        title: 'Walk 30 min/day',
                        body: 'Daily walks are a simple and effective way to improve your metabolic health.'
                    },
                ];
            } else {
                insights = [{
                        cls: 'insight-red',
                        bg: '#FEE2E2',
                        icon: '🏥',
                        color: '#DC2626',
                        title: 'Consult a professional',
                        body: 'Your BMI is in the obese range. Please speak with a healthcare provider for personalized guidance.'
                    },
                    {
                        cls: 'insight-orange',
                        bg: '#FFEDD5',
                        icon: '🥗',
                        color: '#ea5c2b',
                        title: 'Start with small diet changes',
                        body: 'Reduce processed foods and increase vegetables, lean protein, and water intake.'
                    },
                    {
                        cls: 'insight-blue',
                        bg: '#DBEAFE',
                        icon: '💧',
                        color: '#2563EB',
                        title: 'Hydration is key',
                        body: 'Drinking more water supports metabolism and reduces unnecessary snacking.'
                    },
                ];
            }

            container.innerHTML = insights.map(function(i) {
                return '<div class="insight-card ' + i.cls + '">' +
                    '<div class="insight-icon-wrap" style="background:' + i.bg + ';">' + i.icon + '</div>' +
                    '<div><p class="insight-title" style="color:' + i.color + ';">' + i.title + '</p>' +
                    '<p class="insight-body">' + i.body + '</p></div></div>';
            }).join('');
        }

        // ── Simpan BMI ke database via AJAX ───────────────────────────────
        async function calcAndSaveBMI() {
            calcBMI();

            const h = parseFloat(document.getElementById('height-input').value);
            const w = parseFloat(document.getElementById('weight-input').value);

            if (!h || !w || h <= 0 || w <= 0) {
                alert('Please enter valid height and weight.');
                return;
            }

            const btn = document.getElementById('btn-calc');
            const feedback = document.getElementById('save-feedback');
            btn.disabled = true;
            btn.textContent = 'Saving…';

            try {
                const res = await fetch(STORE_ROUTE, {
                    method: 'POST',
                    credentials: 'same-origin', // ← FIX: kirim session cookie
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest', // ← FIX: tandai sebagai AJAX
                    },
                    body: JSON.stringify({
                        berat_badan: w,
                        tinggi_badan: h,
                    }),
                });

                const contentType = res.headers.get('content-type') || '';
                if (!contentType.includes('application/json')) {
                    feedback.style.display = 'block';
                    feedback.style.color = '#DC2626';
                    feedback.textContent = '✗ Session expired. Please refresh the page and login again.';
                    return;
                }

                const data = await res.json();
                feedback.style.display = 'block';

                if (res.ok && data.success) {
                    feedback.style.color = '#16A34A';
                    feedback.textContent = '✓ BMI saved to your history!';
                    if (bmiChart) {
                        await loadHistoryChart(CURRENT_YEAR, bmiChart);
                    }
                } else {
                    feedback.style.color = '#DC2626';
                    feedback.textContent = '✗ ' + (data.message || 'Failed to save. Try again.');
                }
            } catch (err) {
                console.error('Save BMI error:', err);
                feedback.style.display = 'block';
                feedback.style.color = '#DC2626';
                feedback.textContent = '✗ Network error. Try again.';
            } finally {
                btn.disabled = false;
                btn.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg> Calculate &amp; Save BMI';
                setTimeout(function() {
                    feedback.style.display = 'none';
                }, 5000);
            }
        }

        // ── BMI History Chart ─────────────────────────────────────────────
        async function loadHistoryChart(year, chart) {
            try {
                const res = await fetch(HISTORY_ROUTE + '?year=' + year, {
                    credentials: 'same-origin', // ← tambah ini
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                const json = await res.json();
                chart.data.datasets[0].data = json.data;
                chart.update();
                updateHistoryInsight(json.data);
            } catch (e) {
                console.error('History load failed', e);
            }
        }

        function updateHistoryInsight(data) {
            var valid = data.filter(function(v) {
                return v !== null;
            });
            var el = document.getElementById('history-insight-text');
            if (valid.length === 0) {
                el.textContent = 'No BMI records yet this year. Calculate and save to start tracking!';
                return;
            }
            if (valid.length === 1) {
                el.textContent = 'Only one record this year (BMI ' + valid[0] + '). Keep tracking to see your progress!';
                return;
            }
            var diff = (valid[valid.length - 1] - valid[0]).toFixed(1);
            if (Math.abs(diff) < 0.3) el.textContent = 'Your BMI has been stable. Keep maintaining your healthy lifestyle!';
            else if (diff < 0) el.textContent = 'Great progress! Your BMI dropped by ' + Math.abs(diff) +
                ' this year. Keep it up!';
            else el.textContent = 'Your BMI increased by ' + diff +
                ' this year. Consider adjusting your diet and activity level.';
        }

        // ── Init ──────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function() {

            // Pasang listener gender — pakai addEventListener bukan onclick
            // agar tidak ada konflik, dan pointer-events:none pada child sudah diset di CSS
            document.getElementById('card-female').addEventListener('click', function() {
                setGender('female');
            });
            document.getElementById('card-male').addEventListener('click', function() {
                setGender('male');
            });

            // Keyboard accessibility
            ['card-female', 'card-male'].forEach(function(id) {
                document.getElementById(id).addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Jalankan kalkulasi awal
            calcBMI();

            // Init chart
            var ctx = document.getElementById('bmiHistoryChart').getContext('2d');
            bmiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: MONTHS,
                    datasets: [{
                        label: 'BMI',
                        data: BMI_HISTORY,
                        borderColor: '#95cd41',
                        backgroundColor: 'rgba(149,205,65,0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#95cd41',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.35,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                        spanGaps: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 9
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 9
                                },
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            min: 15,
                            max: 40
                        }
                    }
                }
            });

            updateHistoryInsight(BMI_HISTORY);

            document.getElementById('history-year').addEventListener('change', function() {
                loadHistoryChart(this.value, bmiChart);
            });
        });
    </script>
@endsection

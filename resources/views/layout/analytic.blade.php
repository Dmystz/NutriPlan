@extends('layout.layout')

@section('title', 'Analytics - NutriPlan')

@section('content')
    {{-- Override padding layout khusus halaman analytic --}}
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

        {{-- TOP ROW: Input Form + BMI Result + BMI Classification --}}
        <div class="row g-3 mb-3">

            {{-- Body Data Input Form --}}
            <div class="col-12 col-md-5 col-lg-4">
                <div class="analytic-card h-100">
                    <div class="analytic-card-header">
                        <span class="analytic-icon">🫀</span>
                        <span class="fw-bold">Enter Your Body Data</span>
                    </div>

                    {{-- Gender Toggle --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span style="font-size:0.88rem; color:#374151;">Gender</span>
                        <div class="gender-toggle">
                            <button class="gender-btn active" id="btn-female" onclick="setGender('female')">Female</button>
                            <button class="gender-btn" id="btn-male" onclick="setGender('male')">Male</button>
                        </div>
                    </div>

                    {{-- DOB + Activity Level --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="analytic-label">Date of Birth</label>
                            <input type="date" id="dob" class="analytic-input" onchange="calcAge()">
                        </div>
                        <div class="col-6">
                            <label class="analytic-label">Activity Level</label>
                            <select id="activity" class="analytic-input">
                                <option value="1.2">Sedentary</option>
                                <option value="1.375">Lightly active</option>
                                <option value="1.55" selected>Moderately active</option>
                                <option value="1.725">Very active</option>
                                <option value="1.9">Extra active</option>
                            </select>
                        </div>
                    </div>

                    {{-- Height + Weight --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="analytic-label">Height</label>
                            <div class="input-unit-wrap">
                                <input type="number" id="height-input" class="analytic-input pe-5" value="165"
                                    min="50" max="250" oninput="calcBMI()">
                                <span class="unit-badge">cm</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="analytic-label">Weight</label>
                            <div class="input-unit-wrap">
                                <input type="number" id="weight-input" class="analytic-input pe-5" value="58"
                                    min="1" max="300" step="0.1" oninput="calcBMI()">
                                <span class="unit-badge">kg</span>
                            </div>
                        </div>
                    </div>

                    {{-- Age (calculated) --}}
                    <div class="mb-3">
                        <label class="analytic-label">Age</label>
                        <div class="input-unit-wrap">
                            <input type="number" id="age-input" class="analytic-input pe-5" value="24" min="1"
                                max="120" oninput="calcBMI()">
                            <span class="unit-badge">years</span>
                        </div>
                    </div>

                    <button class="btn-calculate w-100" onclick="calcBMI()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Calculate BMI
                    </button>
                </div>
            </div>

            {{-- BMI Result Gauge --}}
            <div class="col-12 col-md-7 col-lg-8">
                <div class="row g-3 h-100">
                    <div class="col-12 col-sm-6">
                        <div class="analytic-card h-100 text-center">
                            <div class="analytic-card-header justify-content-center mb-2">
                                <span class="analytic-icon">🎯</span>
                                <span class="fw-bold">Your BMI Result</span>
                            </div>

                            {{-- Gauge SVG --}}
                            <div class="gauge-wrap">
                                <svg viewBox="0 0 200 120" class="gauge-svg">
                                    <!-- Background arcs -->
                                    <path d="M20,100 A80,80 0 0,1 60,26" stroke="#60A5FA" stroke-width="16" fill="none"
                                        stroke-linecap="round" />
                                    <path d="M62,25 A80,80 0 0,1 110,20" stroke="#34D399" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <path d="M112,20 A80,80 0 0,1 155,38" stroke="#FBBF24" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <path d="M157,40 A80,80 0 0,1 180,100" stroke="#F87171" stroke-width="16"
                                        fill="none" stroke-linecap="round" />
                                    <!-- Needle -->
                                    <line id="bmi-needle" x1="100" y1="100" x2="100" y2="28"
                                        stroke="#1F2937" stroke-width="3" stroke-linecap="round"
                                        transform="rotate(0, 100, 100)" style="transition: transform 0.6s ease;" />
                                    <circle cx="100" cy="100" r="5" fill="#1F2937" />
                                </svg>
                                <div class="gauge-value-wrap">
                                    <span class="gauge-number" id="bmi-display">21.3</span>
                                    <span class="gauge-unit">kg/m²</span>
                                </div>
                            </div>

                            <p class="fw-bold mt-2 mb-1" id="bmi-label" style="color:#34D399; font-size:1rem;">● Normal
                                Weight</p>
                            <p class="text-muted" style="font-size:0.78rem;" id="bmi-message">
                                Great! Your BMI is in the normal range. Keep up the good work and maintain a healthy
                                lifestyle.
                            </p>
                        </div>
                    </div>

                    {{-- BMI Classification --}}
                    <div class="col-12 col-sm-6">
                        <div class="analytic-card h-100">
                            <div class="analytic-card-header mb-3">
                                <span class="analytic-icon">📊</span>
                                <span class="fw-bold">BMI Classification</span>
                            </div>
                            <div class="bmi-class-list">
                                <div class="bmi-class-row">
                                    <span class="bmi-dot" style="background:#60A5FA;"></span>
                                    <span class="bmi-class-name">Underweight</span>
                                    <span class="bmi-class-range ms-auto">&lt; 18.5</span>
                                </div>
                                <div class="bmi-class-row active-class" id="cls-normal">
                                    <span class="bmi-dot" style="background:#34D399;"></span>
                                    <span class="bmi-class-name fw-bold">Normal weight</span>
                                    <span class="bmi-you-badge ms-1">YOU</span>
                                    <span class="bmi-class-range ms-auto">18.5 – 24.9</span>
                                </div>
                                <div class="bmi-class-row" id="cls-overweight">
                                    <span class="bmi-dot" style="background:#FBBF24;"></span>
                                    <span class="bmi-class-name">Overweight</span>
                                    <span class="bmi-class-range ms-auto">25.0 – 29.9</span>
                                </div>
                                <div class="bmi-class-row" id="cls-ob1">
                                    <span class="bmi-dot" style="background:#fb923c;"></span>
                                    <span class="bmi-class-name">Obesity I</span>
                                    <span class="bmi-class-range ms-auto">30.0 – 34.9</span>
                                </div>
                                <div class="bmi-class-row" id="cls-ob2">
                                    <span class="bmi-dot" style="background:#f97316;"></span>
                                    <span class="bmi-class-name">Obesity II</span>
                                    <span class="bmi-class-range ms-auto">35.0 – 39.9</span>
                                </div>
                                <div class="bmi-class-row" id="cls-ob3">
                                    <span class="bmi-dot" style="background:#ef4444;"></span>
                                    <span class="bmi-class-name">Obesity III</span>
                                    <span class="bmi-class-range ms-auto">≥ 40.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM ROW: Body Summary + Health Insights + BMI History --}}
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
                            <span class="summary-value" id="sum-height">165 cm</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">⚖️</span>
                            <span class="summary-label">Weight</span>
                            <span class="summary-value" id="sum-weight">58 kg</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">💓</span>
                            <span class="summary-label">BMI</span>
                            <span class="summary-value fw-bold" style="color:#ea5c2b;" id="sum-bmi">21.3</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🎯</span>
                            <span class="summary-label">Category</span>
                            <span class="badge-category" id="sum-category">Normal Weight</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-icon">🫀</span>
                            <span class="summary-label">Ideal Weight Range</span>
                            <span class="summary-value" id="sum-ideal">50.9 – 68.8 kg</span>
                        </div>
                    </div>
                    <p class="mt-2 mb-0" style="font-size:0.65rem; color:#9CA3AF;">
                        * Ideal weight range is calculated based on BMI 18.5 – 24.9
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
                    <div class="d-flex flex-column gap-2" id="health-insights-list">
                        <div class="insight-card insight-green">
                            <div class="insight-icon-wrap" style="background:#DCFCE7;">🫀</div>
                            <div>
                                <p class="insight-title" style="color:#16A34A;">You're in the healthy range!</p>
                                <p class="insight-body">Your BMI indicates a normal weight. Great job maintaining your
                                    balance!</p>
                            </div>
                        </div>
                        <div class="insight-card insight-orange">
                            <div class="insight-icon-wrap" style="background:#FFEDD5;">🏃</div>
                            <div>
                                <p class="insight-title" style="color:#ea5c2b;">Keep moving!</p>
                                <p class="insight-body">Regular exercise can keep you strong and energized.</p>
                            </div>
                        </div>
                        <div class="insight-card insight-blue">
                            <div class="insight-icon-wrap" style="background:#DBEAFE;">💧</div>
                            <div>
                                <p class="insight-title" style="color:#2563EB;">Stay hydrated!</p>
                                <p class="insight-body">Drink enough water every day to support your overall health.</p>
                            </div>
                        </div>
                    </div>
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
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                        </select>
                    </div>

                    {{-- Mini Line Chart --}}
                    <div class="chart-wrap">
                        <canvas id="bmiHistoryChart"></canvas>
                    </div>

                    <div class="insight-card insight-green mt-2">
                        <div class="insight-icon-wrap" style="background:#DCFCE7; font-size:0.9rem;">📈</div>
                        <div>
                            <p class="insight-body mb-0">Your BMI has been stable. Keep maintaining your healthy lifestyle!
                            </p>
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
                    <a href="/meal_plan" class="btn-create-plan">
                        ✦ Create My Meal Plan
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        /* === ANALYTIC PAGE ADDITIONS ONLY === */

        .analytic-card {
            border-radius: 18px;
            background: rgba(252, 252, 252, 0.80);
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

        /* Gender toggle */
        .gender-toggle {
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            border: 1.5px solid #E5E7EB;
            background: #F9FAFB;
        }

        .gender-btn {
            border: none;
            background: transparent;
            padding: 0.3rem 1rem;
            font-size: 0.82rem;
            cursor: pointer;
            color: #6B7280;
            transition: all 0.2s;
        }

        .gender-btn.active {
            background: #ea5c2b;
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
        }

        /* Inputs */
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

        /* Calculate button */
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

        /* Gauge */
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

        /* BMI Classification */
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

        /* Summary */
        .summary-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .summary-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 0.8px solid rgba(0, 0, 0, 0.06);
            font-size: 0.85rem;
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

        /* Insights */
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

        /* Chart */
        .chart-wrap {
            position: relative;
            height: 130px;
        }

        /* CTA Banner */
        .cta-banner {
            border-radius: 18px;
            background: rgba(252, 252, 252, 0.80);
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
            box-shadow: 0 6px 20px rgba(234, 92, 43, 0.45);
        }

        /* Responsive tweaks */
        @media (max-width: 767px) {
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

        @media (max-width: 480px) {
            .bmi-class-row {
                font-size: 0.75rem;
            }

            .summary-row {
                font-size: 0.78rem;
            }
        }
    </style>

    <script>
        // ─── Gender toggle ───────────────────────────────────────────────
        let currentGender = 'female';

        function setGender(g) {
            currentGender = g;
            document.getElementById('btn-female').classList.toggle('active', g === 'female');
            document.getElementById('btn-male').classList.toggle('active', g === 'male');
            calcBMI();
        }

        // ─── Age from DOB ─────────────────────────────────────────────────
        function calcAge() {
            const dob = document.getElementById('dob').value;
            if (!dob) return;
            const today = new Date();
            const birth = new Date(dob);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            document.getElementById('age-input').value = age > 0 ? age : '';
            calcBMI();
        }

        // ─── BMI Calculation & UI Update ─────────────────────────────────
        function calcBMI() {
            const h = parseFloat(document.getElementById('height-input').value) || 165;
            const w = parseFloat(document.getElementById('weight-input').value) || 58;
            const hm = h / 100;
            const bmi = w / (hm * hm);
            const bmiRounded = bmi.toFixed(1);

            // Update displays
            document.getElementById('bmi-display').textContent = bmiRounded;
            document.getElementById('sum-bmi').textContent = bmiRounded;
            document.getElementById('sum-height').textContent = h + ' cm';
            document.getElementById('sum-weight').textContent = w + ' kg';

            // Ideal weight range
            const idealMin = (18.5 * hm * hm).toFixed(1);
            const idealMax = (24.9 * hm * hm).toFixed(1);
            document.getElementById('sum-ideal').textContent = idealMin + ' – ' + idealMax + ' kg';

            // Label & color
            let label, color, msg, catText, needleAngle;
            if (bmi < 18.5) {
                label = '● Underweight';
                color = '#60A5FA';
                catText = 'Underweight';
                msg = 'Your BMI is below the normal range. Consider a nutrient-rich diet to reach a healthy weight.';
                needleAngle = mapRange(bmi, 10, 18.5, -90, -30);
            } else if (bmi < 25) {
                label = '● Normal Weight';
                color = '#34D399';
                catText = 'Normal Weight';
                msg = 'Great! Your BMI is in the normal range. Keep up the good work and maintain a healthy lifestyle.';
                needleAngle = mapRange(bmi, 18.5, 25, -30, 10);
            } else if (bmi < 30) {
                label = '● Overweight';
                color = '#FBBF24';
                catText = 'Overweight';
                msg = 'Your BMI is above the normal range. Regular exercise and a balanced diet can help.';
                needleAngle = mapRange(bmi, 25, 30, 10, 50);
            } else if (bmi < 35) {
                label = '● Obesity I';
                color = '#fb923c';
                catText = 'Obesity I';
                msg = 'Your BMI indicates Obesity I. Consult a healthcare professional for personalized guidance.';
                needleAngle = mapRange(bmi, 30, 35, 50, 70);
            } else if (bmi < 40) {
                label = '● Obesity II';
                color = '#f97316';
                catText = 'Obesity II';
                msg = 'Your BMI indicates Obesity II. Medical guidance is recommended.';
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
            document.getElementById('bmi-needle').setAttribute('transform', `rotate(${needleAngle}, 100, 100)`);

            // Category badge
            const catEl = document.getElementById('sum-category');
            catEl.textContent = catText;

            // Highlight correct classification row
            const classRows = ['cls-normal', 'cls-overweight', 'cls-ob1', 'cls-ob2', 'cls-ob3'];
            const thresholds = [
                bmi >= 18.5 && bmi < 25,
                bmi >= 25 && bmi < 30,
                bmi >= 30 && bmi < 35,
                bmi >= 35 && bmi < 40,
                bmi >= 40
            ];
            // Underweight has no specific id row, handle separately
            classRows.forEach((id, i) => {
                const el = document.getElementById(id);
                el.classList.toggle('active-class', thresholds[i]);
                const badge = el.querySelector('.bmi-you-badge');
                if (badge) badge.style.display = thresholds[i] ? 'inline' : 'none';
            });
            // Handle underweight row (first row, no id)
            const rows = document.querySelectorAll('.bmi-class-row');
            rows[0].classList.toggle('active-class', bmi < 18.5);

            // Insights
            updateInsights(bmi);
        }

        function mapRange(v, inMin, inMax, outMin, outMax) {
            return (v - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
        }

        function updateInsights(bmi) {
            const container = document.getElementById('health-insights-list');
            let insights = [];
            if (bmi < 18.5) {
                insights = [{
                        cls: 'insight-blue',
                        icon: '🍽️',
                        color: '#2563EB',
                        title: 'Increase calorie intake',
                        body: 'Focus on nutrient-dense foods to reach a healthy weight.'
                    },
                    {
                        cls: 'insight-orange',
                        icon: '🏋️',
                        color: '#ea5c2b',
                        title: 'Strength training helps',
                        body: 'Light resistance exercise can help you build muscle mass.'
                    },
                    {
                        cls: 'insight-green',
                        icon: '💧',
                        color: '#16A34A',
                        title: 'Stay hydrated!',
                        body: 'Drink enough water every day to support your overall health.'
                    },
                ];
            } else if (bmi < 25) {
                insights = [{
                        cls: 'insight-green',
                        icon: '🫀',
                        color: '#16A34A',
                        title: "You're in the healthy range!",
                        body: 'Your BMI indicates a normal weight. Great job maintaining your balance!'
                    },
                    {
                        cls: 'insight-orange',
                        icon: '🏃',
                        color: '#ea5c2b',
                        title: 'Keep moving!',
                        body: 'Regular exercise can keep you strong and energized.'
                    },
                    {
                        cls: 'insight-blue',
                        icon: '💧',
                        color: '#2563EB',
                        title: 'Stay hydrated!',
                        body: 'Drink enough water every day to support your overall health.'
                    },
                ];
            } else {
                insights = [{
                        cls: 'insight-orange',
                        icon: '⚠️',
                        color: '#ea5c2b',
                        title: 'Consider lifestyle changes',
                        body: 'A balanced diet and regular exercise can improve your BMI.'
                    },
                    {
                        cls: 'insight-green',
                        icon: '🥗',
                        color: '#16A34A',
                        title: 'Eat more vegetables',
                        body: 'Add more fiber-rich foods to your daily meals.'
                    },
                    {
                        cls: 'insight-blue',
                        icon: '🚶',
                        color: '#2563EB',
                        title: 'Walk 30 min/day',
                        body: 'Daily walks are an easy way to start being more active.'
                    },
                ];
            }
            container.innerHTML = insights.map(i => `
            <div class="insight-card ${i.cls}">
                <div class="insight-icon-wrap" style="background:${i.cls === 'insight-green' ? '#DCFCE7' : i.cls === 'insight-orange' ? '#FFEDD5' : '#DBEAFE'};">${i.icon}</div>
                <div>
                    <p class="insight-title" style="color:${i.color};">${i.title}</p>
                    <p class="insight-body">${i.body}</p>
                </div>
            </div>`).join('');
        }

        // ─── BMI History Chart ────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('bmiHistoryChart').getContext('2d');
            const data2025 = [21.0, 21.1, 21.0, 21.2, 21.3, 21.1, 21.2, 21.3, 21.2, 21.3, 21.3, 21.3];
            const data2024 = [22.0, 21.8, 21.6, 21.5, 21.4, 21.3, 21.2, 21.2, 21.1, 21.0, 21.1, 21.0];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'BMI',
                        data: data2025,
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
                            min: 18,
                            max: 26
                        }
                    }
                }
            });

            document.getElementById('history-year').addEventListener('change', function() {
                chart.data.datasets[0].data = this.value === '2024' ? data2024 : data2025;
                chart.update();
            });

            // Initial BMI calc on load
            calcBMI();
        });
    </script>
@endsection
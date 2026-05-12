{{--
    resources/views/components/days_meal_plan.blade.php
    ────────────────────────────────────────────────────
    Days view for Meal Plan.
    • Meal timeline  → reads from MealLog via /api/meal-logs?date=YYYY-MM-DD
    • Nutrition panel → reads totals from same API
    • Add Meal modal  → POSTs to /api/meal-logs, then refreshes both panels live
    • Date nav arrows → AJAX, no page reload
    • Daily Goals    → target kalori & makro diambil dari MealPlanPreference (DB)
                       dan live-update saat modal Adjust Meal Plan disimpan
    • renderTimeline() menggunakan struktur HTML yang sama dengan meal_template.blade.php (DAYS VIEW)
--}}

{{-- ═══════════════════════════════════════════════════════
     PASS SERVER-SIDE DATA AS JS GLOBALS
     ═══════════════════════════════════════════════════════ --}}
@php
    $defaultTotals = [
        'calories' => 0,
        'protein'  => 0,
        'carbs'    => 0,
        'fat'      => 0,
    ];

    // Baca dari MealPlanPreference via User model methods
    // targetKalori() dan targetMakro() sudah baca DB, fallback ke default
    $targetKaloriData = $targetKalori ?? 2000;
    $targetMakroData  = $targetMakro  ?? ['protein' => 125, 'carbs' => 225, 'fat' => 67];
@endphp

<script>
    window.__DAYS_INIT__ = {
        today: "{{ today()->toDateString() }}",

        groupedLogs: @json($groupedLogs ?? []),

        dailyTotals: @json($dailyTotals ?? $defaultTotals),

        targetKalori: {{ $targetKaloriData }},

        targetMakro: @json($targetMakroData),

        csrfToken: "{{ csrf_token() }}"
    };
</script>

<div class="col-12 mt-3">
    <div class="row py-0 g-3">

        {{-- ══════════════════════════════════════════════
             LEFT — Motivational Card
             ══════════════════════════════════════════════ --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-12">
            <div class="card-motivasi p-3">
                <div class="mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L13.5 8.5H19L14.5 11.7L16 17.2L12 14L8 17.2L9.5 11.7L5 8.5H10.5L12 3Z"
                            stroke="#EA5C2B" stroke-width="1.5" stroke-linejoin="round" fill="rgba(234,92,43,0.1)" />
                        <path d="M5 3.5L5.8 5.3M3.5 5L5.3 5.8M19 3.5L18.2 5.3M20.5 5L18.7 5.8"
                            stroke="#95CD41" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
                <h6 class="fw-bold mb-1">Stay consistent!</h6>
                <p class="tgl text-muted mb-0">Small steps every day build a healthier you.</p>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             MIDDLE — Meal Plan Timeline
             ══════════════════════════════════════════════ --}}
        <div class="col-xl-6 col-lg-5 col-md-8 col-12">

            <div class="mb-3">
                <h5 class="fw-bold mb-0">Meal Plan &ndash; Today</h5>
                <p class="tgl text-muted mb-2" id="days-date-label">{{ date('l, d F Y') }}</p>

                {{-- Date nav + Add button --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-1">
                        <button class="btn-nav-date" id="days-prev-btn" title="Previous day">&#8249;</button>
                        <span class="date-pill" id="days-date-pill">{{ date('M j') }}</span>
                        <button class="btn-nav-date" id="days-next-btn" title="Next day">&#8250;</button>
                    </div>
                    <button data-bs-toggle="modal" data-bs-target="#modalAddMeal"
                        class="btn oren text-white rounded-pill add-meal-btn fw-bold">
                        + Add Meal or Drinks or Snacks
                    </button>
                </div>
            </div>

            {{-- Meals container --}}
            <div class="wrapper-meal-days p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0 fw-bold">Meals &amp; Drinks</h5>
                    <p class="text-muted tgl m-0" id="days-meal-count">—</p>
                </div>

                {{-- Timeline loader --}}
                <div id="days-loading" class="text-center py-4" style="display:none;">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    <span class="ms-2" style="font-size:0.78rem;color:#6B7280;">Memuat jadwal...</span>
                </div>

                {{-- Timeline slots rendered by JS --}}
                <div class="timeline-meals" id="days-timeline">
                    {{-- Rendered dynamically --}}
                </div>

                {{-- Empty state --}}
                <div id="days-empty" style="display:none;text-align:center;padding:32px 0;">
                    <p style="font-size:2rem;margin-bottom:8px;">🍽️</p>
                    <p style="font-size:0.82rem;color:#9CA3AF;font-weight:500;">
                        Belum ada makanan dicatat hari ini.<br>
                        Tap <strong>+ Add Meal</strong> untuk mulai.
                    </p>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
             RIGHT — Nutrition Panel
             ══════════════════════════════════════════════ --}}
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">

            {{-- Nutrition Summary --}}
            <div class="nutrition-panel p-3 mb-3">
                <h5 class="fw-bold mb-0">Nutrition Summary</h5>
                <p class="tgl text-muted mb-3">Macronutrient breakdown</p>

                {{-- Donut chart --}}
                <div class="d-flex justify-content-center mb-3">
                    <div class="donut-wrapper">
                        <svg viewBox="0 0 120 120" width="160" height="160" aria-label="Macronutrient donut chart">
                            {{-- Track --}}
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB" stroke-width="10" />
                            {{-- Protein arc --}}
                            <circle id="donut-protein" cx="60" cy="60" r="45" fill="none"
                                stroke="#FB2C36" stroke-width="10"
                                stroke-dasharray="0 282.74" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                            {{-- Carbs arc --}}
                            <circle id="donut-carbs" cx="60" cy="60" r="45" fill="none"
                                stroke="#FE9A00" stroke-width="10"
                                stroke-dasharray="0 282.74" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                            {{-- Fat arc --}}
                            <circle id="donut-fat" cx="60" cy="60" r="45" fill="none"
                                stroke="#95CD41" stroke-width="10"
                                stroke-dasharray="0 282.74" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                        </svg>
                        <div class="donut-center-text">
                            <p class="fw-bold mb-0 donut-kcal-num" id="donut-kcal-val">0</p>
                            <p class="tgl mb-0 text-muted donut-kcal-label">kcal today</p>
                        </div>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#FB2C36"></span>
                            <span class="tgl">Protein</span>
                        </div>
                        <p class="fw-bold tgl mb-0" id="legend-protein">0g</p>
                    </div>
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#FE9A00"></span>
                            <span class="tgl">Carbs</span>
                        </div>
                        <p class="fw-bold tgl mb-0" id="legend-carbs">0g</p>
                    </div>
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#95CD41"></span>
                            <span class="tgl">Fat</span>
                        </div>
                        <p class="fw-bold tgl mb-0" id="legend-fat">0g</p>
                    </div>
                </div>
            </div>

            {{-- ── Daily Goals ──────────────────────────────────── --}}
            {{--
                ID pada label target diberi suffix -target agar JS bisa update
                tanpa reload halaman setelah modal Adjust Meal Plan disimpan.
            --}}
            <div class="nutrition-panel p-3 mb-3" id="daily-goals-panel">
                <h5 class="fw-bold mb-3">Daily Goals</h5>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="tgl mb-1">Calories</p>
                        <p class="tgl mb-1 text-muted">
                            <span id="goal-kcal-cur">0</span>
                            / <span id="goal-kcal-target">{{ $targetKaloriData }}</span> kcal
                        </p>
                    </div>
                    <div class="progress-daily">
                        <div class="progress-bar-daily" id="goal-bar-kcal" style="width:0%"></div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="tgl mb-1">Protein</p>
                        <p class="tgl mb-1 text-muted">
                            <span id="goal-protein-cur">0</span>
                            / <span id="goal-protein-target">{{ $targetMakroData['protein'] }}</span>g
                        </p>
                    </div>
                    <div class="progress-daily">
                        <div class="progress-bar-daily-protein" id="goal-bar-protein" style="width:0%"></div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="tgl mb-1">Carbs</p>
                        <p class="tgl mb-1 text-muted">
                            <span id="goal-carbs-cur">0</span>
                            / <span id="goal-carbs-target">{{ $targetMakroData['carbs'] }}</span>g
                        </p>
                    </div>
                    <div class="progress-daily">
                        <div class="progress-bar-daily-fats" id="goal-bar-carbs" style="width:0%"></div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="tgl mb-1">Fat</p>
                        <p class="tgl mb-1 text-muted">
                            <span id="goal-fat-cur">0</span>
                            / <span id="goal-fat-target">{{ $targetMakroData['fat'] }}</span>g
                        </p>
                    </div>
                    <div class="progress-daily">
                        <div class="progress-bar-daily-water" id="goal-bar-fat" style="width:0%"></div>
                    </div>
                </div>
            </div>

            {{-- Nutrition Tip --}}
            <div class="nutrition-panel p-3 mb-3" id="days-tip-panel">
                <div class="d-flex gap-2 align-items-start">
                    <div class="tip-icon-circle flex-shrink-0 d-flex align-items-center justify-content-center">
                        <span class="fw-bold tip-icon-num" id="tip-icon-num">💡</span>
                    </div>
                    <div>
                        <p class="tgl fw-bold mb-1" id="tip-title">Track your meals</p>
                        <p class="tgl text-muted mb-0" style="font-size:0.7rem" id="tip-body">
                            Start logging your meals to get personalized nutrition tips.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Adjust Meal Plan button --}}
            <button data-bs-toggle="modal" data-bs-target="#modalAdjustPlan"
                class="btn ijo text-white w-100 rounded-pill py-2 fw-bold">
                Adjust Meal Plan
            </button>

        </div>
    </div>

    @include('components.modal_add_meal')
    @include('components.modal_adjust_meal_plan')
</div>

{{-- ═══════════════════════════════════════════════════════
     DAYS VIEW JAVASCRIPT
     ═══════════════════════════════════════════════════════ --}}
<script>
(function () {
    /* ── Constants ──────────────────────────────────── */
    const CIRC      = 282.74;   // 2π×45
    const SLOTS     = ['Breakfast', 'Snack', 'Lunch', 'Dinner'];
    const SLOT_ICON = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };
    const SLOT_TIME = { Breakfast:'08:00', Snack:'10:30', Lunch:'13:00', Dinner:'19:30' };
    const INIT      = window.__DAYS_INIT__;

    /* ── expose ke window agar modal_add_meal bisa baca tanggal aktif ── */
    window.daysCurrentDate = INIT.today;   // YYYY-MM-DD

    /* ── Live targets — bisa di-override oleh adjSave() ──────────────── */
    //
    // Kita simpan target di object terpisah supaya saat modal Adjust Meal Plan
    // berhasil simpan, kita tinggal panggil daysUpdateTargets(newPref) dan
    // semua label + progress bar langsung terupdate tanpa reload.
    //
    let liveTargets = {
        kalori  : INIT.targetKalori,
        protein : INIT.targetMakro.protein,
        carbs   : INIT.targetMakro.carbs,
        fat     : INIT.targetMakro.fat,
    };

    /* ── Helpers ────────────────────────────────────── */
    function fmtDate(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-GB', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    }
    function fmtPill(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-GB', { month:'short', day:'numeric' });
    }
    function pct(val, target) {
        return target > 0 ? Math.min(Math.round(val / target * 100), 100) : 0;
    }

    /* ── Update target labels di DOM ────────────────── */
    function daysUpdateTargetLabels() {
        document.getElementById('goal-kcal-target').textContent    = liveTargets.kalori;
        document.getElementById('goal-protein-target').textContent = liveTargets.protein;
        document.getElementById('goal-carbs-target').textContent   = liveTargets.carbs;
        document.getElementById('goal-fat-target').textContent     = liveTargets.fat;
    }

    /**
     * Dipanggil dari adjSave() setelah berhasil simpan ke DB.
     * newPref = { target_kalori, protein_pct, carbs_pct, fat_pct, ... }
     *
     * Hitung ulang gram target dari kcal + pct, update liveTargets,
     * update label DOM, lalu re-render progress bars dengan totals terakhir.
     */
    window.daysUpdateTargets = function (newPref) {
        const kcal = parseInt(newPref.target_kalori);

        liveTargets = {
            kalori  : kcal,
            protein : Math.round(kcal * parseInt(newPref.protein_pct) / 100 / 4),
            carbs   : Math.round(kcal * parseInt(newPref.carbs_pct)   / 100 / 4),
            fat     : Math.round(kcal * parseInt(newPref.fat_pct)     / 100 / 9),
        };

        // Sinkronkan juga ke INIT supaya tip panel pakai nilai terbaru
        INIT.targetKalori      = liveTargets.kalori;
        INIT.targetMakro       = {
            protein : liveTargets.protein,
            carbs   : liveTargets.carbs,
            fat     : liveTargets.fat,
        };

        daysUpdateTargetLabels();

        // Re-render progress bars dengan totals yang sedang aktif
        if (window.__lastTotals) {
            updateNutritionPanel(window.__lastTotals);
        }
    };

    /* ── Update Nutrition Panel ─────────────────────── */
    function updateNutritionPanel(totals) {
        // Cache totals supaya bisa di-re-render setelah target berubah
        window.__lastTotals = totals;

        const t  = liveTargets.kalori;
        const tm = liveTargets;

        const proteinArc = (totals.protein * 4 / (t || 2000)) * CIRC;
        const carbsArc   = (totals.carbs   * 4 / (t || 2000)) * CIRC;
        const fatArc     = (totals.fat     * 9 / (t || 2000)) * CIRC;

        const carbsOffset = proteinArc;
        const fatOffset   = proteinArc + carbsArc;

        document.getElementById('donut-protein').setAttribute('stroke-dasharray', `${proteinArc} ${CIRC}`);
        document.getElementById('donut-protein').setAttribute('transform', `rotate(-90 60 60)`);

        document.getElementById('donut-carbs').setAttribute('stroke-dasharray', `${carbsArc} ${CIRC}`);
        document.getElementById('donut-carbs').setAttribute('transform',
            `rotate(${-90 + (carbsOffset / CIRC) * 360} 60 60)`);

        document.getElementById('donut-fat').setAttribute('stroke-dasharray', `${fatArc} ${CIRC}`);
        document.getElementById('donut-fat').setAttribute('transform',
            `rotate(${-90 + (fatOffset / CIRC) * 360} 60 60)`);

        document.getElementById('donut-kcal-val').textContent = Math.round(totals.calories).toLocaleString();
        document.getElementById('legend-protein').textContent = Math.round(totals.protein) + 'g';
        document.getElementById('legend-carbs').textContent   = Math.round(totals.carbs)   + 'g';
        document.getElementById('legend-fat').textContent     = Math.round(totals.fat)      + 'g';

        // Current values
        document.getElementById('goal-kcal-cur').textContent    = Math.round(totals.calories);
        document.getElementById('goal-protein-cur').textContent = Math.round(totals.protein);
        document.getElementById('goal-carbs-cur').textContent   = Math.round(totals.carbs);
        document.getElementById('goal-fat-cur').textContent     = Math.round(totals.fat);

        // Progress bars — pakai liveTargets (bisa berubah tanpa reload)
        document.getElementById('goal-bar-kcal').style.width    = pct(totals.calories, tm.kalori)   + '%';
        document.getElementById('goal-bar-protein').style.width = pct(totals.protein,  tm.protein)  + '%';
        document.getElementById('goal-bar-carbs').style.width   = pct(totals.carbs,    tm.carbs)    + '%';
        document.getElementById('goal-bar-fat').style.width     = pct(totals.fat,      tm.fat)      + '%';

        updateTip(totals);
    }

    function updateTip(totals) {
        const tm  = liveTargets;
        const gap = {
            protein : tm.protein - totals.protein,
            carbs   : tm.carbs   - totals.carbs,
            fat     : tm.fat     - totals.fat,
        };
        let title = 'Great job!';
        let body  = 'You\'re right on track for today.';
        let icon  = '🏆';

        if (gap.protein > 20) {
            icon  = '💪';
            title = 'Add more protein';
            body  = `You're ${Math.round(gap.protein)}g away from your protein goal. Try chicken, eggs, or Greek yogurt.`;
        } else if (gap.carbs > 30) {
            icon  = '⚡';
            title = 'More carbs needed';
            body  = `You still need ${Math.round(gap.carbs)}g of carbs for energy. Rice or sweet potato works great.`;
        } else if (gap.fat < -5) {
            icon  = '⚠️';
            title = 'Fat intake high';
            body  = `You've exceeded your fat target by ${Math.round(-gap.fat)}g. Consider lighter options for dinner.`;
        }

        document.getElementById('tip-icon-num').textContent = icon;
        document.getElementById('tip-title').textContent    = title;
        document.getElementById('tip-body').textContent     = body;
    }

    /* ── Render Timeline ─────────────────────────────── */
    function renderTimeline(grouped) {
        const container = document.getElementById('days-timeline');
        const empty     = document.getElementById('days-empty');
        container.innerHTML = '';

        let totalItems = 0;
        SLOTS.forEach(s => { totalItems += (grouped[s] || []).length; });

        if (totalItems === 0) {
            empty.style.display = 'block';
            document.getElementById('days-meal-count').textContent = '0 Meals';
            return;
        }
        empty.style.display = 'none';
        document.getElementById('days-meal-count').textContent =
            totalItems + ' Meal' + (totalItems > 1 ? 's' : '');

        const lastSlot = [...SLOTS].reverse().find(s => (grouped[s] || []).length > 0);

        SLOTS.forEach((slot) => {
            const items = grouped[slot] || [];
            if (items.length === 0) return;

            const isLastSlot = slot === lastSlot;

            items.forEach((log, li) => {
                const isLast      = isLastSlot && li === items.length - 1;
                const timeDisplay = log.meal_time ? log.meal_time.substring(0, 5) : SLOT_TIME[slot];

                const row = document.createElement('div');
                row.className = 'd-flex align-items-start mb-3 timeline-meal-row';
                row.innerHTML = `
                    <div class="meal-time-col">
                        <span class="meal-time-text">${timeDisplay}</span>
                    </div>

                    <div class="meal-timeline-col">
                        <div class="meal-dot-timeline"></div>
                        ${!isLast ? `<div class="meal-line-timeline"></div>` : ''}
                    </div>

                    <div class="wrapper-content-meal-days d-flex px-2 py-2 flex-grow-1">

                        <div class="d-flex align-items-center flex-shrink-0">
                            ${log.image_path
                                ? `<img src="${log.image_path}"
                                        alt="${log.name}"
                                        class="gambar-meal"
                                        onerror="this.style.display='none'">`
                                : `<div class="gambar-meal d-flex align-items-center justify-content-center"
                                        style="background:rgba(0,0,0,0.04);border-radius:10px;font-size:1.4rem;">
                                        ${log.emoji ?? '🍽️'}
                                   </div>`
                            }
                        </div>

                        <div class="d-flex flex-column ms-2 justify-content-center flex-grow-1">

                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <p class="type-meal m-0 p-0">
                                    ${SLOT_ICON[slot]} ${slot.toUpperCase()}
                                </p>
                                <button class="btn-delete-log p-0 border-0 bg-transparent"
                                    title="Hapus"
                                    style="font-size:0.8rem;color:#D1D5DB;cursor:pointer;line-height:1;"
                                    onclick="daysDeleteLog(${log.id})">✕</button>
                            </div>

                            <h6 class="name-meal mb-1 p-0 fw-bold">${log.name}</h6>

                            <div class="d-flex align-items-center gap-3 nutrition-meal flex-wrap">

                                <div class="d-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                            stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="font-size-s m-0">${Math.round(log.calories)} kcal</p>
                                </div>

                                <div class="d-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#clip0_days_protein_${log.id})">
                                            <path d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_days_protein_${log.id}">
                                                <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p class="font-size-s m-0">${log.protein}g protein</p>
                                </div>

                                <p class="font-size-s m-0 text-muted">${log.servings} porsi</p>

                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(row);
            });
        });
    }

    /* ── Fetch & Refresh All ────────────────────────── */
    async function daysLoad(date) {
        const loading  = document.getElementById('days-loading');
        const timeline = document.getElementById('days-timeline');
        loading.style.display  = 'block';
        timeline.style.opacity = '0.4';

        try {
            const res  = await fetch(`/api/meal-logs?date=${date}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            renderTimeline(data.grouped || {});
            updateNutritionPanel(data.totals || { calories:0, protein:0, carbs:0, fat:0 });
        } catch (e) {
            console.error('daysLoad:', e);
        } finally {
            loading.style.display  = 'none';
            timeline.style.opacity = '1';
        }

        document.getElementById('days-date-label').textContent = fmtDate(date);
        document.getElementById('days-date-pill').textContent  = fmtPill(date);
    }

    /* ── Delete a log entry ─────────────────────────── */
    window.daysDeleteLog = async function (logId) {
        if (!confirm('Hapus makanan ini dari log?')) return;
        try {
            await fetch(`/api/meal-logs/${logId}`, {
                method : 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': INIT.csrfToken,
                    'Accept'      : 'application/json',
                }
            });
            daysLoad(window.daysCurrentDate);
        } catch (e) {
            console.error('daysDeleteLog:', e);
        }
    };

    /* ── Date Navigation ────────────────────────────── */
    function formatLocalDate(date) {
        const year  = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day   = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    document.getElementById('days-prev-btn').addEventListener('click', () => {
        const d = new Date(window.daysCurrentDate + 'T00:00:00');
        d.setDate(d.getDate() - 1);
        window.daysCurrentDate = formatLocalDate(d);
        daysLoad(window.daysCurrentDate);
    });

    document.getElementById('days-next-btn').addEventListener('click', () => {
        const d = new Date(window.daysCurrentDate + 'T00:00:00');
        d.setDate(d.getDate() + 1);
        window.daysCurrentDate = formatLocalDate(d);
        daysLoad(window.daysCurrentDate);
    });

    /* ── Listen for meal-added event from modal ─────── */
    window.addEventListener('meal-added', function (e) {
        const data = e.detail;
        if (data.grouped) renderTimeline(data.grouped);
        if (data.totals)  updateNutritionPanel(data.totals);
        if (!data.grouped || !data.totals) {
            daysLoad(window.daysCurrentDate);
        }
    });

    /* ── Fallback reload event ── */
    window.addEventListener('days-reload', function () {
        daysLoad(window.daysCurrentDate);
    });

    /* ── Boot ── */
    (function boot() {
        daysUpdateTargetLabels();          // set label dari DB values
        renderTimeline(INIT.groupedLogs);
        updateNutritionPanel(INIT.dailyTotals);
        setTimeout(() => daysLoad(window.daysCurrentDate), 800);
    })();

})();
</script>
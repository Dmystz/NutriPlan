{{--
    resources/views/components/days_meal_plan.blade.php
    ────────────────────────────────────────────────────
    Days view for Meal Plan.
    • Meal timeline  → reads from MealLog via /api/meal-logs?date=YYYY-MM-DD
    • Nutrition panel → reads totals from same API
    • Add Meal modal  → POSTs to /api/meal-logs, then refreshes both panels live
    • Date nav arrows → AJAX, no page reload
--}}

{{-- ═══════════════════════════════════════════════════════
     PASS SERVER-SIDE DATA AS JS GLOBALS
     ═══════════════════════════════════════════════════════ --}}
@php
    $defaultTotals = [
        'calories' => 0,
        'protein' => 0,
        'carbs' => 0,
        'fat' => 0
    ];

    $defaultMakro = [
        'protein' => 150,
        'carbs' => 260,
        'fat' => 70
    ];

    $targetMakroData = auth()->check()
        ? auth()->user()->targetMakro()
        : $defaultMakro;
@endphp

<script>
    window.__DAYS_INIT__ = {
        today: "{{ today()->toDateString() }}",

        groupedLogs: @json($groupedLogs ?? []),

        dailyTotals: @json($dailyTotals ?? $defaultTotals),

        targetKalori: {{ auth()->user()?->targetKalori() ?? 2000 }},

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

            {{-- Daily Goals --}}
            <div class="nutrition-panel p-3 mb-3">
                <h5 class="fw-bold mb-3">Daily Goals</h5>

                @php
                    $targetKalori = auth()->user()?->targetKalori() ?? 2000;
                    $targetMakro  = auth()->user()?->targetMakro()  ?? ['protein'=>150,'carbs'=>260,'fat'=>70];
                @endphp

                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="tgl mb-1">Calories</p>
                        <p class="tgl mb-1 text-muted">
                            <span id="goal-kcal-cur">0</span> / {{ $targetKalori }} kcal
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
                            <span id="goal-protein-cur">0</span> / {{ $targetMakro['protein'] }}g
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
                            <span id="goal-carbs-cur">0</span> / {{ $targetMakro['carbs'] }}g
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
                            <span id="goal-fat-cur">0</span> / {{ $targetMakro['fat'] }}g
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
    const CIRC       = 282.74;   // 2π×45
    const SLOTS      = ['Breakfast', 'Snack', 'Lunch', 'Dinner'];
    const SLOT_ICON  = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };
    const SLOT_TIME  = { Breakfast:'08:00', Snack:'10:30', Lunch:'13:00', Dinner:'19:30' };
    const INIT       = window.__DAYS_INIT__;

    let daysCurrentDate = INIT.today;   // YYYY-MM-DD

    /* ── Helpers ────────────────────────────────────── */
    function fmtDate(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-GB', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    }
    function fmtPill(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-GB', { month:'short', day:'numeric' });
    }
    function pct(val, target) { return target > 0 ? Math.min(Math.round(val / target * 100), 100) : 0; }

    /* ── Update Nutrition Panel ─────────────────────── */
    function updateNutritionPanel(totals) {
        const t  = INIT.targetKalori;
        const tm = INIT.targetMakro;

        /* Donut — protein starts at -90°, carbs follows, fat follows */
        const proteinArc = (totals.protein * 4 / (t || 2000)) * CIRC;
        const carbsArc   = (totals.carbs   * 4 / (t || 2000)) * CIRC;
        const fatArc     = (totals.fat     * 9 / (t || 2000)) * CIRC;

        // Protein starts at -90deg (top)
        const proteinOffset = 0;
        const carbsOffset   = proteinArc;
        const fatOffset     = proteinArc + carbsArc;

        document.getElementById('donut-protein').setAttribute('stroke-dasharray', `${proteinArc} ${CIRC}`);
        document.getElementById('donut-protein').setAttribute('transform', `rotate(-90 60 60)`);

        document.getElementById('donut-carbs').setAttribute('stroke-dasharray', `${carbsArc} ${CIRC}`);
        document.getElementById('donut-carbs').setAttribute('transform', `rotate(${-90 + (carbsOffset / CIRC) * 360} 60 60)`);

        document.getElementById('donut-fat').setAttribute('stroke-dasharray', `${fatArc} ${CIRC}`);
        document.getElementById('donut-fat').setAttribute('transform', `rotate(${-90 + (fatOffset / CIRC) * 360} 60 60)`);

        document.getElementById('donut-kcal-val').textContent = Math.round(totals.calories).toLocaleString();
        document.getElementById('legend-protein').textContent = Math.round(totals.protein) + 'g';
        document.getElementById('legend-carbs').textContent   = Math.round(totals.carbs)   + 'g';
        document.getElementById('legend-fat').textContent     = Math.round(totals.fat)      + 'g';

        /* Goals */
        document.getElementById('goal-kcal-cur').textContent    = Math.round(totals.calories);
        document.getElementById('goal-protein-cur').textContent = Math.round(totals.protein);
        document.getElementById('goal-carbs-cur').textContent   = Math.round(totals.carbs);
        document.getElementById('goal-fat-cur').textContent     = Math.round(totals.fat);

        document.getElementById('goal-bar-kcal').style.width    = pct(totals.calories, t)        + '%';
        document.getElementById('goal-bar-protein').style.width = pct(totals.protein,  tm.protein)+ '%';
        document.getElementById('goal-bar-carbs').style.width   = pct(totals.carbs,    tm.carbs)  + '%';
        document.getElementById('goal-bar-fat').style.width     = pct(totals.fat,      tm.fat)    + '%';

        /* Tip */
        updateTip(totals);
    }

    function updateTip(totals) {
        const tm    = INIT.targetMakro;
        const gap   = { protein: tm.protein - totals.protein, carbs: tm.carbs - totals.carbs, fat: tm.fat - totals.fat };
        let title   = 'Great job!';
        let body    = 'You\'re right on track for today.';
        let icon    = '🏆';

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

    /* ── Render Timeline ────────────────────────────── */
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
        document.getElementById('days-meal-count').textContent = totalItems + ' Meal' + (totalItems > 1 ? 's' : '');

        const lastSlot = [...SLOTS].reverse().find(s => (grouped[s] || []).length > 0);

        SLOTS.forEach((slot, si) => {
            const items = grouped[slot] || [];
            if (items.length === 0) return;

            const isLastSlot = slot === lastSlot;

            items.forEach((log, li) => {
                const isLast = isLastSlot && li === items.length - 1;
                const timeDisplay = log.meal_time ? log.meal_time.substring(0, 5) : SLOT_TIME[slot];

                const row = document.createElement('div');
                row.className = 'meal-entry d-flex gap-3 mb-3';
                row.innerHTML = `
                    <div class="meal-time-col" style="min-width:42px;text-align:right;">
                        <span class="tgl" style="font-size:0.72rem;color:#6B7280;">${timeDisplay}</span>
                    </div>
                    <div class="meal-line-col d-flex flex-column align-items-center" style="margin-top:3px;">
                        <div class="dot-meal" style="
                            width:10px;height:10px;border-radius:50%;flex-shrink:0;
                            background:${si % 2 === 0 ? 'var(--warna-oren)' : 'var(--warna-ijo)'};
                        "></div>
                        ${!isLast ? `<div style="width:2px;flex-grow:1;min-height:36px;background:rgba(0,0,0,0.07);margin-top:3px;"></div>` : ''}
                    </div>
                    <div class="meal-card-col flex-grow-1 pb-${isLast ? '0' : '2'}">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span style="font-size:0.66rem;font-weight:700;letter-spacing:.05em;
                                color:${si % 2 === 0 ? 'var(--warna-oren)' : 'var(--warna-ijo)'};">
                                ${SLOT_ICON[slot]} ${slot.toUpperCase()}
                            </span>
                            <button class="btn-delete-log p-0 border-0 bg-transparent"
                                title="Hapus" data-log-id="${log.id}"
                                style="font-size:0.8rem;color:#D1D5DB;cursor:pointer;line-height:1;"
                                onclick="daysDeleteLog(${log.id})">✕</button>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="flex-shrink:0;">
                                ${log.image_path
                                    ? `<img src="${log.image_path}" alt="${log.name}"
                                            style="width:40px;height:40px;border-radius:10px;object-fit:cover;"
                                            onerror="this.style.display='none'">`
                                    : `<div style="width:40px;height:40px;border-radius:10px;
                                            background:rgba(0,0,0,0.04);
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            font-size:1.2rem;">
                                            ${log.emoji ?? '🍽️'}
                                    </div>`
                                }
                            </div>
                            <div class="flex-grow-1">
                                <p class="name-meal fw-bold m-0 mb-1" style="font-size:0.82rem;">${log.name}</p>
                                <p class="m-0" style="font-size:0.7rem;color:#6B7280;">
                                    ${Math.round(log.calories)} kcal &middot; ${log.protein}g protein &middot;
                                    ${log.servings} porsi
                                </p>
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
        const loading = document.getElementById('days-loading');
        const timeline = document.getElementById('days-timeline');
        loading.style.display = 'block';
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

        /* Update date labels */
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
            daysLoad(daysCurrentDate);
        } catch (e) {
            console.error('daysDeleteLog:', e);
        }
    };

    /* ── Date Navigation ────────────────────────────── */
    document.getElementById('days-prev-btn').addEventListener('click', () => {
        const d = new Date(daysCurrentDate + 'T00:00:00');
        d.setDate(d.getDate() - 1);
        daysCurrentDate = d.toISOString().split('T')[0];
        daysLoad(daysCurrentDate);
    });

    document.getElementById('days-next-btn').addEventListener('click', () => {
        const d = new Date(daysCurrentDate + 'T00:00:00');
        d.setDate(d.getDate() + 1);
        daysCurrentDate = d.toISOString().split('T')[0];
        daysLoad(daysCurrentDate);
    });

    /* ── Listen for meal-added event from modal ─────── */
    window.addEventListener('meal-added', function (e) {
        const data = e.detail;
        if (data.grouped) renderTimeline(data.grouped);
        if (data.totals)  updateNutritionPanel(data.totals);
    });

    /* ── Boot: render server-side data immediately,
            then re-fetch in background to stay fresh ── */
    (function boot() {
        renderTimeline(INIT.groupedLogs);
        updateNutritionPanel(INIT.dailyTotals);
        /* Background refresh to keep in sync */
        setTimeout(() => daysLoad(daysCurrentDate), 800);
    })();

})();
</script>
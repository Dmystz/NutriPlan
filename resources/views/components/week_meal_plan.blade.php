{{--
    week_meal_plan.blade.php
    ────────────────────────
    Week view for Meal Plan page.
    - Left sidebar  : today's timeline meals (reuses meal_template component)
    - Right grid    : 6 upcoming days (max), each card cycles orange → green button
                      Cards can be in two states:
                        • unplanned  – "No meals plan yet." + Plan Manually button
                        • planned    – mini meal preview + Edit Plan button  (meal_template data)
    No existing CSS attributes were changed.
    New classes added at the bottom of this file's <style> block.
--}}

{{-- ════════════════════════════════════════════════════════════════
     ADDITIONAL STYLES  (new classes only — existing ones untouched)
     ════════════════════════════════════════════════════════════════ --}}
<style>
    /* Week grid card — unplanned */
    .week-card {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        min-height: 11rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
        transition: box-shadow 0.2s ease;
    }

    .week-card:hover {
        box-shadow: 0 6px 22px 0 rgba(140, 136, 136, 0.30);
    }

    /* Week grid card — planned state */
    .week-card-planned {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        min-height: 11rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
        transition: box-shadow 0.2s ease;
    }

    .week-card-planned:hover {
        box-shadow: 0 6px 22px 0 rgba(140, 136, 136, 0.30);
    }

    /* "Planned" badge */
    .badge-planned {
        font-size: 0.5rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.10);
        border-radius: 6px;
        padding: 2px 6px;
    }

    /* Day label inside card */
    .week-card-date {
        font-size: 0.78rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
    }

    /* "No meals plan yet." text */
    .week-no-plan-txt {
        font-size: 0.75rem;
        font-weight: 500;
        color: #374151;
    }

    /* Plan Manually — orange variant */
    .btn-plan-oren {
        width: 100%;
        background: var(--warna-oren);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 500;
        border: none;
        border-radius: 50px;
        padding: 0.45rem 0;
        transition: background 0.2s ease;
        cursor: pointer;
    }

    .btn-plan-oren:hover {
        background: #cd4c22;
    }

    /* Plan Manually — green variant */
    .btn-plan-ijo {
        width: 100%;
        background: var(--warna-ijo);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 500;
        border: none;
        border-radius: 50px;
        padding: 0.45rem 0;
        transition: background 0.2s ease;
        cursor: pointer;
    }

    .btn-plan-ijo:hover {
        background: #6e9c29;
    }

    /* Edit Plan button (after planned) */
    .btn-edit-plan {
        width: 100%;
        background: #F3F4F6;
        color: #374151;
        font-size: 0.72rem;
        font-weight: 500;
        border: none;
        border-radius: 50px;
        padding: 0.38rem 0;
        transition: background 0.2s ease;
        cursor: pointer;
        margin-top: 0.5rem;
    }

    .btn-edit-plan:hover {
        background: #E5E7EB;
    }

    /* Meal preview image inside planned card */
    .gambar-meal-week {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    /* Nutrition row inside planned card */
    .week-nutrition-row {
        border-top: 0.8px solid rgba(0, 0, 0, 0.08);
        padding-top: 0.5rem;
        margin-top: 0.5rem;
        display: flex;
        justify-content: space-between;
    }

    /* Today's meal sidebar wrapper for week view */
    .wrapper-meal-week-sidebar {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        overflow-y: auto;
        max-height: 72vh;
    }

    .wrapper-meal-week-sidebar::-webkit-scrollbar {
        display: none;
    }

    /* Section title above the grid */
    .week-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .week-section-sub {
        font-size: 0.75rem;
        color: #6B7280;
    }
</style>

{{-- ════════════════════════════════════════════════════════════════
     WEEK VIEW LAYOUT
     ════════════════════════════════════════════════════════════════ --}}
<div class="row g-0 py-3">
    <div class="col-12">
        <div class="d-flex gap-3 flex-column flex-lg-row">

            {{-- ── LEFT: Today's timeline sidebar ─────────────────── --}}
            <div class="flex-shrink-0" style="width: 100%; max-width: 310px;">
                <div class="wrapper-meal-week-sidebar p-3">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0" style="font-size:0.9rem;">Today's Meals</h6>
                        <span class="week-section-sub">5 meals · 1.2L water</span>
                    </div>

                    {{-- Timeline meals — reuse meal_template component --}}
                    @include('components.meal_template', [
                        'time' => '8:00',
                        'meal_type' => 'BREAKFAST',
                        'meal_name' => 'Avocado Toast & Poached Eggs',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Quick Meal',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'Balanced',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '420',
                        'protein' => '22',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '10:30',
                        'meal_type' => 'SNACK',
                        'meal_name' => 'Greek Yogurt with Berries',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Light',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'High Protein',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '180',
                        'protein' => '14',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '13:00',
                        'meal_type' => 'LUNCH',
                        'meal_name' => 'Grilled Chicken Quinoa Bowl',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'High Protein',
                        'ktg1_class' => 'ktg-ijo-home',
                        'ktg2_label' => 'Balanced',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '560',
                        'protein' => '38',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '16:00',
                        'meal_type' => 'SNACK',
                        'meal_name' => 'Mixed Nuts & Apple',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Energy',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'Quick Meal',
                        'ktg2_class' => 'ktg-oren-home',
                        'kcal' => '220',
                        'protein' => '7',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '19:30',
                        'meal_type' => 'DINNER',
                        'meal_name' => 'Salmon & Steamed Vegetables',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Keto',
                        'ktg1_class' => 'ktg-ijo-home',
                        'ktg2_label' => 'Dinner',
                        'ktg2_class' => 'ktg-oren-home',
                        'kcal' => '520',
                        'protein' => '45',
                        'is_last' => true,
                    ])

                </div>
            </div>
            {{-- ── END LEFT ─────────────────────────────────────── --}}


            {{-- ── RIGHT: 6-day upcoming grid ─────────────────────── --}}
            <div class="flex-grow-1">

                {{--
                    Buat 6 hari ini secara dinamis.
                    $upcomingDays bisa melingkupi Collection/array of:
                      [
                        'date'        => Carbon instance,
                        'is_planned'  => bool,
                        'meal'        => [ 'name', 'image', 'ktg1_label', 'ktg1_class',
                                           'ktg2_label', 'ktg2_class', 'kcal', 'protein' ] | null
                      ]
                --}}
                @php
                    $upcomingDays =
                        $upcomingDays ??
                        collect(range(1, 6))->map(function ($i) {
                            $date = now()->addDays($i);
                            // Example: mark the 3rd day as already planned
                            $isPlanned = $i === 3;
                            return [
                                'date' => $date,
                                'is_planned' => $isPlanned,
                                'meal' => $isPlanned
                                    ? [
                                        'name' => 'Salmon & Asparagus',
                                        'image' => 'meal1_home.png',
                                        'ktg1_label' => 'Keto',
                                        'ktg1_class' => 'ktg-ijo-home',
                                        'ktg2_label' => 'Dinner',
                                        'ktg2_class' => 'ktg-oren-home',
                                        'kcal' => '520',
                                        'protein' => '45',
                                    ]
                                    : null,
                            ];
                        });

                    // Button colors alternate: odd = orange, even = green

                @endphp

                <div class="row py-0 g-3">
                    @foreach ($upcomingDays->take(6) as $i => $day)
                        <div class="col-12 col-sm-6 col-xl-4">

                            @if ($day['is_planned'])
                                {{-- ══ PLANNED STATE ══════════════════════════════ --}}
                                <div class="week-card-planned">

                                    {{-- Card header --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <p class="week-card-date m-0">
                                            {{ $day['date']->format('M j') }}<br>
                                            {{ $day['date']->format('l') }}
                                        </p>
                                        <span class="badge-planned">Planned</span>
                                    </div>

                                    {{-- Meal preview using meal_template data pattern --}}
                                    <div class="d-flex gap-2 align-items-start flex-grow-1">
                                        <img src="{{ asset('img/' . ($day['meal']['image'] ?? 'meal1_home.png')) }}"
                                            alt="{{ $day['meal']['name'] ?? 'Meal' }}" class="gambar-meal-week">

                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="name-meal fw-bold m-0 mb-1 p-0"
                                                style="font-size:0.78rem; line-height:1.3;">
                                                {{ $day['meal']['name'] }}
                                            </h6>
                                            <p class="category-meal d-flex mb-0 gap-1 fw-bold flex-wrap">
                                                @if (!empty($day['meal']['ktg1_label']))
                                                    <span
                                                        class="text-white px-1 {{ $day['meal']['ktg1_class'] ?? 'ktg-ijo-home' }}">
                                                        {{ $day['meal']['ktg1_label'] }}
                                                    </span>
                                                @endif
                                                @if (!empty($day['meal']['ktg2_label']))
                                                    <span
                                                        class="text-white px-1 {{ $day['meal']['ktg2_class'] ?? 'ktg-oren-home' }}">
                                                        {{ $day['meal']['ktg2_label'] }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Nutrition row --}}
                                    <div class="week-nutrition-row">
                                        <div class="d-flex align-items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 16 16" fill="none">
                                                <path
                                                    d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                                    stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <p class="font-size-s m-0">{{ $day['meal']['kcal'] ?? '0' }} kcal</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 16 16" fill="none">
                                                <g clip-path="url(#wk-clip-{{ $i }})">
                                                    <path
                                                        d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                        stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                        stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                        stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                                <defs>
                                                    <clipPath id="wk-clip-{{ $i }}">
                                                        <rect width="16" height="16" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p class="font-size-s m-0">{{ $day['meal']['protein'] ?? '0' }}g protein
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Edit Plan button --}}
                                    <button class="btn-edit-plan" data-bs-toggle="modal" data-bs-target="#modalEditPlan"
                                        data-date="{{ $day['date']->format('Y-m-d') }}"
                                        data-day="{{ $day['date']->format('D') }}"
                                        data-num="{{ $day['date']->format('j') }}"
                                        data-meal-name="{{ $day['meal']['name'] }}"
                                        data-kcal="{{ $day['meal']['kcal'] }}"
                                        data-protein="{{ $day['meal']['protein'] }}"
                                        data-ktg1="{{ $day['meal']['ktg1_label'] }}"
                                        data-ktg1class="{{ $day['meal']['ktg1_class'] }}"
                                        data-ktg2="{{ $day['meal']['ktg2_label'] }}"
                                        data-ktg2class="{{ $day['meal']['ktg2_class'] }}">
                                        Edit Plan
                                    </button>

                                </div>
                                {{-- ══ END PLANNED STATE ══════════════════════════ --}}
                            @else
                                {{-- ══ UNPLANNED STATE ════════════════════════════ --}}
                                <div class="week-card">

                                    {{-- Date label --}}
                                    <p class="week-card-date m-0">
                                        {{ $day['date']->format('M j') }}<br>
                                        {{ $day['date']->format('l') }}
                                    </p>

                                    {{-- CTA --}}
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <p class="week-no-plan-txt m-0">No meals plan yet.</p>

                                        {{-- Alternate button color: odd index = orange, even index = green --}}
                                        @if ($i % 2 === 0)
                                            <button class="btn-plan-oren" data-bs-toggle="modal"
                                                data-bs-target="#modalPlanManually"
                                                data-date="{{ $day['date']->format('Y-m-d') }}"
                                                data-day="{{ $day['date']->format('D') }}"
                                                data-num="{{ $day['date']->format('j') }}">
                                                Plan Manually
                                            </button>
                                        @else
                                            <button class="btn-plan-ijo" data-bs-toggle="modal"
                                                data-bs-target="#modalPlanManually"
                                                data-date="{{ $day['date']->format('Y-m-d') }}"
                                                data-day="{{ $day['date']->format('D') }}"
                                                data-num="{{ $day['date']->format('j') }}">
                                                Plan Manually
                                            </button>
                                        @endif
                                    </div>

                                </div>
                                {{-- ══ END UNPLANNED STATE ════════════════════════ --}}
                            @endif

                        </div>
                    @endforeach
                </div>
                {{-- END .row --}}

            </div>
            {{-- ── END RIGHT ────────────────────────────────────── --}}

        </div>
    </div>
    @include('components.modal_plan_manually')
    @include('components.modal_edit_plan')
</div>
<script>
    // ── PLAN MANUALLY ──────────────────────────────────────────

    let pmServ = 1;

    // Saat modal dibuka, set date chip sesuai tombol yang diklik
    document.addEventListener('show.bs.modal', function(e) {
        if (e.target.id === 'modalPlanManually') {
            const btn = e.relatedTarget;
            const day = btn?.dataset.day ?? '';
            const num = btn?.dataset.num ?? '';
            const date = btn?.dataset.date ?? '';

            // Highlight chip yang sesuai
            document.querySelectorAll('#pm-date-row .date-chip').forEach(chip => {
                chip.classList.toggle('active', chip.dataset.date === date);
            });

            // Default slot ke Lunch
            document.querySelectorAll('#modalPlanManually .time-slot-modal').forEach((s, i) => {
                s.classList.toggle('active', i === 2);
            });

            // Reset serv
            pmServ = 1;
            document.getElementById('pm-serv-val').textContent = '1';

            // Reset search
            document.getElementById('pm-search').value = '';
            pmFilterMeals('');
        }

        if (e.target.id === 'modalEditPlan') {
            const btn = e.relatedTarget;
            if (!btn) return;

            // Isi subtitle
            document.getElementById('ep-subtitle').textContent =
                `${btn.dataset.day ?? ''}, ${btn.dataset.date ?? ''} · Lunch at 13:00`;

            // Isi meal info
            document.getElementById('ep-meal-name').textContent = btn.dataset.mealName ?? '—';
            document.getElementById('ep-meal-macro').textContent =
                `${btn.dataset.kcal ?? '—'} kcal · ${btn.dataset.protein ?? '—'}g protein`;

            // Tags
            const tagsEl = document.getElementById('ep-meal-tags');
            tagsEl.innerHTML = '';
            if (btn.dataset.ktg1) {
                tagsEl.innerHTML +=
                    `<span class="text-white px-1 ${btn.dataset.ktg1class ?? 'ktg-ijo-home'}">${btn.dataset.ktg1}</span>`;
            }
            if (btn.dataset.ktg2) {
                tagsEl.innerHTML +=
                    `<span class="text-white px-1 ${btn.dataset.ktg2class ?? 'ktg-oren-home'}">${btn.dataset.ktg2}</span>`;
            }

            // Reset tab ke Details
            epSwitchTabById('details');

            // Reset replace area
            document.getElementById('ep-replace-area').style.display = 'none';
        }
    });

    function pmSelectDate(el) {
        el.closest('.date-row').querySelectorAll('.date-chip')
            .forEach(d => d.classList.remove('active'));
        el.classList.add('active');
    }

    function pmSelectSlot(el) {
        el.closest('.time-slots-modal').querySelectorAll('.time-slot-modal')
            .forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }

    function pmToggleMeal(el) {
        el.closest('.meal-scroll-modal').querySelectorAll('.meal-result-row')
            .forEach(r => r.classList.remove('selected'));
        el.classList.add('selected');

        // Update nutrition preview
        document.getElementById('pm-kcal').textContent = el.dataset.kcal + '';
        document.getElementById('pm-protein').textContent = el.dataset.protein + 'g';
        document.getElementById('pm-carbs').textContent = el.dataset.carbs + 'g';
        document.getElementById('pm-fat').textContent = el.dataset.fat + 'g';
        document.getElementById('pm-fiber').textContent = el.dataset.fiber + 'g';
    }

    function pmChangeServ(d) {
        pmServ = Math.max(1, pmServ + d);
        document.getElementById('pm-serv-val').textContent = pmServ;
    }

    function pmFilterMeals(q) {
        document.querySelectorAll('#pm-meal-list .meal-result-row').forEach(r => {
            const name = r.querySelector('.mrr-name').textContent.toLowerCase();
            r.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    function pmSavePlan() {
        // Ambil data yang dipilih
        const selectedDate = document.querySelector('#pm-date-row .date-chip.active')?.dataset.date;
        const selectedSlot = document.querySelector('#modalPlanManually .time-slot-modal.active .ts-type')?.textContent;
        const selectedMeal = document.querySelector('#pm-meal-list .meal-result-row.selected .mrr-name')?.textContent;
        const customTime = document.getElementById('pm-custom-time').value;

        console.log({
            selectedDate,
            selectedSlot,
            selectedMeal,
            customTime,
            serv: pmServ
        });

        // TODO: kirim ke server via fetch/axios
        // fetch('/meal-plan', { method:'POST', body: JSON.stringify({...}) })

        bootstrap.Modal.getInstance(document.getElementById('modalPlanManually')).hide();
    }


    // ── EDIT PLAN ───────────────────────────────────────────────

    let epServ = 1;

    function epToggleReplace() {
        const area = document.getElementById('ep-replace-area');
        area.style.display = area.style.display === 'none' ? 'block' : 'none';
    }

    function epToggleMeal(el) {
        el.closest('.meal-scroll-modal').querySelectorAll('.meal-result-row')
            .forEach(r => r.classList.remove('selected'));
        el.classList.add('selected');
    }

    function epFilterMeals(q) {
        document.querySelectorAll('#ep-meal-list .meal-result-row').forEach(r => {
            const name = r.querySelector('.mrr-name').textContent.toLowerCase();
            r.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    function epSwitchTab(btn, tab) {
        btn.closest('.tab-toggle-modal').querySelectorAll('.tab-btn-modal')
            .forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        epSwitchTabById(tab);
    }

    function epSwitchTabById(tab) {
        ['details', 'reschedule', 'nutrition'].forEach(t => {
            const el = document.getElementById('ep-tab-' + t);
            if (el) el.style.display = t === tab ? 'block' : 'none';
        });
        // Sync tab button active state
        document.querySelectorAll('#modalEditPlan .tab-btn-modal').forEach(b => {
            b.classList.toggle('active', b.getAttribute('onclick').includes(tab));
        });
    }

    function epSelectDate(el) {
        el.closest('.date-row').querySelectorAll('.date-chip')
            .forEach(d => d.classList.remove('active'));
        el.classList.add('active');
    }

    function epSelectSlot(el) {
        el.closest('.time-slots-modal').querySelectorAll('.time-slot-modal')
            .forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }

    function epChangeServ(d) {
        epServ = Math.max(1, epServ + d);
        document.getElementById('ep-serv-val').textContent = epServ;
    }

    function epDeletePlan() {
        if (!confirm('Yakin ingin menghapus plan ini?')) return;
        // TODO: kirim DELETE request ke server
        bootstrap.Modal.getInstance(document.getElementById('modalEditPlan')).hide();
    }

    function epSavePlan() {
        // TODO: kirim PUT/PATCH request ke server
        bootstrap.Modal.getInstance(document.getElementById('modalEditPlan')).hide();
    }
</script>
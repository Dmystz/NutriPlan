{{--
    resources/views/components/week_meal_plan.blade.php
    ────────────────────────────────────────────────────
    Week view for Meal Plan.
    • Left sidebar   → today's MealLog grouped by slot (API)
    • Right grid     → 6 upcoming JadwalMakanan days (dari $upcomingDays)
      – Planned card  → pakai struktur meal_template.blade.php DAYS VIEW
      – Unplanned card → tombol Plan Manually
    • Modal Plan Manually → list makanan dari /api/foods (DB), simpan ke /api/meal-logs
    • Delete / Edit jadwal via AJAX
--}}

<style>
    /* ── Week grid cards ── */
    .week-card {
        border-radius: 16px; border: .8px solid rgba(0,0,0,.08);
        background: rgba(255,248,240,.92);
        box-shadow: 0 4px 16px 0 rgba(140,136,136,.18);
        backdrop-filter: blur(5px);
        min-height: 11rem; display: flex; flex-direction: column;
        justify-content: space-between; padding: 1rem;
        transition: box-shadow .2s ease;
    }
    .week-card:hover { box-shadow: 0 6px 22px 0 rgba(140,136,136,.30); }

    .week-card-planned {
        border-radius: 16px; border: .8px solid rgba(0,0,0,.08);
        background: rgba(255,248,240,.92);
        box-shadow: 0 4px 16px 0 rgba(140,136,136,.18);
        backdrop-filter: blur(5px);
        min-height: 11rem; display: flex; flex-direction: column;
        justify-content: space-between; padding: 1rem;
        transition: box-shadow .2s ease;
    }
    .week-card-planned:hover { box-shadow: 0 6px 22px 0 rgba(140,136,136,.30); }

    .badge-planned {
        font-size: .5rem; font-weight: 700; letter-spacing: .05em;
        text-transform: uppercase; color: var(--warna-oren);
        background: rgba(234,92,43,.10); border-radius: 6px; padding: 2px 6px;
    }
    .week-card-date   { font-size: .78rem; font-weight: 700; color: #111827; line-height: 1.3; }
    .week-no-plan-txt { font-size: .75rem; font-weight: 500; color: #374151; }

    .btn-plan-oren {
        width: 100%; background: var(--warna-oren); color: #fff;
        font-size: .78rem; font-weight: 500; border: none;
        border-radius: 50px; padding: .45rem 0;
        transition: background .2s ease; cursor: pointer;
    }
    .btn-plan-oren:hover { background: #cd4c22; }

    .btn-plan-ijo {
        width: 100%; background: var(--warna-ijo); color: #fff;
        font-size: .78rem; font-weight: 500; border: none;
        border-radius: 50px; padding: .45rem 0;
        transition: background .2s ease; cursor: pointer;
    }
    .btn-plan-ijo:hover { background: #6e9c29; }

    .btn-edit-plan {
        width: 100%; background: #F3F4F6; color: #374151;
        font-size: .72rem; font-weight: 500; border: none;
        border-radius: 50px; padding: .38rem 0;
        transition: background .2s ease; cursor: pointer; margin-top: .5rem;
    }
    .btn-edit-plan:hover { background: #E5E7EB; }

    .btn-delete-jadwal {
        background: rgba(255,80,60,.08); color: #DC2626;
        font-size: .68rem; font-weight: 600; border: none;
        border-radius: 50px; padding: .3rem .7rem;
        cursor: pointer; margin-top: .35rem; width: 100%;
        transition: background .2s ease;
    }
    .btn-delete-jadwal:hover { background: rgba(255,80,60,.18); }

    /* ── Meal template classes (week planned card) ── */
    .gambar-meal-week { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; flex-shrink: 0; }
    .week-nutrition-row {
        border-top: .8px solid rgba(0,0,0,.08); padding-top: .5rem; margin-top: .5rem;
        display: flex; justify-content: space-between;
    }

    /* ── Sidebar ── */
    .wrapper-meal-week-sidebar {
        border-radius: 16px; border: .8px solid rgba(0,0,0,.08);
        background: rgba(255,248,240,.92);
        box-shadow: 0 4px 16px 0 rgba(140,136,136,.18);
        backdrop-filter: blur(5px); overflow-y: auto; max-height: 72vh;
    }
    .wrapper-meal-week-sidebar::-webkit-scrollbar { display: none; }

    .sidebar-slot-label {
        font-size: .6rem; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase; color: #9CA3AF; margin-bottom: 4px;
    }
    .sidebar-meal-row   { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .sidebar-dot        { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .sidebar-meal-name  { font-size: .75rem; font-weight: 600; color: #111827; margin: 0; line-height: 1.3; }
    .sidebar-meal-macro { font-size: .67rem; color: #6B7280; margin: 0; }
    .week-empty-sidebar { text-align: center; padding: 24px 0; }
    .week-empty-sidebar p { font-size: .78rem; color: #9CA3AF; margin: 0; }

    /* ── Plan Manually modal food list ── */
    .pm-food-item {
        display: flex; align-items: center; gap: 10px;
        padding: .55rem .75rem; border-radius: 10px;
        cursor: pointer; transition: background .15s ease;
        border: 1.5px solid transparent;
    }
    .pm-food-item:hover   { background: rgba(0,0,0,.04); }
    .pm-food-item.selected {
        background: rgba(234,92,43,.08);
        border-color: var(--warna-oren);
    }
    .pm-food-img {
        width: 42px; height: 42px; border-radius: 8px;
        object-fit: cover; flex-shrink: 0;
        background: rgba(0,0,0,.05);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
    .pm-food-name  { font-size: .8rem; font-weight: 600; color: #111827; margin: 0; }
    .pm-food-macro { font-size: .68rem; color: #6B7280; margin: 0; }
    .pm-food-list  { max-height: 260px; overflow-y: auto; }
    .pm-food-list::-webkit-scrollbar { width: 4px; }
    .pm-food-list::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }

    /* ── Slot buttons active states ── */
    .pm-slot-btn.active-breakfast { background: #EA5C2B !important; color: #fff !important; border-color: #EA5C2B !important; }
    .pm-slot-btn.active-snack     { background: #FE9A00 !important; color: #fff !important; border-color: #FE9A00 !important; }
    .pm-slot-btn.active-lunch     { background: #95CD41 !important; color: #fff !important; border-color: #95CD41 !important; }
    .pm-slot-btn.active-dinner    { background: #6366F1 !important; color: #fff !important; border-color: #6366F1 !important; }

    /* ── Save button loading state ── */
    .btn-pm-save { transition: opacity .2s ease; }
    .btn-pm-save:disabled { opacity: .65; cursor: not-allowed; }

    /* ── Selected food preview strip ── */
    .pm-selected-preview {
        display: flex; align-items: center; gap: 8px;
        padding: .5rem .75rem; border-radius: 10px;
        background: rgba(234,92,43,.06); border: 1px solid rgba(234,92,43,.2);
        margin-bottom: .75rem;
    }
    .pm-selected-preview-name { font-size: .78rem; font-weight: 600; color: #EA5C2B; margin: 0; }
    .pm-selected-preview-macro { font-size: .67rem; color: #6B7280; margin: 0; }

    /* ── Card flip animation saat unplanned → planned ── */
    @keyframes cardAppear {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .week-card-planned.just-planned {
        animation: cardAppear .35s ease forwards;
    }
</style>

<div class="row g-0 py-3">
    <div class="col-12">
        <div class="d-flex gap-3 flex-column flex-lg-row">

            {{-- ── LEFT: Today's sidebar (live dari MealLog API) ── --}}
            <div class="flex-shrink-0" style="width:100%;max-width:310px;">
                <div class="wrapper-meal-week-sidebar p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0" style="font-size:.9rem;">Today's Meals</h6>
                        <span class="week-section-sub" id="week-sidebar-count">—</span>
                    </div>
                    <div id="week-sidebar-content">
                        <div class="week-empty-sidebar"><p>⏳ Memuat...</p></div>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: 6-day upcoming grid ── --}}
            <div class="flex-grow-1">
                <div class="row py-0 g-3" id="week-grid">

                    @php
                        $upcomingDays = $upcomingDays ?? collect();
                    @endphp

                    @forelse ($upcomingDays->take(6) as $i => $day)
                        {{-- data-date agar JS bisa temukan card berdasarkan tanggal --}}
                        <div class="col-12 col-sm-6 col-xl-4" data-week-col="{{ $day['date']->format('Y-m-d') }}">

                            @if ($day['is_planned'] && $day['meal'])
                                {{-- ══ PLANNED — pakai struktur meal_template DAYS VIEW ══ --}}
                                <div class="week-card-planned">

                                    {{-- Header: tanggal + badge --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <p class="week-card-date m-0">
                                            {{ $day['date']->format('M j') }}<br>
                                            {{ $day['date']->format('l') }}
                                        </p>
                                        <span class="badge-planned">Planned</span>
                                    </div>

                                    {{-- ── meal_template DAYS VIEW structure ── --}}
                                    <div class="d-flex align-items-start mb-2 timeline-meal-row">

                                        {{-- Time col --}}
                                        <div class="meal-time-col">
                                            <span class="meal-time-text">
                                                {{ $day['meal']['meal_time'] ?? '—' }}
                                            </span>
                                        </div>

                                        {{-- Dot col (no line — single item per card) --}}
                                        <div class="meal-timeline-col">
                                            <div class="meal-dot-timeline"></div>
                                        </div>

                                        {{-- Card content --}}
                                        <div class="wrapper-content-meal-days d-flex px-2 py-1 flex-grow-1">

                                            {{-- Image --}}
                                            <div class="d-flex align-items-center flex-shrink-0">
                                                @if (!empty($day['meal']['image']))
                                                    <img src="{{ asset('img/' . $day['meal']['image']) }}"
                                                        alt="{{ $day['meal']['name'] }}"
                                                        class="gambar-meal gambar-meal-week"
                                                        onerror="this.src='{{ asset('img/meal1_home.png') }}'">
                                                @else
                                                    <div class="gambar-meal gambar-meal-week d-flex align-items-center justify-content-center"
                                                        style="background:rgba(0,0,0,.04);border-radius:10px;font-size:1.4rem;">
                                                        🍽️
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Info --}}
                                            <div class="d-flex flex-column ms-2 justify-content-center flex-grow-1">

                                                {{-- Meal type --}}
                                                <p class="type-meal m-0 p-0">
                                                    {{ $day['meal']['meal_type'] ?? 'MEAL' }}
                                                </p>

                                                {{-- Meal name --}}
                                                <h6 class="name-meal mb-1 p-0 fw-bold" style="font-size:.78rem;line-height:1.3;">
                                                    {{ $day['meal']['name'] }}
                                                </h6>

                                                {{-- Category badges --}}
                                                @if (!empty($day['meal']['ktg1_label']) || !empty($day['meal']['ktg2_label']))
                                                    <p class="category-meal d-flex mb-1 gap-1 fw-bold flex-wrap">
                                                        @if (!empty($day['meal']['ktg1_label']))
                                                            <span class="text-white px-1 {{ $day['meal']['ktg1_class'] ?? 'ktg-ijo-home' }}">
                                                                {{ $day['meal']['ktg1_label'] }}
                                                            </span>
                                                        @endif
                                                        @if (!empty($day['meal']['ktg2_label']))
                                                            <span class="text-white px-1 {{ $day['meal']['ktg2_class'] ?? 'ktg-oren-home' }}">
                                                                {{ $day['meal']['ktg2_label'] }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                @endif

                                                {{-- Nutrition --}}
                                                <div class="d-flex align-items-center gap-3 nutrition-meal flex-wrap">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 16 16" fill="none">
                                                            <path d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                                                stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <p class="font-size-s m-0">{{ $day['meal']['kcal'] ?? '0' }} kcal</p>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 16 16" fill="none">
                                                            <g clip-path="url(#clip_week_{{ $i }})">
                                                                <path d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip_week_{{ $i }}">
                                                                    <rect width="16" height="16" fill="white"/>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                        <p class="font-size-s m-0">{{ $day['meal']['protein'] ?? '0' }}g protein</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Edit + Delete buttons --}}
                                    <button class="btn-edit-plan"
                                        data-bs-toggle="modal" data-bs-target="#modalEditPlan"
                                        data-date="{{ $day['date']->format('Y-m-d') }}"
                                        data-day="{{ $day['date']->format('D') }}"
                                        data-num="{{ $day['date']->format('j') }}"
                                        data-meal-name="{{ $day['meal']['name'] }}"
                                        data-kcal="{{ $day['meal']['kcal'] }}"
                                        data-protein="{{ $day['meal']['protein'] }}"
                                        data-ktg1="{{ $day['meal']['ktg1_label'] ?? '' }}"
                                        data-ktg1class="{{ $day['meal']['ktg1_class'] ?? 'ktg-ijo-home' }}"
                                        data-ktg2="{{ $day['meal']['ktg2_label'] ?? '' }}"
                                        data-ktg2class="{{ $day['meal']['ktg2_class'] ?? 'ktg-oren-home' }}"
                                        data-jadwal-ids="{{ $day['jadwals']->pluck('id')->implode(',') }}">
                                        ✏️ Edit Plan
                                    </button>

                                    @if ($day['jadwals']->isNotEmpty())
                                        <button class="btn-delete-jadwal"
                                            onclick="weekDeleteJadwal({{ $day['jadwals']->first()->id }}, this)">
                                            🗑 Hapus Plan
                                        </button>
                                    @endif

                                </div>

                            @else
                                {{-- ══ UNPLANNED ══ --}}
                                <div class="week-card">
                                    <p class="week-card-date m-0">
                                        {{ $day['date']->format('M j') }}<br>
                                        {{ $day['date']->format('l') }}
                                    </p>
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <p class="week-no-plan-txt m-0">No meals planned yet.</p>
                                        @if ($i % 2 === 0)
                                            <button class="btn-plan-oren"
                                                data-bs-toggle="modal" data-bs-target="#modalPlanManually"
                                                data-date="{{ $day['date']->format('Y-m-d') }}"
                                                data-day="{{ $day['date']->format('D') }}"
                                                data-num="{{ $day['date']->format('j') }}"
                                                data-label="{{ $day['date']->format('D') }}, {{ $day['date']->format('M j') }}"
                                                data-date-display="{{ $day['date']->format('M j') }}"
                                                data-date-day="{{ $day['date']->format('l') }}">
                                                + Plan Manually
                                            </button>
                                        @else
                                            <button class="btn-plan-ijo"
                                                data-bs-toggle="modal" data-bs-target="#modalPlanManually"
                                                data-date="{{ $day['date']->format('Y-m-d') }}"
                                                data-day="{{ $day['date']->format('D') }}"
                                                data-num="{{ $day['date']->format('j') }}"
                                                data-label="{{ $day['date']->format('D') }}, {{ $day['date']->format('M j') }}"
                                                data-date-display="{{ $day['date']->format('M j') }}"
                                                data-date-day="{{ $day['date']->format('l') }}">
                                                + Plan Manually
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center py-4" style="font-size:.82rem;">
                                Belum ada data minggu mendatang.
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    @include('components.modal_edit_plan')
</div>

{{-- ══════════════════════════════════════════
     MODAL PLAN MANUALLY
══════════════════════════════════════════ --}}
<div class="modal fade" id="modalPlanManually" tabindex="-1" aria-labelledby="modalPlanManuallyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
        <div class="modal-content" style="border-radius:20px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15);">

            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="modalPlanManuallyLabel">
                        📅 Plan Manually
                    </h5>
                    <p class="text-muted mb-0" style="font-size:.78rem;" id="pm-subtitle">
                        Pilih makanan untuk hari ini
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 pt-3 pb-2">

                {{-- ── 1. Slot Waktu Makan ── --}}
                <p class="fw-bold mb-1" style="font-size:.78rem;">⏰ Waktu Makan</p>
                <div class="d-flex gap-2 mb-3 flex-wrap" id="pm-slot-row">
                    <button type="button" class="btn btn-sm rounded-pill pm-slot-btn btn-outline-secondary"
                        data-slot="breakfast" onclick="pmSelectSlot(this)" style="font-size:.72rem;">
                        ☀️ Breakfast
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill pm-slot-btn btn-outline-secondary"
                        data-slot="snack" onclick="pmSelectSlot(this)" style="font-size:.72rem;">
                        🍎 Snack
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill pm-slot-btn btn-outline-secondary active-lunch"
                        data-slot="lunch" onclick="pmSelectSlot(this)" style="font-size:.72rem;">
                        🥗 Lunch
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill pm-slot-btn btn-outline-secondary"
                        data-slot="dinner" onclick="pmSelectSlot(this)" style="font-size:.72rem;">
                        🌙 Dinner
                    </button>
                </div>

                {{-- ── 2. Jam & Porsi ── --}}
                <div class="d-flex align-items-center gap-4 mb-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <label class="fw-bold mb-0" style="font-size:.78rem;white-space:nowrap;">🕐 Jam:</label>
                        <input type="time" id="pm-custom-time" class="form-control form-control-sm"
                            style="max-width:120px;border-radius:10px;" value="13:00">
                        <span style="font-size:.68rem;color:#9CA3AF;">Opsional</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <p class="fw-bold mb-0" style="font-size:.78rem;">🍽 Porsi:</p>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button"
                                class="btn btn-outline-secondary btn-sm rounded-circle"
                                style="width:28px;height:28px;padding:0;font-size:.9rem;line-height:1;"
                                onclick="pmChangeServ(-1)">−</button>
                            <span id="pm-serv-val" class="fw-bold" style="min-width:22px;text-align:center;font-size:.9rem;">1</span>
                            <button type="button"
                                class="btn btn-outline-secondary btn-sm rounded-circle"
                                style="width:28px;height:28px;padding:0;font-size:.9rem;line-height:1;"
                                onclick="pmChangeServ(1)">+</button>
                        </div>
                    </div>
                </div>

                {{-- ── 3. Search Makanan ── --}}
                <p class="fw-bold mb-1" style="font-size:.78rem;">🔍 Pilih Makanan</p>
                <div class="position-relative mb-2">
                    <input type="text" id="pm-search" class="form-control form-control-sm"
                        placeholder="Cari nama makanan dari database..."
                        style="border-radius:10px;padding-left:2.2rem;font-size:.8rem;"
                        oninput="pmFilterFoods(this.value)">
                    <span style="position:absolute;left:.7rem;top:50%;transform:translateY(-50%);font-size:.82rem;pointer-events:none;">🔍</span>
                </div>

                <div id="pm-foods-loading" style="display:none;text-align:center;padding:20px 0;">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    <span class="ms-2" style="font-size:.75rem;color:#6B7280;">Memuat makanan dari database...</span>
                </div>

                <div class="pm-food-list" id="pm-food-list"></div>

                <div id="pm-foods-empty" style="display:none;text-align:center;padding:20px 0;">
                    <p style="font-size:.78rem;color:#9CA3AF;margin:0;">😕 Makanan tidak ditemukan.</p>
                </div>

                {{-- ── 4. Selected food preview ── --}}
                <div id="pm-selected-preview" style="display:none;" class="mt-2">
                    <p class="fw-bold mb-1" style="font-size:.72rem;color:#9CA3AF;text-transform:uppercase;letter-spacing:.04em;">
                        ✅ Makanan Dipilih
                    </p>
                    <div class="pm-selected-preview">
                        <span style="font-size:1.2rem;" id="pm-preview-emoji">🍽️</span>
                        <div>
                            <p class="pm-selected-preview-name" id="pm-preview-name">—</p>
                            <p class="pm-selected-preview-macro" id="pm-preview-macro">—</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" style="font-size:.82rem;"
                    data-bs-dismiss="modal">Batal</button>
                <button type="button" id="pm-save-btn"
                    class="btn oren text-white rounded-pill px-4 fw-bold btn-pm-save"
                    style="font-size:.82rem;"
                    onclick="pmSavePlan()">
                    💾 Simpan Plan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const CSRF   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const SLOTS  = ['Breakfast', 'Snack', 'Lunch', 'Dinner'];
    const COLORS = {
        Breakfast : 'var(--warna-oren)',
        Snack     : '#FE9A00',
        Lunch     : 'var(--warna-ijo)',
        Dinner    : '#6366F1'
    };
    const ICONS = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };
    const TIMES = { Breakfast:'08:00', Snack:'10:30', Lunch:'13:00', Dinner:'19:30' };

    const SLOT_ACTIVE_CLASS = {
        breakfast : 'active-breakfast',
        snack     : 'active-snack',
        lunch     : 'active-lunch',
        dinner    : 'active-dinner',
    };

    /* ══════════════════════════════════════════
       SIDEBAR — today's logs
    ══════════════════════════════════════════ */
    async function loadWeekSidebar() {
        const today   = new Date().toISOString().split('T')[0];
        const sidebar = document.getElementById('week-sidebar-content');
        const countEl = document.getElementById('week-sidebar-count');
        try {
            const res     = await fetch(`/api/meal-logs?date=${today}`, {
                headers: { Accept: 'application/json' }
            });
            const data    = await res.json();
            const grouped = data.grouped || {};
            let html  = '';
            let total = 0;

            SLOTS.forEach(slot => {
                const items = grouped[slot] || [];
                if (!items.length) return;
                total += items.length;
                html  += `<p class="sidebar-slot-label">${ICONS[slot]} ${slot}</p>`;
                items.forEach(log => {
                    html += `
                        <div class="sidebar-meal-row">
                            <div class="sidebar-dot" style="background:${COLORS[slot]};"></div>
                            <div>
                                <p class="sidebar-meal-name">${log.name}</p>
                                <p class="sidebar-meal-macro">
                                    ${Math.round(log.calories)} kcal &middot;
                                    ${log.meal_time ? log.meal_time.substring(0,5) : TIMES[slot]}
                                </p>
                            </div>
                        </div>`;
                });
            });

            if (total === 0) {
                html = `<div class="week-empty-sidebar">
                    <p>Belum ada makanan hari ini.<br>
                    <span style="font-size:.7rem;color:#D1D5DB;">Tambahkan melalui Plan Manually.</span></p>
                </div>`;
            }
            sidebar.innerHTML   = html;
            countEl.textContent = total + ' meal' + (total !== 1 ? 's' : '');
        } catch (e) {
            console.error('loadWeekSidebar:', e);
            sidebar.innerHTML = '<div class="week-empty-sidebar"><p>Gagal memuat data.</p></div>';
        }
    }
    async function loadWeekGrid() {
        try {
            const res  = await fetch('/api/week-meal-plan', { headers: { Accept: 'application/json' } });
            const days = await res.json();
            const grid = document.getElementById('week-grid');
            grid.innerHTML = '';

            days.forEach((day) => {
                const col = document.createElement('div');
                col.className = 'col-12 col-sm-6 col-xl-4';
                col.setAttribute('data-week-col', day.date);

                // Support both 'meals' array (baru) dan 'meal' singular (lama) 
                const meals = day.meals ?? (day.meal ? [day.meal] : []);
                const isPlanned = day.is_planned && meals.length > 0;

                if (isPlanned) {
                    // ── Build semua meal rows ──
                    const mealRowsHtml = meals.map(meal => {
                    const imgHtml = meal.image_path
                        ? `<img src="${meal.image_path}"
                                alt="${meal.name}"
                                class="gambar-meal gambar-meal-week"
                                onerror="this.outerHTML=`
                                    + "`" +
                                    `<div class='gambar-meal gambar-meal-week d-flex align-items-center justify-content-center'
                                            style='background:rgba(0,0,0,.04);border-radius:10px;font-size:1.4rem;'>
                                            ${meal.emoji ?? '🍽️'}
                                    </div>`
                                    + "`" +
                                `">`
                        : `<div class="gambar-meal gambar-meal-week d-flex align-items-center justify-content-center"
                                style="background:rgba(0,0,0,.04);border-radius:10px;font-size:1.4rem;">
                                ${meal.emoji ?? '🍽️'}
                        </div>`;
                        const slotIcon = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };

                        return `
                            <div class="d-flex align-items-start mb-2 timeline-meal-row"
                                style="border-bottom:.6px solid rgba(0,0,0,.06);padding-bottom:.6rem;">
                                <div class="meal-time-col">
                                    <span class="meal-time-text">${(meal.meal_time ?? '13:00').substring(0,5)}</span>
                                </div>
                                <div class="meal-timeline-col">
                                    <div class="meal-dot-timeline"></div>
                                </div>
                                <div class="wrapper-content-meal-days d-flex px-2 py-1 flex-grow-1">
                                    <div class="d-flex align-items-center flex-shrink-0">
                                        ${imgHtml}
                                    </div>
                                    <div class="d-flex flex-column ms-2 justify-content-center flex-grow-1">
                                        <p class="type-meal m-0 p-0">${slotIcon[meal.meal_slot] ?? '🍽️'} ${(meal.meal_slot ?? 'Meal').toUpperCase()}</p>
                                        <h6 class="name-meal mb-1 p-0 fw-bold" style="font-size:.78rem;line-height:1.3;">${meal.name}</h6>
                                        <div class="d-flex align-items-center gap-3 nutrition-meal flex-wrap">
                                            <p class="font-size-s m-0">${Math.round(meal.calories ?? 0)} kcal</p>
                                            <p class="font-size-s m-0">${meal.protein ?? 0}g protein</p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button class="btn-delete-jadwal" style="width:auto;padding:.25rem .5rem;margin-top:0;"
                                            onclick="weekDeleteLog(${meal.id ?? ''}, this)">
                                            🗑
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                    }).join('');

                    col.innerHTML = `
                        <div class="week-card-planned">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <p class="week-card-date m-0">${day.month_day}<br>${day.day_name}</p>
                                <span class="badge-planned">${meals.length} meal${meals.length > 1 ? 's' : ''}</span>
                            </div>
                            ${mealRowsHtml}
                            <button class="btn-plan-oren mt-2"
                                onclick="pmOpenModal(this)"
                                data-date="${day.date}"
                                data-date-display="${day.month_day}"
                                data-date-day="${day.day_name}"
                                data-label="${day.day_name}, ${day.month_day}">
                                + Add More
                            </button>
                        </div>
                    `;

                } else {
                    col.innerHTML = `
                        <div class="week-card">
                            <p class="week-card-date m-0">${day.month_day}<br>${day.day_name}</p>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <p class="week-no-plan-txt m-0">No meals planned yet.</p>
                                <button class="btn-plan-oren"
                                    onclick="pmOpenModal(this)"
                                    data-date="${day.date}"
                                    data-date-display="${day.month_day}"
                                    data-date-day="${day.day_name}"
                                    data-label="${day.day_name}, ${day.month_day}">
                                    + Plan Manually
                                </button>
                            </div>
                        </div>
                    `;
                }

                grid.appendChild(col);
            });

        } catch (e) {
            console.error('loadWeekGrid:', e);
        }
    }
    /* ══════════════════════════════════════════
       MODAL PLAN MANUALLY — state
    ══════════════════════════════════════════ */
    let pmServ            = 1;
    let pmFoodsCache      = [];
    let pmSelectedId      = null;
    let pmSelectedDate    = null;
    let pmSelectedFood    = null;
    let pmTriggerBtn      = null;   // tombol "Plan Manually" yang diklik — untuk update card DOM

    /* ── Load foods dari /api/foods ── */
    async function loadPmFoods() {
        const list    = document.getElementById('pm-food-list');
        const loading = document.getElementById('pm-foods-loading');
        const empty   = document.getElementById('pm-foods-empty');

        if (pmFoodsCache.length > 0) {
            renderPmFoods(pmFoodsCache);
            return;
        }

        loading.style.display = 'block';
        list.innerHTML        = '';
        empty.style.display   = 'none';

        try {
            const res  = await fetch('/api/foods', { headers: { Accept: 'application/json' } });
            const data = await res.json();
            pmFoodsCache = Array.isArray(data) ? data : (data.data ?? []);
            renderPmFoods(pmFoodsCache);
        } catch (e) {
            console.error('loadPmFoods:', e);
            list.innerHTML = '<p class="text-muted text-center py-3" style="font-size:.75rem;">Gagal memuat makanan.</p>';
        } finally {
            loading.style.display = 'none';
        }
    }

    /* ── Render food list ── */
    function renderPmFoods(foods) {
        const list  = document.getElementById('pm-food-list');
        const empty = document.getElementById('pm-foods-empty');
        list.innerHTML = '';

        if (!foods.length) { empty.style.display = 'block'; return; }
        empty.style.display = 'none';

        foods.forEach(food => {
            const name    = food.name    ?? food.nama    ?? '';
            const kcal    = Math.round(food.calories   ?? food.kalori      ?? 0);
            const protein = Math.round(food.protein    ?? food.protein_g   ?? 0);
            const carbs   = Math.round(food.carbs      ?? food.karbohidrat ?? 0);
            const fat     = Math.round(food.fat        ?? food.lemak       ?? 0);
            const emoji   = food.emoji  ?? '🍽️';

            const item = document.createElement('div');
            item.className       = 'pm-food-item';
            item.dataset.id      = food.id;
            item.dataset.name    = name;
            item.dataset.kcal    = kcal;
            item.dataset.protein = protein;
            item.dataset.emoji   = emoji;

            const imgHtml = food.image_path
                ? `<img src="${food.image_path}" alt="${name}"
                        class="pm-food-img" style="font-size:0;"
                        onerror="this.outerHTML='<div class=\\'pm-food-img\\'>${emoji}</div>'">`
                : `<div class="pm-food-img">${emoji}</div>`;

            item.innerHTML = `
                ${imgHtml}
                <div class="flex-grow-1">
                    <p class="pm-food-name">${name}</p>
                    <p class="pm-food-macro">
                        ${kcal} kcal &middot; ${protein}g protein &middot;
                        ${carbs}g carbs &middot; ${fat}g fat
                    </p>
                </div>
                <div style="flex-shrink:0;width:20px;text-align:center;" class="pm-check-icon">
                    <span style="color:var(--warna-oren);font-size:.9rem;display:none;">✓</span>
                </div>`;

            item.addEventListener('click', () => {
                document.querySelectorAll('#pm-food-list .pm-food-item').forEach(el => {
                    el.classList.remove('selected');
                    const chk = el.querySelector('.pm-check-icon span');
                    if (chk) chk.style.display = 'none';
                });
                item.classList.add('selected');
                const chk = item.querySelector('.pm-check-icon span');
                if (chk) chk.style.display = '';
                pmSelectedId   = food.id;
                pmSelectedFood = food;
                updatePmPreview(name, kcal, protein, emoji);
            });

            list.appendChild(item);
        });
    }

    function updatePmPreview(name, kcal, protein, emoji) {
        const preview = document.getElementById('pm-selected-preview');
        if (!preview) return;
        preview.style.display = 'block';
        document.getElementById('pm-preview-emoji').textContent = emoji;
        document.getElementById('pm-preview-name').textContent  = name;
        document.getElementById('pm-preview-macro').textContent =
            `${kcal} kcal · ${protein}g protein · ${pmServ} porsi`;
    }

    window.pmFilterFoods = function (q) {
        const lower = q.toLowerCase().trim();
        let visible = 0;
        document.querySelectorAll('#pm-food-list .pm-food-item').forEach(item => {
            const name = (item.dataset.name ?? '').toLowerCase();
            const show = lower === '' || name.includes(lower);
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('pm-foods-empty').style.display = visible === 0 ? 'block' : 'none';
    };

    window.pmSelectSlot = function (btn) {
        const slot = btn.dataset.slot;
        btn.closest('#pm-slot-row').querySelectorAll('.pm-slot-btn').forEach(b => {
            b.classList.remove('btn-outline-secondary',
                'active-breakfast','active-snack','active-lunch','active-dinner');
            b.classList.add('btn-outline-secondary');
        });
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add(SLOT_ACTIVE_CLASS[slot] ?? 'active-lunch');
        const timeInput = document.getElementById('pm-custom-time');
        const slotCap   = slot.charAt(0).toUpperCase() + slot.slice(1);
        if (timeInput && TIMES[slotCap]) timeInput.value = TIMES[slotCap];
    };

    window.pmChangeServ = function (d) {
        pmServ = Math.max(1, pmServ + d);
        const sv = document.getElementById('pm-serv-val');
        if (sv) sv.textContent = pmServ;
        if (pmSelectedFood) {
            const name    = pmSelectedFood.name ?? pmSelectedFood.nama ?? '';
            const kcal    = Math.round((pmSelectedFood.calories ?? pmSelectedFood.kalori    ?? 0) * pmServ);
            const protein = Math.round((pmSelectedFood.protein  ?? pmSelectedFood.protein_g ?? 0) * pmServ);
            document.getElementById('pm-preview-macro').textContent =
                `${kcal} kcal · ${protein}g protein · ${pmServ} porsi`;
        }
    };

    /* ══════════════════════════════════════════
       buildPlannedCardHTML
       Render inner HTML untuk .week-card-planned
       persis mengikuti struktur meal_template DAYS VIEW
    ══════════════════════════════════════════ */
    function buildPlannedCardHTML(food, slot, mealTime, dateDisplay, dateDay, logId, dateRaw) {
        const name    = food.name    ?? food.nama    ?? '';
        const kcal    = Math.round((food.calories ?? food.kalori    ?? 0) * pmServ);
        const protein = Math.round((food.protein  ?? food.protein_g ?? 0) * pmServ);
        const emoji   = food.emoji  ?? '🍽️';
        const slotCap  = slot.charAt(0).toUpperCase() + slot.slice(1);
        const slotIcon = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };

        const imgHtml = food.image_path
            ? `<img src="${food.image_path}" alt="${name}" class="gambar-meal gambar-meal-week"
                    onerror="this.style.display='none'">`
            : `<div class="gambar-meal gambar-meal-week d-flex align-items-center justify-content-center"
                    style="background:rgba(0,0,0,.04);border-radius:10px;font-size:1.4rem;">
                    ${emoji}
            </div>`;

        // ← SATU return saja, sudah include tombol Add More
        return `
            <div class="d-flex justify-content-between align-items-start mb-2">
                <p class="week-card-date m-0">${dateDisplay}<br>${dateDay}</p>
                <span class="badge-planned">Planned</span>
            </div>

            <div class="d-flex align-items-start mb-2 timeline-meal-row">
                <div class="meal-time-col">
                    <span class="meal-time-text">${mealTime}</span>
                </div>
                <div class="meal-timeline-col">
                    <div class="meal-dot-timeline"></div>
                </div>
                <div class="wrapper-content-meal-days d-flex px-2 py-1 flex-grow-1">
                    <div class="d-flex align-items-center flex-shrink-0">
                        ${imgHtml}
                    </div>
                    <div class="d-flex flex-column ms-2 justify-content-center flex-grow-1">
                        <p class="type-meal m-0 p-0">${slotIcon[slotCap] ?? '🍽️'} ${slotCap.toUpperCase()}</p>
                        <h6 class="name-meal mb-1 p-0 fw-bold" style="font-size:.78rem;line-height:1.3;">${name}</h6>
                        <div class="d-flex align-items-center gap-3 nutrition-meal flex-wrap">
                            <p class="font-size-s m-0">${kcal} kcal</p>
                            <p class="font-size-s m-0">${protein}g protein</p>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn-delete-jadwal"
                onclick="weekDeleteLog(${logId}, this)">
                🗑 Hapus Plan
            </button>

            <button class="btn-plan-oren mt-2"
                data-bs-toggle="modal"
                data-bs-target="#modalPlanManually"
                data-date="${dateRaw}"
                data-date-display="${dateDisplay}"
                data-date-day="${dateDay}"
                data-label="${dateDay}, ${dateDisplay}">
                + Add More
            </button>
        `;
    }

    /* ══════════════════════════════════════════
       updateWeekCard — ganti unplanned → planned di DOM
       Dipanggil setelah pmSavePlan berhasil
    ══════════════════════════════════════════ */
    function updateWeekCard(date, logData, slot, mealTime) {
        const col = document.querySelector(`[data-week-col="${date}"]`);
        if (!col) return;

        const dateDisplay = pmTriggerBtn?.dataset.dateDisplay ?? '';
        const dateDay     = pmTriggerBtn?.dataset.dateDay     ?? '';
        const logId       = logData.id ?? logData.data?.id ?? null;

        const newCard = document.createElement('div');
        newCard.className = 'week-card-planned just-planned';
        newCard.innerHTML = buildPlannedCardHTML(
            pmSelectedFood, slot, mealTime, dateDisplay, dateDay, logId, date
        );

        col.innerHTML = '';
        col.appendChild(newCard);

        setTimeout(() => newCard.classList.remove('just-planned'), 400);
    }

    /* ══════════════════════════════════════════
       DELETE log (untuk card yang baru dibuat via JS)
    ══════════════════════════════════════════ */
    window.weekDeleteLog = async function (logId, btn) {
        if (!confirm('Hapus makanan ini dari log?')) return;
        if (!logId) { location.reload(); return; }
        btn.disabled = true;
        try {
            const res = await fetch(`/api/meal-logs/${logId}`, {
                method : 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, Accept: 'application/json' }
            });
            if (res.ok) {
                // Refresh grid dari server — biar konsisten, termasuk kalau
                // masih ada meal lain di hari itu (jangan balik ke unplanned dulu)
                await loadWeekGrid();
                loadWeekSidebar();
            } else {
                alert('Gagal menghapus.');
                btn.disabled = false;
            }
        } catch (e) {
            console.error('weekDeleteLog:', e);
            btn.disabled = false;
        }
    };

    /* ── Simpan plan ── */
    window.pmSavePlan = async function () {
        const activeSlotBtn = document.querySelector('#pm-slot-row .pm-slot-btn:not(.btn-outline-secondary)');
        const selSlotRaw    = activeSlotBtn?.dataset.slot ?? 'lunch';
        const selSlot       = selSlotRaw.charAt(0).toUpperCase() + selSlotRaw.slice(1);
        const custTime      = document.getElementById('pm-custom-time')?.value || TIMES[selSlot] || '13:00';
        const saveBtn       = document.getElementById('pm-save-btn');

        if (!pmSelectedDate) {
            pmShowToast('⚠️ Tanggal tidak ditemukan. Tutup modal dan coba lagi.');
            return;
        }
        if (!pmSelectedId || !pmSelectedFood) {
            pmShowToast('⚠️ Pilih makanan terlebih dahulu sebelum menyimpan.');
            return;
        }

        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = '⏳ Menyimpan...'; }

        const today = new Date().toISOString().split('T')[0];
        const food  = pmSelectedFood;

        const payload = {
            food_id   : parseInt(pmSelectedId),
            name      : food.name    ?? food.nama      ?? '',
            category  : 'meal',
            meal_slot : selSlot,
            meal_time : custTime,
            servings  : pmServ,
            calories  : parseFloat(food.calories  ?? food.kalori      ?? 0) * pmServ,
            protein   : parseFloat(food.protein   ?? food.protein_g   ?? 0) * pmServ,
            carbs     : parseFloat(food.carbs     ?? food.karbohidrat ?? 0) * pmServ,
            fat       : parseFloat(food.fat       ?? food.lemak       ?? 0) * pmServ,
            log_date  : pmSelectedDate,
        };

        try {
            const res  = await fetch('/api/meal-logs', {
                method : 'POST',
                headers: {
                    'Content-Type' : 'application/json',
                    'X-CSRF-TOKEN' : CSRF,
                    'Accept'       : 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json().catch(() => ({}));

                if (res.ok) {
                /* Tutup modal */
                bootstrap.Modal.getInstance(document.getElementById('modalPlanManually'))?.hide();

                /* ── Refresh grid dari server ── */
                await loadWeekGrid();

                /* Kalau tanggal = hari ini, refresh sidebar juga */
                if (pmSelectedDate === today) {
                    loadWeekSidebar();
                    window.dispatchEvent(new CustomEvent('meal-added', { detail: data }));
                }

                pmShowToast('✅ Plan berhasil disimpan!');

            } else {
                const msg = data.message
                    ?? (data.errors
                        ? Object.values(data.errors).flat().join(', ')
                        : JSON.stringify(data));
                pmShowToast('❌ Gagal: ' + msg);
                if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = '💾 Simpan Plan'; }
            }
        } catch (e) {
            console.error('pmSavePlan:', e);
            pmShowToast('❌ Terjadi kesalahan jaringan.');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = '💾 Simpan Plan'; }
        }
    };

    /* ── Toast ── */
    function pmShowToast(msg, ms = 2800) {
        let t = document.getElementById('pm-toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'pm-toast';
            t.style.cssText =
                'display:none;position:fixed;bottom:28px;left:50%;transform:translateX(-50%);' +
                'background:#111827;color:#fff;padding:10px 22px;border-radius:50px;' +
                'font-size:.78rem;z-index:99999;white-space:nowrap;' +
                'box-shadow:0 4px 20px rgba(0,0,0,.25);transition:opacity .3s;';
            document.body.appendChild(t);
        }
        t.textContent   = msg;
        t.style.display = 'block';
        t.style.opacity = '1';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => { t.style.display = 'none'; t.style.opacity = '1'; }, 350);
        }, ms);
    }

    /* ══════════════════════════════════════════
       Modal open events
    ══════════════════════════════════════════ */
    document.addEventListener('show.bs.modal', function (e) {

        /* ── Plan Manually ── */
        if (e.target.id === 'modalPlanManually') {
            const btn = e.relatedTarget ?? document.activeElement;
            pmTriggerBtn = btn ?? null;

            /* Reset state */
            pmSelectedDate = btn?.dataset?.date
                ?? btn?.getAttribute?.('data-date')
                ?? null;
            pmSelectedId   = null;
            pmSelectedFood = null;
            pmServ         = 1;

            /* Subtitle */
            const sub = document.getElementById('pm-subtitle');
            if (sub && btn) {
                sub.textContent = `${btn.dataset.label ?? btn.dataset.day ?? ''} · Tambahkan makanan ke rencana`;
            }

            /* Reset UI */
            const sv = document.getElementById('pm-serv-val');
            if (sv) sv.textContent = '1';
            const search = document.getElementById('pm-search');
            if (search) { search.value = ''; pmFilterFoods(''); }

            /* Reset slot → Lunch default */
            document.querySelectorAll('#pm-slot-row .pm-slot-btn').forEach(b => {
                b.classList.remove('active-breakfast','active-snack','active-lunch','active-dinner');
                b.classList.add('btn-outline-secondary');
                if (b.dataset.slot === 'lunch') {
                    b.classList.remove('btn-outline-secondary');
                    b.classList.add('active-lunch');
                }
            });

            const timeInput = document.getElementById('pm-custom-time');
            if (timeInput) timeInput.value = '13:00';

            document.querySelectorAll('#pm-food-list .pm-food-item')
                .forEach(el => el.classList.remove('selected'));

            const preview = document.getElementById('pm-selected-preview');
            if (preview) preview.style.display = 'none';

            const saveBtn = document.getElementById('pm-save-btn');
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = '💾 Simpan Plan'; }

            loadPmFoods();
        }

        /* ── Edit Plan ── */
        if (e.target.id === 'modalEditPlan') {
            const btn = e.relatedTarget;
            if (!btn) return;
            const sub = document.getElementById('ep-subtitle');
            if (sub) sub.textContent = `${btn.dataset.day ?? ''}, ${btn.dataset.date ?? ''} · Plan`;
            const mn = document.getElementById('ep-meal-name');
            if (mn) mn.textContent = btn.dataset.mealName ?? '—';
            const mm = document.getElementById('ep-meal-macro');
            if (mm) mm.textContent = `${btn.dataset.kcal ?? '—'} kcal · ${btn.dataset.protein ?? '—'}g protein`;
            const tags = document.getElementById('ep-meal-tags');
            if (tags) {
                tags.innerHTML = '';
                if (btn.dataset.ktg1) tags.innerHTML += `<span class="text-white px-1 ${btn.dataset.ktg1class}">${btn.dataset.ktg1}</span>`;
                if (btn.dataset.ktg2) tags.innerHTML += `<span class="text-white px-1 ${btn.dataset.ktg2class}">${btn.dataset.ktg2}</span>`;
            }
            if (typeof epSwitchTabById === 'function') epSwitchTabById('details');
            const ra = document.getElementById('ep-replace-area');
            if (ra) ra.style.display = 'none';
        }
    });

    /* ══════════════════════════════════════════
       DELETE jadwal (untuk card yang sudah planned dari server)
    ══════════════════════════════════════════ */
    window.weekDeleteJadwal = async function (id, btn) {
        if (!confirm('Hapus rencana makan ini?')) return;
        btn.disabled = true;
        try {
            const res = await fetch(`/meal_plan/jadwal/${id}`, {
                method : 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, Accept: 'application/json' }
            });
            if (res.ok) {
                /* Kembalikan card ke tampilan unplanned tanpa reload */
                const col = btn.closest('[data-week-col]');
                if (!col) { location.reload(); return; }

                const date        = col.dataset.weekCol;
                const dateEl      = col.querySelector('.week-card-date');
                const dateDisplay = dateEl?.innerHTML ?? '';

                col.innerHTML = `
                    <div class="week-card">
                        <p class="week-card-date m-0">${dateDisplay}</p>
                        <div class="d-flex flex-column gap-2 mt-2">
                            <p class="week-no-plan-txt m-0">No meals planned yet.</p>
                            <button class="btn-plan-oren"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPlanManually"
                                data-date="${date}"
                                data-date-display="${dateDisplay.replace('<br>', ' ').replace(/<[^>]+>/g,'').trim()}"
                                data-date-day=""
                                data-label="${dateDisplay.replace('<br>', ', ').replace(/<[^>]+>/g,'').trim()}">
                                + Plan Manually
                            </button>
                        </div>
                    </div>`;
            } else {
                alert('Gagal menghapus jadwal.');
                btn.disabled = false;
            }
        } catch (e) {
            console.error('weekDeleteJadwal:', e);
            btn.disabled = false;
        }
    };

    /* ══════════════════════════════════════════
       Edit Plan helpers
    ══════════════════════════════════════════ */
    let epServ = 1;

    window.epSwitchTabById = function (tab) {
        ['details','reschedule','nutrition'].forEach(t => {
            const el = document.getElementById('ep-tab-' + t);
            if (el) el.style.display = t === tab ? 'block' : 'none';
        });
        document.querySelectorAll('#modalEditPlan .tab-btn-modal').forEach(b => {
            b.classList.toggle('active', (b.getAttribute('onclick') ?? '').includes(tab));
        });
    };

    function epToggleReplace() {
        const area = document.getElementById('ep-replace-area');
        if (area) area.style.display = area.style.display === 'none' ? 'block' : 'none';
    }
    function epToggleMeal(el) {
        el.closest('.meal-scroll-modal').querySelectorAll('.meal-result-row').forEach(r => r.classList.remove('selected'));
        el.classList.add('selected');
    }
    function epFilterMeals(q) {
        document.querySelectorAll('#ep-meal-list .meal-result-row').forEach(r => {
            const name = r.querySelector('.mrr-name')?.textContent.toLowerCase() ?? '';
            r.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }
    function epSwitchTab(btn, tab) {
        btn.closest('.tab-toggle-modal').querySelectorAll('.tab-btn-modal').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        epSwitchTabById(tab);
    }
    function epSelectDate(el) {
        el.closest('.date-row').querySelectorAll('.date-chip').forEach(d => d.classList.remove('active'));
        el.classList.add('active');
    }
    function epSelectSlot(el) {
        el.closest('.time-slots-modal').querySelectorAll('.time-slot-modal').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }
    function epChangeServ(d) {
        epServ = Math.max(1, epServ + d);
        const sv = document.getElementById('ep-serv-val');
        if (sv) sv.textContent = epServ;
    }
    function epDeletePlan() {
        if (!confirm('Yakin ingin menghapus plan ini?')) return;
        bootstrap.Modal.getInstance(document.getElementById('modalEditPlan'))?.hide();
        location.reload();
    }
    function epSavePlan() {
        bootstrap.Modal.getInstance(document.getElementById('modalEditPlan'))?.hide();
    }

    Object.assign(window, {
        epToggleReplace, epToggleMeal, epFilterMeals, epSwitchTab,
        epSelectDate, epSelectSlot, epChangeServ, epDeletePlan, epSavePlan,
    });

    /* ══════════════════════════════════════════
       BOOT
    ══════════════════════════════════════════ */
    loadWeekSidebar();
    loadWeekGrid();
    window.addEventListener('meal-added', loadWeekSidebar);
    window.pmOpenModal = function (btn) {
        pmTriggerBtn   = btn;
        pmSelectedDate = btn.dataset.date ?? null;
        pmSelectedId   = null;
        pmSelectedFood = null;
        pmServ         = 1;

        const sub = document.getElementById('pm-subtitle');
        if (sub) sub.textContent = `${btn.dataset.label ?? ''} · Tambahkan makanan ke rencana`;

        const sv = document.getElementById('pm-serv-val');
        if (sv) sv.textContent = '1';
        const search = document.getElementById('pm-search');
        if (search) { search.value = ''; pmFilterFoods(''); }

        document.querySelectorAll('#pm-slot-row .pm-slot-btn').forEach(b => {
            b.classList.remove('active-breakfast','active-snack','active-lunch','active-dinner');
            b.classList.add('btn-outline-secondary');
            if (b.dataset.slot === 'lunch') {
                b.classList.remove('btn-outline-secondary');
                b.classList.add('active-lunch');
            }
        });

        const timeInput = document.getElementById('pm-custom-time');
        if (timeInput) timeInput.value = '13:00';

        document.querySelectorAll('#pm-food-list .pm-food-item')
            .forEach(el => el.classList.remove('selected'));

        const preview = document.getElementById('pm-selected-preview');
        if (preview) preview.style.display = 'none';

        const saveBtn = document.getElementById('pm-save-btn');
        if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = '💾 Simpan Plan'; }

        loadPmFoods();

        const modalEl = document.getElementById('modalPlanManually');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (!modal) modal = new bootstrap.Modal(modalEl);
        modal.show();
    };
})();

</script>
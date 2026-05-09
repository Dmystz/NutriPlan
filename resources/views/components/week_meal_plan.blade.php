{{--
    resources/views/components/week_meal_plan.blade.php
    ────────────────────────────────────────────────────
    Week view for Meal Plan.
    • Left sidebar  → today's MealLog grouped by slot (from $groupedLogs / API)
    • Right grid    → 6 upcoming JadwalMakanan days (from $upcomingDays controller var)
    • Plan Manually / Edit Plan modals still included
    • Delete / mark-consumed via AJAX
--}}

<style>
    .week-card{border-radius:16px;border:.8px solid rgba(0,0,0,.08);background:rgba(252,252,252,.70);
        box-shadow:0 4px 16px 0 rgba(140,136,136,.18);backdrop-filter:blur(5px);
        min-height:11rem;display:flex;flex-direction:column;justify-content:space-between;
        padding:1rem;transition:box-shadow .2s ease;}
    .week-card:hover{box-shadow:0 6px 22px 0 rgba(140,136,136,.30);}
    .week-card-planned{border-radius:16px;border:.8px solid rgba(0,0,0,.08);background:rgba(255,255,255,.88);
        box-shadow:0 4px 16px 0 rgba(140,136,136,.18);backdrop-filter:blur(5px);
        min-height:11rem;display:flex;flex-direction:column;justify-content:space-between;
        padding:1rem;transition:box-shadow .2s ease;}
    .week-card-planned:hover{box-shadow:0 6px 22px 0 rgba(140,136,136,.30);}
    .badge-planned{font-size:.5rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;
        color:var(--warna-oren);background:rgba(234,92,43,.10);border-radius:6px;padding:2px 6px;}
    .week-card-date{font-size:.78rem;font-weight:700;color:#111827;line-height:1.3;}
    .week-no-plan-txt{font-size:.75rem;font-weight:500;color:#374151;}
    .btn-plan-oren{width:100%;background:var(--warna-oren);color:#fff;font-size:.78rem;font-weight:500;
        border:none;border-radius:50px;padding:.45rem 0;transition:background .2s ease;cursor:pointer;}
    .btn-plan-oren:hover{background:#cd4c22;}
    .btn-plan-ijo{width:100%;background:var(--warna-ijo);color:#fff;font-size:.78rem;font-weight:500;
        border:none;border-radius:50px;padding:.45rem 0;transition:background .2s ease;cursor:pointer;}
    .btn-plan-ijo:hover{background:#6e9c29;}
    .btn-edit-plan{width:100%;background:#F3F4F6;color:#374151;font-size:.72rem;font-weight:500;
        border:none;border-radius:50px;padding:.38rem 0;transition:background .2s ease;cursor:pointer;margin-top:.5rem;}
    .btn-edit-plan:hover{background:#E5E7EB;}
    .btn-delete-jadwal{background:rgba(255,80,60,.08);color:#DC2626;font-size:.68rem;font-weight:600;
        border:none;border-radius:50px;padding:.3rem .7rem;cursor:pointer;margin-top:.35rem;width:100%;
        transition:background .2s ease;}
    .btn-delete-jadwal:hover{background:rgba(255,80,60,.18);}
    .gambar-meal-week{width:64px;height:64px;border-radius:12px;object-fit:cover;flex-shrink:0;}
    .week-nutrition-row{border-top:.8px solid rgba(0,0,0,.08);padding-top:.5rem;margin-top:.5rem;
        display:flex;justify-content:space-between;}
    .wrapper-meal-week-sidebar{border-radius:16px;border:.8px solid rgba(0,0,0,.08);
        background:rgba(252,252,252,.70);box-shadow:0 4px 16px 0 rgba(140,136,136,.18);
        backdrop-filter:blur(5px);overflow-y:auto;max-height:72vh;}
    .wrapper-meal-week-sidebar::-webkit-scrollbar{display:none;}
    .week-section-title{font-size:1rem;font-weight:700;color:#111827;}
    .week-section-sub{font-size:.75rem;color:#6B7280;}

    /* Sidebar timeline mini */
    .sidebar-slot-label{font-size:.6rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
        color:#9CA3AF;margin-bottom:4px;}
    .sidebar-meal-row{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
    .sidebar-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .sidebar-meal-name{font-size:.75rem;font-weight:600;color:#111827;margin:0;line-height:1.3;}
    .sidebar-meal-macro{font-size:.67rem;color:#6B7280;margin:0;}
    .week-empty-sidebar{text-align:center;padding:24px 0;}
    .week-empty-sidebar p{font-size:.78rem;color:#9CA3AF;margin:0;}
</style>

<div class="row g-0 py-3">
    <div class="col-12">
        <div class="d-flex gap-3 flex-column flex-lg-row">

            {{-- ── LEFT: Today's sidebar (live from MealLog) ────── --}}
            <div class="flex-shrink-0" style="width:100%;max-width:310px;">
                <div class="wrapper-meal-week-sidebar p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0" style="font-size:.9rem;">Today's Meals</h6>
                        <span class="week-section-sub" id="week-sidebar-count">—</span>
                    </div>
                    <div id="week-sidebar-content">
                        {{-- Rendered by JS --}}
                        <div class="week-empty-sidebar">
                            <p>⏳ Memuat...</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: 6-day upcoming grid ─────────────────────── --}}
            <div class="flex-grow-1">
                <div class="row py-0 g-3" id="week-grid">

                    @php
                        /* $upcomingDays comes from MealPlanController::index() */
                        $upcomingDays = $upcomingDays ?? collect();
                    @endphp

                    @forelse ($upcomingDays->take(6) as $i => $day)
                        <div class="col-12 col-sm-6 col-xl-4">

                            @if ($day['is_planned'] && $day['meal'])
                                {{-- ══ PLANNED STATE ════════════════════════ --}}
                                <div class="week-card-planned">

                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <p class="week-card-date m-0">
                                            {{ $day['date']->format('M j') }}<br>
                                            {{ $day['date']->format('l') }}
                                        </p>
                                        <span class="badge-planned">Planned</span>
                                    </div>

                                    <div class="d-flex gap-2 align-items-start flex-grow-1">
                                        <img src="{{ asset('img/' . ($day['meal']['image'] ?? 'meal1_home.png')) }}"
                                            alt="{{ $day['meal']['name'] ?? 'Meal' }}" class="gambar-meal-week"
                                            onerror="this.src='{{ asset('img/meal1_home.png') }}'">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="name-meal fw-bold m-0 mb-1 p-0"
                                                style="font-size:.78rem;line-height:1.3;">
                                                {{ $day['meal']['name'] }}
                                            </h6>
                                            <p class="category-meal d-flex mb-0 gap-1 fw-bold flex-wrap">
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
                                        </div>
                                    </div>

                                    <div class="week-nutrition-row">
                                        <div class="d-flex align-items-center gap-1">
                                            <span style="font-size:.8rem;">🔥</span>
                                            <p class="font-size-s m-0">{{ $day['meal']['kcal'] ?? '0' }} kcal</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <span style="font-size:.8rem;">💪</span>
                                            <p class="font-size-s m-0">{{ $day['meal']['protein'] ?? '0' }}g protein</p>
                                        </div>
                                    </div>

                                    {{-- Edit + Delete --}}
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
                                        Edit Plan
                                    </button>

                                    @if ($day['jadwals']->isNotEmpty())
                                        <button class="btn-delete-jadwal mt-1"
                                            onclick="weekDeleteJadwal({{ $day['jadwals']->first()->id }}, this)">
                                            🗑 Hapus Plan
                                        </button>
                                    @endif

                                </div>

                            @else
                                {{-- ══ UNPLANNED STATE ══════════════════════ --}}
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
                                                data-num="{{ $day['date']->format('j') }}">
                                                Plan Manually
                                            </button>
                                        @else
                                            <button class="btn-plan-ijo"
                                                data-bs-toggle="modal" data-bs-target="#modalPlanManually"
                                                data-date="{{ $day['date']->format('Y-m-d') }}"
                                                data-day="{{ $day['date']->format('D') }}"
                                                data-num="{{ $day['date']->format('j') }}">
                                                Plan Manually
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

    @include('components.modal_plan_manually')
    @include('components.modal_edit_plan')
</div>

<script>
(function () {
    const CSRF   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const SLOTS  = ['Breakfast', 'Snack', 'Lunch', 'Dinner'];
    const COLORS = { Breakfast:'var(--warna-oren)', Snack:'#FE9A00', Lunch:'var(--warna-ijo)', Dinner:'#6366F1' };
    const ICONS  = { Breakfast:'☀️', Snack:'🍎', Lunch:'🥗', Dinner:'🌙' };
    const TIMES  = { Breakfast:'08:00', Snack:'10:30', Lunch:'13:00', Dinner:'19:30' };

    /* ── Sidebar: today's logs ──────────────────── */
    async function loadWeekSidebar() {
        const today   = new Date().toISOString().split('T')[0];
        const sidebar = document.getElementById('week-sidebar-content');
        const countEl = document.getElementById('week-sidebar-count');
        try {
            const res  = await fetch(`/api/meal-logs?date=${today}`, { headers:{ Accept:'application/json' } });
            const data = await res.json();
            const grouped = data.grouped || {};
            let html  = '';
            let total = 0;

            SLOTS.forEach(slot => {
                const items = grouped[slot] || [];
                if (!items.length) return;
                total += items.length;
                html += `<p class="sidebar-slot-label">${ICONS[slot]} ${slot}</p>`;
                items.forEach(log => {
                    html += `
                        <div class="sidebar-meal-row">
                            <div class="sidebar-dot" style="background:${COLORS[slot]};"></div>
                            <div>
                                <p class="sidebar-meal-name">${log.name}</p>
                                <p class="sidebar-meal-macro">
                                    ${Math.round(log.calories)} kcal &middot; ${log.meal_time ? log.meal_time.substring(0,5) : TIMES[slot]}
                                </p>
                            </div>
                        </div>`;
                });
            });

            if (total === 0) {
                html = `<div class="week-empty-sidebar"><p>Belum ada makanan hari ini.<br>
                            <span style="font-size:.7rem;color:#D1D5DB;">Tambahkan dari tab Days.</span></p></div>`;
            }
            sidebar.innerHTML = html;
            countEl.textContent = total + ' meal' + (total !== 1 ? 's' : '');

        } catch (e) {
            console.error('loadWeekSidebar:', e);
            sidebar.innerHTML = '<div class="week-empty-sidebar"><p>Gagal memuat data.</p></div>';
        }
    }

    /* ── Delete a jadwal ────────────────────────── */
    window.weekDeleteJadwal = async function (id, btn) {
        if (!confirm('Hapus rencana makan ini?')) return;
        btn.disabled = true;
        try {
            const res = await fetch(`/meal_plan/jadwal/${id}`, {
                method : 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, Accept:'application/json' }
            });
            if (res.ok) {
                /* Reload page to re-render Blade with fresh $upcomingDays */
                location.reload();
            } else {
                alert('Gagal menghapus jadwal.');
                btn.disabled = false;
            }
        } catch (e) {
            console.error('weekDeleteJadwal:', e);
            btn.disabled = false;
        }
    };

    /* ── Modal: Plan Manually ───────────────────── */
    let pmServ = 1;

    document.addEventListener('show.bs.modal', function (e) {
        if (e.target.id === 'modalPlanManually') {
            const btn  = e.relatedTarget;
            const date = btn?.dataset.date ?? '';
            const day  = btn?.dataset.day  ?? '';
            const num  = btn?.dataset.num  ?? '';

            document.querySelectorAll('#pm-date-row .date-chip').forEach(chip => {
                chip.classList.toggle('active', chip.dataset.date === date);
            });
            document.querySelectorAll('#modalPlanManually .time-slot-modal').forEach((s, i) => {
                s.classList.toggle('active', i === 2); // default Lunch
            });
            pmServ = 1;
            const sv = document.getElementById('pm-serv-val');
            if (sv) sv.textContent = '1';
            const ps = document.getElementById('pm-search');
            if (ps) { ps.value = ''; pmFilterMeals(''); }
        }

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
                if (btn.dataset.ktg1) tags.innerHTML += `<span class="text-white px-1 ${btn.dataset.ktg1class ?? 'ktg-ijo-home'}">${btn.dataset.ktg1}</span>`;
                if (btn.dataset.ktg2) tags.innerHTML += `<span class="text-white px-1 ${btn.dataset.ktg2class ?? 'ktg-oren-home'}">${btn.dataset.ktg2}</span>`;
            }
            if (typeof epSwitchTabById === 'function') epSwitchTabById('details');
            const ra = document.getElementById('ep-replace-area');
            if (ra) ra.style.display = 'none';
        }
    });

    function pmSelectDate(el) {
        el.closest('.date-row').querySelectorAll('.date-chip').forEach(d => d.classList.remove('active'));
        el.classList.add('active');
    }
    function pmSelectSlot(el) {
        el.closest('.time-slots-modal').querySelectorAll('.time-slot-modal').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }
    function pmChangeServ(d) {
        pmServ = Math.max(1, pmServ + d);
        const sv = document.getElementById('pm-serv-val');
        if (sv) sv.textContent = pmServ;
    }
    function pmFilterMeals(q) {
        document.querySelectorAll('#pm-meal-list .meal-result-row').forEach(r => {
            const name = r.querySelector('.mrr-name')?.textContent.toLowerCase() ?? '';
            r.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    async function pmSavePlan() {
        const selDate = document.querySelector('#pm-date-row .date-chip.active')?.dataset.date;
        const selSlot = document.querySelector('#modalPlanManually .time-slot-modal.active .ts-type')?.textContent;
        const selMeal = document.querySelector('#pm-meal-list .meal-result-row.selected');
        const custTime= document.getElementById('pm-custom-time')?.value;

        if (!selDate || !selMeal) {
            alert('Pilih tanggal dan resep terlebih dahulu.'); return;
        }

        const resepId = selMeal.dataset.id;
        const body = {
            katalog_resep_id : parseInt(resepId),
            tanggal          : selDate,
            meal_type        : (selSlot ?? 'lunch').toLowerCase(),
            meal_time        : custTime ?? null,
            servings         : pmServ,
        };

        try {
            const res = await fetch('/meal_plan/jadwal', {
                method : 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, Accept:'application/json' },
                body   : JSON.stringify(body),
            });
            if (res.ok) {
                bootstrap.Modal.getInstance(document.getElementById('modalPlanManually'))?.hide();
                location.reload();
            } else {
                const err = await res.json();
                alert('Gagal menyimpan: ' + (err.message ?? JSON.stringify(err)));
            }
        } catch (e) {
            console.error('pmSavePlan:', e);
        }
    }

    /* ── Edit Plan helpers ──────────────────────── */
    let epServ = 1;

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
    window.epSwitchTabById = function (tab) {
        ['details','reschedule','nutrition'].forEach(t => {
            const el = document.getElementById('ep-tab-' + t);
            if (el) el.style.display = t === tab ? 'block' : 'none';
        });
        document.querySelectorAll('#modalEditPlan .tab-btn-modal').forEach(b => {
            b.classList.toggle('active', (b.getAttribute('onclick') ?? '').includes(tab));
        });
    };
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

    /* Expose for inline onclick in modal blades */
    Object.assign(window, {
        pmSelectDate, pmSelectSlot, pmChangeServ, pmFilterMeals, pmSavePlan,
        epToggleReplace, epToggleMeal, epFilterMeals, epSwitchTab,
        epSelectDate, epSelectSlot, epChangeServ, epDeletePlan, epSavePlan,
    });

    /* ── Boot ───────────────────────────────────── */
    loadWeekSidebar();

    /* Refresh sidebar when a meal is added from the Days tab */
    window.addEventListener('meal-added', loadWeekSidebar);
})();
</script>
{{-- resources/views/components/modal_add_meal.blade.php --}}
{{-- Di-include dari days_meal_plan.blade.php --}}
{{-- Reads foods from /api/foods, writes logs to /api/meal-logs --}}

<div class="modal fade" id="modalAddMeal" tabindex="-1"
    aria-labelledby="modalAddMealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"
            style="border-radius:20px;border:.8px solid rgba(0,0,0,.08);overflow:hidden;">

            {{-- HEADER --}}
            <div class="modal-header"
                style="border-bottom:.8px solid rgba(0,0,0,.07);padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalAddMealLabel"
                        style="font-size:1rem;color:#111827;">Add Meal / Drinks / Snacks</h5>
                    <p class="m-0" style="font-size:.72rem;color:#6B7280;">{{ date('l, d F Y') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body" style="padding:18px 22px;">

                {{-- Category tabs --}}
                <div class="mb-3">
                    <div class="tab-toggle-modal" id="am-category-row">
                        <button type="button" class="tab-btn-modal active"
                            onclick="amSelectCategory(this,'meal')">🍽️ Meal</button>
                        <button type="button" class="tab-btn-modal"
                            onclick="amSelectCategory(this,'drink')">💧 Drinks</button>
                        <button type="button" class="tab-btn-modal"
                            onclick="amSelectCategory(this,'snack')">🍎 Snacks</button>
                    </div>
                </div>

                {{-- Time slot --}}
                <div class="mb-3">
                    <p style="font-size:.72rem;font-weight:700;color:#374151;margin-bottom:6px;">
                        Waktu Makan
                    </p>
                    <div class="time-slots-modal" id="am-slot-row">
                        <div class="time-slot-modal active" onclick="amSelectSlot(this)">
                            <span class="ts-type">Breakfast</span>
                            <span class="ts-time">08:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Snack</span>
                            <span class="ts-time">10:30</span>
                        </div>
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Lunch</span>
                            <span class="ts-time">13:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Dinner</span>
                            <span class="ts-time">19:30</span>
                        </div>
                    </div>
                </div>

                {{-- Search --}}
                <div class="mb-3">
                    <p style="font-size:.72rem;font-weight:700;color:#374151;margin-bottom:6px;">
                        Cari Item
                    </p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input class="np-input-search" id="am-search" type="text"
                            placeholder="Cari makanan, minuman, snack…"
                            oninput="amFilterItems(this.value)">
                    </div>
                    {{-- Quick chips --}}
                    <div class="d-flex flex-wrap gap-1 mt-2" id="am-suggestions">
                        <span class="am-chip" onclick="amQuickSelect(this)">🥗 Salad</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🍗 Ayam Bakar</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥤 Jus Jeruk</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🍌 Pisang</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥛 Susu</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥜 Kacang</span>
                    </div>
                </div>

                {{-- Result list --}}
                <div class="meal-scroll-modal" id="am-item-list"
                    style="min-height:80px;max-height:220px;overflow-y:auto;">

                    <div id="am-loading" class="text-center py-3" style="display:none;">
                        <div class="spinner-border spinner-border-sm text-secondary"
                            role="status"></div>
                        <span style="font-size:.75rem;color:#6B7280;margin-left:6px;">
                            Memuat...
                        </span>
                    </div>

                    <div id="am-empty" style="display:none;text-align:center;padding:20px 0;">
                        <p style="font-size:.78rem;color:#9CA3AF;">
                            Tidak ada hasil ditemukan.
                        </p>
                    </div>

                    {{-- Food rows injected here by amBuildRow() --}}
                </div>

                {{-- Manual input --}}
                <div class="mt-2">
                    <button type="button"
                        class="d-flex align-items-center gap-1 bg-transparent border-0 p-0"
                        style="font-size:.72rem;color:var(--warna-oren);font-weight:600;cursor:pointer;"
                        onclick="amToggleManual()">
                        + Input manual
                    </button>
                    <div id="am-manual-area" style="display:none;" class="mt-2">
                        <div class="row g-2">
                            <div class="col-12">
                                <input class="np-input-modal" id="am-manual-name" type="text"
                                    placeholder="Nama makanan / minuman">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" id="am-manual-kcal" type="number"
                                    placeholder="kcal" min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" id="am-manual-protein" type="number"
                                    placeholder="Protein (g)" min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" id="am-manual-carbs" type="number"
                                    placeholder="Carbs (g)" min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" id="am-manual-fat" type="number"
                                    placeholder="Fat (g)" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Porsi + Waktu --}}
                <div class="row g-2 mt-2 mb-3">
                    <div class="col-6">
                        <p style="font-size:.72rem;font-weight:700;color:#374151;margin-bottom:6px;">
                            Porsi
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <button class="serving-btn-modal" type="button"
                                onclick="amChangeServ(-1)">−</button>
                            <span class="fw-bold" id="am-serv-val"
                                style="min-width:20px;text-align:center;">1</span>
                            <button class="serving-btn-modal" type="button"
                                onclick="amChangeServ(1)">+</button>
                            <span style="font-size:.72rem;color:#6B7280;">porsi</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <p style="font-size:.72rem;font-weight:700;color:#374151;margin-bottom:6px;">
                            Waktu
                        </p>
                        <input class="np-input-modal" type="time" id="am-custom-time"
                            value="08:00">
                    </div>
                </div>

                {{-- Nutrition preview --}}
                <div class="nutri-preview-modal">
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-kcal"
                            style="color:var(--warna-oren);">0</span>
                        <span class="np-stat-label">kcal</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-protein">0g</span>
                        <span class="np-stat-label">protein</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-carbs">0g</span>
                        <span class="np-stat-label">carbs</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-fat">0g</span>
                        <span class="np-stat-label">fat</span>
                    </div>
                </div>

            </div>{{-- /modal-body --}}

            {{-- FOOTER --}}
            <div class="modal-footer"
                style="border-top:.8px solid rgba(0,0,0,.07);padding:12px 22px 16px;gap:8px;">
                <button type="button" class="btn-cancel-modal"
                    data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-oren" id="am-save-btn"
                    onclick="amSave()">
                    Tambahkan →
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Toast (outside modal so it isn't clipped by backdrop) --}}
<div id="am-toast"
    style="display:none;position:fixed;bottom:28px;left:50%;transform:translateX(-50%);
           background:#111827;color:#fff;padding:10px 22px;border-radius:50px;
           font-size:.78rem;z-index:99999;white-space:nowrap;
           box-shadow:0 4px 20px rgba(0,0,0,.25);transition:opacity .3s;"></div>

<script>
/* ════════════════════════════════════════════════════════════
   modal_add_meal.blade.php — JavaScript
   All state is scoped to avoid conflicts with week_meal_plan.js
   ════════════════════════════════════════════════════════════ */
(function () {

    /* ── STATE ──────────────────────────────────────────── */
    let amCategory    = 'meal';
    let amServing     = 1;
    let amSelected    = null;   // { id, name, calories, protein, carbs, fat }
    let amSearchTimer = null;

    const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ── 1. FETCH FOODS FROM /api/foods ─────────────────── */
    async function amFetchItems(category = 'meal', search = '') {
        const list    = document.getElementById('am-item-list');
        const loading = document.getElementById('am-loading');
        const empty   = document.getElementById('am-empty');

        loading.style.display = 'block';
        empty.style.display   = 'none';
        list.querySelectorAll('.meal-result-row').forEach(el => el.remove());

        let url = `/api/foods?category=${encodeURIComponent(category)}`;
        if (search.trim()) url += `&search=${encodeURIComponent(search.trim())}`;

        try {
            const res   = await fetch(url, { headers: { Accept: 'application/json' } });
            const foods = await res.json();
            loading.style.display = 'none';

            if (!Array.isArray(foods) || !foods.length) {
                empty.style.display = 'block';
                return;
            }

            foods.forEach(food => list.insertBefore(amBuildRow(food), empty));

        } catch (e) {
            loading.style.display = 'none';
            empty.style.display   = 'block';
            console.error('amFetchItems:', e);
        }
    }

    /* ── 2. BUILD ONE FOOD ROW ──────────────────────────── */
    function amBuildRow(food) {
        const row = document.createElement('div');
        row.className       = 'meal-result-row';
        row.dataset.id      = food.id;
        row.dataset.kcal    = food.calories;
        row.dataset.protein = food.protein;
        row.dataset.carbs   = food.carbs;
        row.dataset.fat     = food.fat;
        row.onclick = () => amToggleItem(row, food);

        /* Image or emoji fallback */
        const imgWrap = document.createElement('div');
        imgWrap.className = 'mrr-img';
        if (food.image_url) {
            const img = document.createElement('img');
            img.src   = food.image_url;
            img.alt   = food.name;
            img.style.cssText =
                'width:38px;height:38px;border-radius:10px;object-fit:cover;';
            img.onerror = () => {
                imgWrap.innerHTML    = '';
                imgWrap.textContent  = food.emoji || '🍽️';
                imgWrap.style.cssText=
                    'font-size:1.4rem;display:flex;align-items:center;justify-content:center;width:38px;height:38px;';
            };
            imgWrap.appendChild(img);
        } else {
            imgWrap.textContent  = food.emoji || '🍽️';
            imgWrap.style.cssText=
                'font-size:1.4rem;display:flex;align-items:center;justify-content:center;width:38px;height:38px;';
        }

        const info = document.createElement('div');
        info.className = 'flex-grow-1';
        info.innerHTML = `
            <p class="mrr-name">${food.name}</p>
            <p class="mrr-macro">
                ${food.calories} kcal &middot; ${food.protein}g protein
                ${food.description ? ' &middot; <span style="color:#9CA3AF;">' + food.description + '</span>' : ''}
            </p>`;

        const check = document.createElement('div');
        check.className   = 'mrr-check';
        check.textContent = '✓';

        row.appendChild(imgWrap);
        row.appendChild(info);
        row.appendChild(check);
        return row;
    }

    /* ── 3. TOGGLE SELECT ───────────────────────────────── */
    function amToggleItem(row, food) {
        const all = document.querySelectorAll('#am-item-list .meal-result-row');
        if (row.classList.contains('selected')) {
            row.classList.remove('selected');
            amSelected = null;
            amUpdatePreview(0, 0, 0, 0);
        } else {
            all.forEach(r => r.classList.remove('selected'));
            row.classList.add('selected');
            amSelected = {
                id      : food.id,
                name    : food.name,
                calories: parseFloat(food.calories) || 0,
                protein : parseFloat(food.protein)  || 0,
                carbs   : parseFloat(food.carbs)    || 0,
                fat     : parseFloat(food.fat)      || 0,
            };
            amUpdatePreview(
                amSelected.calories, amSelected.protein,
                amSelected.carbs,    amSelected.fat
            );
        }
    }

    /* ── 4. SEARCH DEBOUNCE ─────────────────────────────── */
    function amFilterItems(val) {
        clearTimeout(amSearchTimer);
        amSearchTimer = setTimeout(() => amFetchItems(amCategory, val), 350);
    }

    /* ── 5. CATEGORY TABS ───────────────────────────────── */
    function amSelectCategory(btn, cat) {
        document.querySelectorAll('#am-category-row .tab-btn-modal')
            .forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        amCategory = cat;
        amSelected = null;
        document.getElementById('am-search').value = '';
        amUpdatePreview(0, 0, 0, 0);
        amFetchItems(cat);
    }

    /* ── 6. TIME SLOT ───────────────────────────────────── */
    function amSelectSlot(el) {
        document.querySelectorAll('#am-slot-row .time-slot-modal')
            .forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        const time = el.querySelector('.ts-time')?.textContent;
        if (time) document.getElementById('am-custom-time').value = time;
    }

    /* ── 7. QUICK CHIP ──────────────────────────────────── */
    function amQuickSelect(chip) {
        const text = chip.textContent.replace(/^\S+\s/, '').trim();
        document.getElementById('am-search').value = text;
        amFetchItems(amCategory, text);
    }

    /* ── 8. SERVINGS +/- ────────────────────────────────── */
    function amChangeServ(delta) {
        amServing = Math.max(1, Math.min(20, amServing + delta));
        document.getElementById('am-serv-val').textContent = amServing;
        if (amSelected) {
            amUpdatePreview(
                amSelected.calories, amSelected.protein,
                amSelected.carbs,    amSelected.fat
            );
        }
    }

    /* ── 9. NUTRITION PREVIEW ───────────────────────────── */
    function amUpdatePreview(kcal, prot, carb, fat) {
        const s = amServing;
        document.getElementById('am-kcal').textContent    = Math.round(kcal * s);
        document.getElementById('am-protein').textContent = (prot * s).toFixed(1) + 'g';
        document.getElementById('am-carbs').textContent   = (carb * s).toFixed(1) + 'g';
        document.getElementById('am-fat').textContent     = (fat  * s).toFixed(1) + 'g';
    }

    /* ── 10. MANUAL INPUT TOGGLE ────────────────────────── */
    function amToggleManual() {
        const area = document.getElementById('am-manual-area');
        area.style.display =
            (area.style.display === 'none' || !area.style.display) ? 'block' : 'none';
    }

    /* ── 11. TOAST ──────────────────────────────────────── */
    function amShowToast(msg, ms = 2800) {
        const t      = document.getElementById('am-toast');
        t.textContent   = msg;
        t.style.display = 'block';
        t.style.opacity = '1';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => { t.style.display = 'none'; t.style.opacity = '1'; }, 350);
        }, ms);
    }

    /* ── 12. SAVE → POST /api/meal-logs ─────────────────── */
    async function amSave() {
        const saveBtn    = document.getElementById('am-save-btn');
        const manualArea = document.getElementById('am-manual-area');
        const isManual   = manualArea.style.display === 'block';
        let payload;

        if (isManual) {
            const name = document.getElementById('am-manual-name').value.trim();
            if (!name) { amShowToast('⚠️ Isi nama makanan terlebih dahulu.'); return; }
            payload = {
                name    : name,
                calories: parseFloat(document.getElementById('am-manual-kcal').value)    || 0,
                protein : parseFloat(document.getElementById('am-manual-protein').value)  || 0,
                carbs   : parseFloat(document.getElementById('am-manual-carbs').value)    || 0,
                fat     : parseFloat(document.getElementById('am-manual-fat').value)      || 0,
            };
        } else if (amSelected) {
            payload = {
                food_id  : amSelected.id,
                name     : amSelected.name,
                calories : amSelected.calories * amServing,
                protein  : amSelected.protein  * amServing,
                carbs    : amSelected.carbs    * amServing,
                fat      : amSelected.fat      * amServing,
            };
        } else {
            amShowToast('⚠️ Pilih makanan atau gunakan input manual.');
            return;
        }

        const activeSlot      = document.querySelector('#am-slot-row .time-slot-modal.active');
        payload.meal_time     = document.getElementById('am-custom-time').value;
        payload.meal_slot     = activeSlot?.querySelector('.ts-type')?.textContent ?? 'Breakfast';
        payload.category      = amCategory;
        payload.servings      = amServing;

        saveBtn.disabled      = true;
        saveBtn.textContent   = 'Menyimpan...';

        try {
            const res  = await fetch('/api/meal-logs', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF(),
                    'Accept'      : 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (res.ok) {
                /* Close modal */
                bootstrap.Modal.getInstance(
                    document.getElementById('modalAddMeal')
                )?.hide();

                /* Broadcast so days_meal_plan.js can update timeline + nutrition panel */
                window.dispatchEvent(
                    new CustomEvent('meal-added', { detail: data })
                );

                amShowToast('✅ ' + payload.name + ' berhasil ditambahkan!');
            } else {
                const msg = data.message
                    ?? (data.errors
                        ? Object.values(data.errors).flat().join(', ')
                        : JSON.stringify(data));
                amShowToast('❌ Gagal: ' + msg);
            }

        } catch (e) {
            console.error('amSave:', e);
            amShowToast('❌ Terjadi kesalahan koneksi.');
        } finally {
            saveBtn.disabled    = false;
            saveBtn.textContent = 'Tambahkan →';
        }
    }

    /* ── 13. INIT ON MODAL OPEN ─────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('modalAddMeal');
        if (!modalEl) return;

        modalEl.addEventListener('show.bs.modal', () => {
            /* Reset state */
            amCategory = 'meal';
            amServing  = 1;
            amSelected = null;
            /* Reset UI */
            document.getElementById('am-serv-val').textContent       = '1';
            document.getElementById('am-search').value               = '';
            document.getElementById('am-custom-time').value          = '08:00';
            document.getElementById('am-manual-area').style.display  = 'none';
            document.getElementById('am-manual-name').value          = '';
            document.getElementById('am-manual-kcal').value          = '';
            document.getElementById('am-manual-protein').value       = '';
            document.getElementById('am-manual-carbs').value         = '';
            document.getElementById('am-manual-fat').value           = '';
            /* Reset tabs & slots */
            document.querySelectorAll('#am-category-row .tab-btn-modal')
                .forEach((b, i) => b.classList.toggle('active', i === 0));
            document.querySelectorAll('#am-slot-row .time-slot-modal')
                .forEach((s, i) => s.classList.toggle('active', i === 0));
            /* Reset preview */
            amUpdatePreview(0, 0, 0, 0);
            /* Load data */
            amFetchItems('meal');
        });
    });

    /* Expose functions called from inline onclick attributes in the template */
    Object.assign(window, {
        amSelectCategory,
        amSelectSlot,
        amQuickSelect,
        amFilterItems,
        amChangeServ,
        amToggleManual,
        amSave,
    });

})();
</script>
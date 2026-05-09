{{-- resources/views/components/modal_add_meal.blade.php --}}
{{-- Data diambil dari /api/foods via fetch, gambar dari storage --}}

<div class="modal fade" id="modalAddMeal" tabindex="-1" aria-labelledby="modalAddMealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            {{-- ── HEADER ── --}}
            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalAddMealLabel"
                        style="font-size:1rem; color:#111827;">
                        Add Meal / Drinks / Snacks
                    </h5>
                    <p class="m-0" style="font-size:0.72rem; color:#6B7280;">
                        {{ date('l, d F Y') }}
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- ── BODY ── --}}
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
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Waktu Makan</p>
                    <div class="time-slots-modal" id="am-slot-row">
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Breakfast</span><span class="ts-time">08:00</span>
                        </div>
                        <div class="time-slot-modal active" onclick="amSelectSlot(this)">
                            <span class="ts-type">Snack</span><span class="ts-time">10:30</span>
                        </div>
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Lunch</span><span class="ts-time">13:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Dinner</span><span class="ts-time">19:30</span>
                        </div>
                    </div>
                </div>

                {{-- Search --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Cari Item</p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" />
                        </svg>
                        <input class="np-input-search" id="am-search" type="text"
                            placeholder="Cari makanan, minuman, snack…"
                            oninput="amFilterItems(this.value)">
                    </div>

                    {{-- Quick suggestion chips --}}
                    <div class="d-flex flex-wrap gap-1 mt-2" id="am-suggestions">
                        <span class="am-chip" onclick="amQuickSelect(this)">🥗 Salad</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🍗 Ayam Bakar</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥤 Jus Jeruk</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🍌 Pisang</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥛 Susu</span>
                        <span class="am-chip" onclick="amQuickSelect(this)">🥜 Kacang</span>
                    </div>
                </div>

                {{-- ── Result list (diisi oleh JS) ── --}}
                <div class="meal-scroll-modal" id="am-item-list">
                    {{-- Loading state --}}
                    <div id="am-loading" class="text-center py-3" style="display:none;">
                        <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                        <span style="font-size:0.75rem; color:#6B7280; margin-left:6px;">Memuat...</span>
                    </div>
                    {{-- Empty state --}}
                    <div id="am-empty" style="display:none; text-align:center; padding:20px 0;">
                        <p style="font-size:0.78rem; color:#9CA3AF;">Tidak ada hasil ditemukan.</p>
                    </div>
                </div>

                {{-- Manual input toggle --}}
                <div class="mt-2">
                    <button type="button" class="d-flex align-items-center gap-1 bg-transparent border-0 p-0"
                        style="font-size:0.72rem; color:var(--warna-oren); font-weight:600; cursor:pointer;"
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
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Porsi</p>
                        <div class="d-flex align-items-center gap-2">
                            <button class="serving-btn-modal" type="button" onclick="amChangeServ(-1)">−</button>
                            <span class="fw-bold" id="am-serv-val"
                                style="min-width:20px; text-align:center;">1</span>
                            <button class="serving-btn-modal" type="button" onclick="amChangeServ(1)">+</button>
                            <span style="font-size:0.72rem; color:#6B7280;">porsi</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Waktu</p>
                        <input class="np-input-modal" type="time" id="am-custom-time" value="10:30">
                    </div>
                </div>

                {{-- Nutrition preview --}}
                <div class="nutri-preview-modal">
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-kcal" style="color:var(--warna-oren);">0</span>
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

            </div><!-- /modal-body -->

            {{-- ── FOOTER ── --}}
            <div class="modal-footer"
                style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-oren" onclick="amSave()">Tambahkan →</button>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     JavaScript – semua logika modal ada di sini
     ══════════════════════════════════════════════════════════════ --}}
<script>
/* ── State ─────────────────────────────────────────────────────── */
let amCategory    = 'meal';
let amServing     = 1;
let amSelected    = null;   // objek food yang dipilih dari list
let amSearchTimer = null;

/* ── 1. Ambil data dari API dengan debounce ─────────────────────── */
async function amFetchItems(category = 'meal', search = '') {
    const list    = document.getElementById('am-item-list');
    const loading = document.getElementById('am-loading');
    const empty   = document.getElementById('am-empty');

    // Tampilkan loading, sembunyikan baris lama
    loading.style.display = 'block';
    empty.style.display   = 'none';
    // Hapus baris item lama (tapi jaga loading & empty)
    list.querySelectorAll('.meal-result-row').forEach(el => el.remove());

    let url = `/api/foods?category=${category}`;
    if (search.trim()) url += `&search=${encodeURIComponent(search.trim())}`;

    try {
        const res   = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const foods = await res.json();

        loading.style.display = 'none';

        if (!foods.length) {
            empty.style.display = 'block';
            return;
        }

        foods.forEach(food => {
            const row = amBuildRow(food);
            list.insertBefore(row, empty);   // selalu sebelum #am-empty
        });

    } catch (e) {
        loading.style.display = 'none';
        empty.style.display   = 'block';
        console.error('FoodFetch error:', e);
    }
}

/* ── 2. Render satu baris item ──────────────────────────────────── */
function amBuildRow(food) {
    const row = document.createElement('div');
    row.className    = 'meal-result-row';
    row.dataset.id       = food.id;
    row.dataset.kcal     = food.calories;
    row.dataset.protein  = food.protein;
    row.dataset.carbs    = food.carbs;
    row.dataset.fat      = food.fat;
    row.onclick = () => amToggleItem(row, food);

    /* ── Gambar: pakai <img> jika ada image_url, fallback ke emoji ── */
    const imgWrap = document.createElement('div');
    imgWrap.className = 'mrr-img';

    if (food.image_url) {
        const img = document.createElement('img');
        img.src    = food.image_url;
        img.alt    = food.name;
        img.style.cssText = 'width:38px;height:38px;border-radius:10px;object-fit:cover;';
        /* Jika gambar gagal dimuat, fallback ke emoji */
        img.onerror = () => { imgWrap.textContent = food.emoji || '🍽️'; };
        imgWrap.appendChild(img);
    } else {
        imgWrap.textContent = food.emoji || '🍽️';
    }

    const info = document.createElement('div');
    info.className = 'flex-grow-1';
    info.innerHTML = `
        <p class="mrr-name">${food.name}</p>
        <p class="mrr-macro">${food.calories} kcal · ${food.protein}g protein · ${food.description ?? ''}</p>
    `;

    const check = document.createElement('div');
    check.className = 'mrr-check';
    check.textContent = '✓';

    row.appendChild(imgWrap);
    row.appendChild(info);
    row.appendChild(check);
    return row;
}

/* ── 3. Toggle pilih item ────────────────────────────────────────── */
function amToggleItem(row, food) {
    const allRows = document.querySelectorAll('#am-item-list .meal-result-row');

    if (row.classList.contains('selected')) {
        // Deselect
        row.classList.remove('selected');
        amSelected = null;
        amUpdatePreview(0, 0, 0, 0);
    } else {
        allRows.forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');
        amSelected = food ?? {
            calories : +row.dataset.kcal,
            protein  : +row.dataset.protein,
            carbs    : +row.dataset.carbs,
            fat      : +row.dataset.fat,
        };
        amUpdatePreview(
            amSelected.calories,
            amSelected.protein,
            amSelected.carbs,
            amSelected.fat
        );
    }
}

/* ── 4. Filter / search ─────────────────────────────────────────── */
function amFilterItems(val) {
    clearTimeout(amSearchTimer);
    amSearchTimer = setTimeout(() => amFetchItems(amCategory, val), 350);
}

/* ── 5. Pilih kategori ──────────────────────────────────────────── */
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

/* ── 6. Pilih time slot ─────────────────────────────────────────── */
function amSelectSlot(el) {
    document.querySelectorAll('#am-slot-row .time-slot-modal')
        .forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    const time = el.querySelector('.ts-time')?.textContent;
    if (time) document.getElementById('am-custom-time').value = time;
}

/* ── 7. Quick chip ──────────────────────────────────────────────── */
function amQuickSelect(chip) {
    const text = chip.textContent.replace(/^\S+\s/, '').trim();  // hapus emoji
    document.getElementById('am-search').value = text;
    amFetchItems(amCategory, text);
}

/* ── 8. Porsi ───────────────────────────────────────────────────── */
function amChangeServ(delta) {
    amServing = Math.max(1, Math.min(10, amServing + delta));
    document.getElementById('am-serv-val').textContent = amServing;
    if (amSelected) {
        amUpdatePreview(
            amSelected.calories,
            amSelected.protein,
            amSelected.carbs,
            amSelected.fat
        );
    }
}

/* ── 9. Update preview nutrisi (dikalikan porsi) ────────────────── */
function amUpdatePreview(kcal, prot, carb, fat) {
    const s = amServing;
    document.getElementById('am-kcal').textContent    = Math.round(kcal * s);
    document.getElementById('am-protein').textContent = (prot * s).toFixed(1) + 'g';
    document.getElementById('am-carbs').textContent   = (carb * s).toFixed(1) + 'g';
    document.getElementById('am-fat').textContent     = (fat  * s).toFixed(1) + 'g';
}

/* ── 10. Manual input toggle ────────────────────────────────────── */
function amToggleManual() {
    const area = document.getElementById('am-manual-area');
    area.style.display = area.style.display === 'none' ? 'block' : 'none';
}

/* ── 11. Simpan (kirim ke backend) ──────────────────────────────── */
async function amSave() {
    let payload;
    const manualArea = document.getElementById('am-manual-area');
    const isManual   = manualArea.style.display !== 'none';

    if (isManual) {
        const name = document.getElementById('am-manual-name').value;
        if (!name) return alert('Isi nama makanan terlebih dahulu.');
        payload = {
            name    : name,
            calories: +document.getElementById('am-manual-kcal').value    || 0,
            protein : +document.getElementById('am-manual-protein').value  || 0,
            carbs   : +document.getElementById('am-manual-carbs').value    || 0,
            fat     : +document.getElementById('am-manual-fat').value      || 0,
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
        return alert('Pilih makanan terlebih dahulu.');
    }

    const activeSlot = document.querySelector('#am-slot-row .time-slot-modal.active');
    payload.meal_time = document.getElementById('am-custom-time').value;
    payload.meal_slot = activeSlot?.querySelector('.ts-type')?.textContent ?? '';
    payload.category  = amCategory;
    payload.servings  = amServing;

    try {
        const res = await fetch('/api/meal-logs', {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'Accept'      : 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (res.ok) {
            bootstrap.Modal.getInstance(
                document.getElementById('modalAddMeal')
            ).hide();
            window.dispatchEvent(new CustomEvent('meal-added', { detail: payload }));
            alert('Berhasil ditambahkan! ✅');
        } else {
            const err = await res.json();
            alert('Gagal: ' + (err.message ?? JSON.stringify(err)));
        }
    } catch (e) {
        console.error(e);
        alert('Terjadi kesalahan koneksi.');
    }
}

/* ── 12. Init saat modal dibuka ─────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('modalAddMeal');
    if (!modalEl) return;

    modalEl.addEventListener('show.bs.modal', () => {
        amCategory = 'meal';
        amServing  = 1;
        amSelected = null;
        document.getElementById('am-serv-val').textContent = '1';
        document.getElementById('am-search').value = '';
        amUpdatePreview(0, 0, 0, 0);
        // Reset kategori tab ke Meal
        document.querySelectorAll('#am-category-row .tab-btn-modal')
            .forEach((b, i) => b.classList.toggle('active', i === 0));
        // Load data awal
        amFetchItems('meal');
    });
});
</script>
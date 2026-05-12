<div class="modal fade" id="modalAdjustPlan" tabindex="-1" aria-labelledby="modalAdjustPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalAdjustPlanLabel"
                        style="font-size:1rem; color:#111827;">Adjust Meal Plan</h5>
                    <p class="m-0" style="font-size:0.72rem; color:#6B7280;">Sesuaikan target dan preferensi nutrisi harian</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding:18px 22px;">

                {{-- Feedback --}}
                <div id="adj-feedback" style="display:none; font-size:0.78rem; text-align:center; margin-bottom:10px;"></div>

                {{-- Calorie target --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin:0;">Target Kalori Harian</p>
                        <span style="font-size:0.78rem; font-weight:700; color:#ea5c2b;" id="adj-kcal-val">2200 kcal</span>
                    </div>
                    <input type="range" class="adj-slider" id="adj-kcal-slider"
                        min="1200" max="3500" step="50" value="2200"
                        oninput="adjUpdateKcal(this.value)">
                    <div class="d-flex justify-content-between mt-1">
                        <span style="font-size:0.6rem; color:#9CA3AF;">1200 kcal</span>
                        <span style="font-size:0.6rem; color:#9CA3AF;">3500 kcal</span>
                    </div>
                </div>

                {{-- Macro split --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Komposisi Makro</p>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.72rem; color:#374151;">Protein</span>
                            <span style="font-size:0.72rem; font-weight:700; color:#FB2C36;" id="adj-protein-pct">25%</span>
                        </div>
                        <input type="range" class="adj-slider adj-slider-protein" min="10" max="50"
                            step="5" value="25" oninput="adjUpdateMacro('protein', this.value)">
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.72rem; color:#374151;">Carbs</span>
                            <span style="font-size:0.72rem; font-weight:700; color:#FE9A00;" id="adj-carbs-pct">45%</span>
                        </div>
                        <input type="range" class="adj-slider adj-slider-carbs" min="10" max="70"
                            step="5" value="45" oninput="adjUpdateMacro('carbs', this.value)">
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.72rem; color:#374151;">Fat</span>
                            <span style="font-size:0.72rem; font-weight:700; color:#95CD41;" id="adj-fat-pct">30%</span>
                        </div>
                        <input type="range" class="adj-slider adj-slider-fat" min="10" max="60"
                            step="5" value="30" oninput="adjUpdateMacro('fat', this.value)">
                    </div>

                    {{-- Warning total != 100% --}}
                    <div id="adj-macro-warning" style="display:none; font-size:0.68rem; color:#DC2626; margin-bottom:6px;">
                        ⚠ Total makro harus 100%. Sekarang: <span id="adj-macro-total">100</span>%
                    </div>

                    {{-- Visual bar --}}
                    <div style="display:flex; height:8px; border-radius:50px; overflow:hidden; gap:2px;" id="adj-macro-bar">
                        <div style="width:25%; background:#FB2C36; border-radius:50px 0 0 50px;" id="adj-bar-protein"></div>
                        <div style="width:45%; background:#FE9A00;" id="adj-bar-carbs"></div>
                        <div style="width:30%; background:#95CD41; border-radius:0 50px 50px 0;" id="adj-bar-fat"></div>
                    </div>
                </div>

                {{-- Dietary preference --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Preferensi Diet</p>
                    <div class="d-flex flex-wrap gap-2" id="adj-diet-chips">
                        <span class="adj-pref-chip active" data-value="balanced"       onclick="adjTogglePref(this)">Balanced</span>
                        <span class="adj-pref-chip"        data-value="high_protein"   onclick="adjTogglePref(this)">High Protein</span>
                        <span class="adj-pref-chip"        data-value="keto"           onclick="adjTogglePref(this)">Keto</span>
                        <span class="adj-pref-chip"        data-value="vegan"          onclick="adjTogglePref(this)">Vegan</span>
                        <span class="adj-pref-chip"        data-value="low_carb"       onclick="adjTogglePref(this)">Low Carb</span>
                        <span class="adj-pref-chip"        data-value="mediterranean"  onclick="adjTogglePref(this)">Mediterranean</span>
                    </div>
                </div>

                {{-- Meals per day --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Jumlah Makan per Hari</p>
                    <div class="d-flex gap-2" id="adj-meals-per-day">
                        @foreach ([2, 3, 4, 5, 6] as $n)
                            <div class="adj-num-chip {{ $n === 5 ? 'active' : '' }}"
                                data-value="{{ $n }}"
                                onclick="adjSelectMeals(this)">{{ $n }}x</div>
                        @endforeach
                    </div>
                </div>

                {{-- Allergy / avoid --}}
                <div class="mb-1">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Hindari / Alergi</p>
                    <div class="np-search-wrap" style="position:relative;">
                        <svg style="position:absolute; left:10px; top:50%; transform:translateY(-50%);"
                            xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input id="adj-avoid-input" class="np-input-search" type="text"
                            placeholder="e.g. gluten, dairy, nuts… lalu Enter"
                            style="padding-left:32px; width:100%;"
                            onkeydown="adjAddAvoid(event)">
                    </div>
                    <div class="d-flex flex-wrap gap-1 mt-2" id="adj-avoid-list"></div>
                </div>

            </div>

            <div class="modal-footer" style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-ijo" id="adj-save-btn" onclick="adjSave()">Terapkan →</button>
            </div>

        </div>
    </div>
</div>

<style>
.adj-slider {
    width: 100%;
    -webkit-appearance: none;
    height: 5px;
    border-radius: 50px;
    background: #E5E7EB;
    outline: none;
}
.adj-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #ea5c2b;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
.adj-pref-chip {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
    border: 1.5px solid #E5E7EB;
    background: #F9FAFB;
    color: #6B7280;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
}
.adj-pref-chip.active {
    border-color: #95cd41;
    background: rgba(149,205,65,0.1);
    color: #3a6b00;
}
.adj-num-chip {
    font-size: 0.78rem;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 10px;
    border: 1.5px solid #E5E7EB;
    background: #F9FAFB;
    color: #6B7280;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
}
.adj-num-chip.active {
    border-color: #ea5c2b;
    background: rgba(234,92,43,0.08);
    color: #ea5c2b;
}
.adj-avoid-chip {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 50px;
    background: rgba(254,226,226,0.7);
    color: #991B1B;
    border: 1px solid rgba(220,38,38,0.2);
}
.np-input-search {
    width: 100%;
    border-radius: 10px;
    border: 1.5px solid #E5E7EB;
    background: #F9FAFB;
    padding: 0.4rem 0.75rem;
    font-size: 0.85rem;
    color: #374151;
    outline: none;
}
.np-input-search:focus { border-color: #95cd41; }
.btn-cancel-modal {
    background: #F3F4F6; border: none; border-radius: 50px;
    padding: 0.5rem 1.2rem; font-size: 0.85rem; font-weight: 600;
    color: #6B7280; cursor: pointer;
}
.btn-save-modal-ijo {
    background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
    border: none; border-radius: 50px;
    padding: 0.5rem 1.4rem; font-size: 0.85rem; font-weight: 700;
    color: #fff; cursor: pointer;
    box-shadow: 0 4px 12px rgba(149,205,65,0.3);
}
.btn-save-modal-ijo:disabled { opacity: 0.6; cursor: not-allowed; }
</style>

<script>
const ADJ_PREF_ROUTE = '{{ route("meal_plan.pref.save") }}'.replace('http://', 'https://');
const ADJ_GET_ROUTE  = '{{ route("meal_plan.pref.get") }}'.replace('http://', 'https://');
const ADJ_CSRF       = '{{ csrf_token() }}';

// ── State lokal modal ─────────────────────────────────────────────
let adjAvoidItems = [];

// ── Kalori ────────────────────────────────────────────────────────
function adjUpdateKcal(val) {
    document.getElementById('adj-kcal-val').textContent = val + ' kcal';
}

// ── Makro ─────────────────────────────────────────────────────────
function adjUpdateMacro(type, val) {
    document.getElementById('adj-' + type + '-pct').textContent = val + '%';
    adjRefreshBar();
}

function adjRefreshBar() {
    const p = parseInt(document.querySelector('.adj-slider-protein').value);
    const c = parseInt(document.querySelector('.adj-slider-carbs').value);
    const f = parseInt(document.querySelector('.adj-slider-fat').value);
    const total = p + c + f;

    document.getElementById('adj-bar-protein').style.width = p + '%';
    document.getElementById('adj-bar-carbs').style.width   = c + '%';
    document.getElementById('adj-bar-fat').style.width     = f + '%';

    const warning = document.getElementById('adj-macro-warning');
    const totalEl = document.getElementById('adj-macro-total');
    totalEl.textContent = total;

    if (total !== 100) {
        warning.style.display = 'block';
        document.getElementById('adj-save-btn').disabled = true;
    } else {
        warning.style.display = 'none';
        document.getElementById('adj-save-btn').disabled = false;
    }
}

// ── Diet preference ───────────────────────────────────────────────
function adjTogglePref(el) {
    document.querySelectorAll('#adj-diet-chips .adj-pref-chip')
        .forEach(function(c) { c.classList.remove('active'); });
    el.classList.add('active');
}

// ── Meals per day ─────────────────────────────────────────────────
function adjSelectMeals(el) {
    document.querySelectorAll('#adj-meals-per-day .adj-num-chip')
        .forEach(function(c) { c.classList.remove('active'); });
    el.classList.add('active');
}

// ── Avoid items ───────────────────────────────────────────────────
function adjAddAvoid(e) {
    if (e.key !== 'Enter') return;
    const input = document.getElementById('adj-avoid-input');
    const val   = input.value.trim();
    if (!val || adjAvoidItems.includes(val)) { input.value = ''; return; }

    adjAvoidItems.push(val);
    adjRenderAvoid();
    input.value = '';
}

function adjRemoveAvoid(item) {
    adjAvoidItems = adjAvoidItems.filter(function(v) { return v !== item; });
    adjRenderAvoid();
}

function adjRenderAvoid() {
    const list = document.getElementById('adj-avoid-list');
    list.innerHTML = adjAvoidItems.map(function(item) {
        return '<span class="adj-avoid-chip">' + item
             + ' <span onclick="adjRemoveAvoid(\'' + item.replace(/'/g, "\\'") + '\')"'
             + ' style="cursor:pointer; margin-left:4px;">×</span></span>';
    }).join('');
}

// ── Load preferensi saat modal dibuka ────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalAdjustPlan');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function () {
        fetch(ADJ_GET_ROUTE, {
            credentials: 'same-origin',
            headers: {
                'Accept'           : 'application/json',
                'X-Requested-With' : 'XMLHttpRequest',
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (!res.success) return;
            const d = res.data;

            // Kalori
            document.getElementById('adj-kcal-slider').value = d.target_kalori;
            adjUpdateKcal(d.target_kalori);

            // Makro
            document.querySelector('.adj-slider-protein').value = d.protein_pct;
            document.querySelector('.adj-slider-carbs').value   = d.carbs_pct;
            document.querySelector('.adj-slider-fat').value     = d.fat_pct;
            document.getElementById('adj-protein-pct').textContent = d.protein_pct + '%';
            document.getElementById('adj-carbs-pct').textContent   = d.carbs_pct   + '%';
            document.getElementById('adj-fat-pct').textContent     = d.fat_pct     + '%';
            adjRefreshBar();

            // Diet pref
            document.querySelectorAll('#adj-diet-chips .adj-pref-chip').forEach(function(c) {
                c.classList.toggle('active', c.dataset.value === d.diet_pref);
            });

            // Meals per day
            document.querySelectorAll('#adj-meals-per-day .adj-num-chip').forEach(function(c) {
                c.classList.toggle('active', parseInt(c.dataset.value) === d.meals_per_day);
            });

            // Avoid items
            adjAvoidItems = d.avoid_items || [];
            adjRenderAvoid();
        })
        .catch(function(e) { console.error('Load pref error:', e); });
    });
});

// ── Simpan ────────────────────────────────────────────────────────
async function adjSave() {
    const p = parseInt(document.querySelector('.adj-slider-protein').value);
    const c = parseInt(document.querySelector('.adj-slider-carbs').value);
    const f = parseInt(document.querySelector('.adj-slider-fat').value);

    if (p + c + f !== 100) {
        alert('Total komposisi makro harus 100%!');
        return;
    }

    const activeDiet  = document.querySelector('#adj-diet-chips .adj-pref-chip.active');
    const activeMeals = document.querySelector('#adj-meals-per-day .adj-num-chip.active');

    const payload = {
        target_kalori : parseInt(document.getElementById('adj-kcal-slider').value),
        protein_pct   : p,
        carbs_pct     : c,
        fat_pct       : f,
        diet_pref     : activeDiet  ? activeDiet.dataset.value      : 'balanced',
        meals_per_day : activeMeals ? parseInt(activeMeals.dataset.value) : 5,
        avoid_items   : adjAvoidItems,
    };

    const btn      = document.getElementById('adj-save-btn');
    const feedback = document.getElementById('adj-feedback');
    btn.disabled   = true;
    btn.textContent = 'Menyimpan…';

    try {
        const res  = await fetch(ADJ_PREF_ROUTE, {
            method     : 'POST',
            credentials: 'same-origin',
            headers    : {
                'Content-Type'     : 'application/json',
                'X-CSRF-TOKEN'     : ADJ_CSRF,
                'Accept'           : 'application/json',
                'X-Requested-With' : 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        feedback.style.display = 'block';
        if (res.ok && data.success) {

            // update target di Daily Goals tanpa reload
            if (typeof window.daysUpdateTargets === 'function') {
                window.daysUpdateTargets(payload);
            }

            // refresh timeline + nutrition panel
            window.dispatchEvent(new Event('days-reload'));

            feedback.style.display = 'block';
            feedback.style.color   = '#16A34A';
            feedback.textContent   = '✓ ' + data.message;

            // tutup modal setelah 1.2 detik
            setTimeout(function() {

                bootstrap.Modal.getInstance(
                    document.getElementById('modalAdjustPlan')
                ).hide();

                feedback.style.display = 'none';

            }, 1200);

        } else {
            feedback.style.color = '#DC2626';
            feedback.textContent = '✗ ' + (data.message || 'Gagal menyimpan.');
        }
    } catch (err) {
        feedback.style.display = 'block';
        feedback.style.color   = '#DC2626';
        feedback.textContent   = '✗ Network error. Coba lagi.';
        console.error(err);
    } finally {
        btn.disabled    = false;
        btn.textContent = 'Terapkan →';
    }
}
</script>
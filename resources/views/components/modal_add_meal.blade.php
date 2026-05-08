<div class="modal fade" id="modalAddMeal" tabindex="-1" aria-labelledby="modalAddMealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalAddMealLabel" style="font-size:1rem; color:#111827;">
                        Add Meal / Drinks / Snacks
                    </h5>
                    <p class="m-0" style="font-size:0.72rem; color:#6B7280;">
                        {{ date('l, d F Y') }}
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding:18px 22px;">

                {{-- Category tabs --}}
                <div class="mb-3">
                    <div class="tab-toggle-modal" id="am-category-row">
                        <button type="button" class="tab-btn-modal active" onclick="amSelectCategory(this,'meal')">🍽️
                            Meal</button>
                        <button type="button" class="tab-btn-modal" onclick="amSelectCategory(this,'drink')">💧
                            Drinks</button>
                        <button type="button" class="tab-btn-modal" onclick="amSelectCategory(this,'snack')">🍎
                            Snacks</button>
                    </div>
                </div>

                {{-- Time slot --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Waktu Makan</p>
                    <div class="time-slots-modal" id="am-slot-row">
                        <div class="time-slot-modal" onclick="amSelectSlot(this)">
                            <span class="ts-type">Breakfast</span>
                            <span class="ts-time">08:00</span>
                        </div>
                        <div class="time-slot-modal active" onclick="amSelectSlot(this)">
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
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Cari Item</p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input class="np-input-search" id="am-search" type="text"
                            placeholder="Cari makanan, minuman, snack…" oninput="amFilterItems(this.value)">
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

                {{-- Result list --}}
                <div class="meal-scroll-modal" id="am-item-list">
                    <div class="meal-result-row selected" onclick="amToggleItem(this)" data-kcal="560" data-protein="38"
                        data-carbs="62" data-fat="14">
                        <div class="mrr-img">🥗</div>
                        <div class="flex-grow-1">
                            <p class="mrr-name">Grilled Chicken Quinoa Bowl</p>
                            <p class="mrr-macro">560 kcal · 38g protein · Balanced</p>
                        </div>
                        <div class="mrr-check">✓</div>
                    </div>
                    <div class="meal-result-row" onclick="amToggleItem(this)" data-kcal="180" data-protein="14"
                        data-carbs="20" data-fat="4">
                        <div class="mrr-img">🥛</div>
                        <div class="flex-grow-1">
                            <p class="mrr-name">Greek Yogurt with Berries</p>
                            <p class="mrr-macro">180 kcal · 14g protein · Light</p>
                        </div>
                        <div class="mrr-check">✓</div>
                    </div>
                    <div class="meal-result-row" onclick="amToggleItem(this)" data-kcal="90" data-protein="0"
                        data-carbs="22" data-fat="0">
                        <div class="mrr-img">🥤</div>
                        <div class="flex-grow-1">
                            <p class="mrr-name">Jus Jeruk Segar</p>
                            <p class="mrr-macro">90 kcal · Vitamin C · Drinks</p>
                        </div>
                        <div class="mrr-check">✓</div>
                    </div>
                    <div class="meal-result-row" onclick="amToggleItem(this)" data-kcal="220" data-protein="7"
                        data-carbs="18" data-fat="14">
                        <div class="mrr-img">🥜</div>
                        <div class="flex-grow-1">
                            <p class="mrr-name">Mixed Nuts & Apple</p>
                            <p class="mrr-macro">220 kcal · 7g protein · Snack</p>
                        </div>
                        <div class="mrr-check">✓</div>
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
                                <input class="np-input-modal" type="text" placeholder="Nama makanan / minuman">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" type="number" placeholder="kcal" min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" type="number" placeholder="Protein (g)"
                                    min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" type="number" placeholder="Carbs (g)" min="0">
                            </div>
                            <div class="col-3">
                                <input class="np-input-modal" type="number" placeholder="Fat (g)" min="0">
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
                        <span class="np-stat-val" id="am-kcal" style="color:var(--warna-oren);">560</span>
                        <span class="np-stat-label">kcal</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-protein">38g</span>
                        <span class="np-stat-label">protein</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-carbs">62g</span>
                        <span class="np-stat-label">carbs</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="am-fat">14g</span>
                        <span class="np-stat-label">fat</span>
                    </div>
                </div>

            </div>

            <div class="modal-footer"
                style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-oren" onclick="amSave()">Tambahkan →</button>
            </div>

        </div>
    </div>
</div>
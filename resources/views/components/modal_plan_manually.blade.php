<div class="modal fade" id="modalPlanManually" tabindex="-1" aria-labelledby="modalPlanManuallyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalPlanManuallyLabel"
                        style="font-size:1rem; color:#111827;">
                        Plan Manually
                    </h5>
                    <p class="m-0" style="font-size:0.72rem; color:#6B7280;">Pilih tanggal, cari makanan, dan atur
                        jadwal</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding:18px 22px;">

                {{-- Date chips --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Tanggal</p>
                    <div class="d-flex gap-1" id="pm-date-row">
                        @foreach (range(1, 6) as $i)
                            @php $d = now()->addDays($i); @endphp
                            <div class="date-chip {{ $i === 1 ? 'active' : '' }}" data-date="{{ $d->format('Y-m-d') }}"
                                onclick="pmSelectDate(this)">
                                <span class="dc-day">{{ $d->format('D') }}</span>
                                <span class="dc-num">{{ $d->format('j') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Time slots --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Tipe & Waktu Makan
                    </p>
                    <div class="time-slots-modal" id="pm-slot-row">
                        <div class="time-slot-modal" onclick="pmSelectSlot(this)">
                            <span class="ts-type">Breakfast</span>
                            <span class="ts-time">08:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="pmSelectSlot(this)">
                            <span class="ts-type">Snack</span>
                            <span class="ts-time">10:30</span>
                        </div>
                        <div class="time-slot-modal active" onclick="pmSelectSlot(this)">
                            <span class="ts-type">Lunch</span>
                            <span class="ts-time">13:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="pmSelectSlot(this)">
                            <span class="ts-type">Dinner</span>
                            <span class="ts-time">19:30</span>
                        </div>
                    </div>
                </div>

                {{-- Search meal --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Cari Makanan /
                        Resep</p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input class="np-input-search" id="pm-search" type="text"
                            placeholder="e.g. Grilled salmon, avocado toast…" oninput="pmFilterMeals(this.value)">
                    </div>
                    <div class="meal-scroll-modal mt-2" id="pm-meal-list">
                        <div class="meal-result-row selected" onclick="pmToggleMeal(this)" data-kcal="560"
                            data-protein="38" data-carbs="62" data-fat="14" data-fiber="6">
                            <div class="mrr-img">🥗</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Grilled Chicken Quinoa Bowl</p>
                                <p class="mrr-macro">560 kcal · 38g protein · Balanced</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                        <div class="meal-result-row" onclick="pmToggleMeal(this)" data-kcal="520" data-protein="45"
                            data-carbs="12" data-fat="28" data-fiber="5">
                            <div class="mrr-img">🐟</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Salmon & Steamed Veggies</p>
                                <p class="mrr-macro">520 kcal · 45g protein · Keto</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                        <div class="meal-result-row" onclick="pmToggleMeal(this)" data-kcal="420" data-protein="22"
                            data-carbs="38" data-fat="16" data-fiber="7">
                            <div class="mrr-img">🥑</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Avocado Toast & Poached Eggs</p>
                                <p class="mrr-macro">420 kcal · 22g protein · Quick Meal</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                        <div class="meal-result-row" onclick="pmToggleMeal(this)" data-kcal="180" data-protein="14"
                            data-carbs="20" data-fat="4" data-fiber="3">
                            <div class="mrr-img">🥛</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Greek Yogurt with Berries</p>
                                <p class="mrr-macro">180 kcal · 14g protein · Light</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                    </div>
                </div>

                {{-- Servings + Time --}}
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Porsi</p>
                        <div class="d-flex align-items-center gap-2">
                            <button class="serving-btn-modal" type="button" onclick="pmChangeServ(-1)">−</button>
                            <span class="fw-bold" id="pm-serv-val"
                                style="min-width:20px; text-align:center;">1</span>
                            <button class="serving-btn-modal" type="button" onclick="pmChangeServ(1)">+</button>
                            <span style="font-size:0.72rem; color:#6B7280;">porsi</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Waktu Kustom
                        </p>
                        <input class="np-input-modal" type="time" id="pm-custom-time" value="13:00">
                    </div>
                </div>

                {{-- Nutrition preview --}}
                <div class="nutri-preview-modal mb-3">
                    <div class="np-stat">
                        <span class="np-stat-val" id="pm-kcal" style="color:var(--warna-oren);">560</span>
                        <span class="np-stat-label">kcal</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="pm-protein">38g</span>
                        <span class="np-stat-label">protein</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="pm-carbs">62g</span>
                        <span class="np-stat-label">carbs</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="pm-fat">14g</span>
                        <span class="np-stat-label">fat</span>
                    </div>
                    <div class="np-stat-divider"></div>
                    <div class="np-stat">
                        <span class="np-stat-val" id="pm-fiber">6g</span>
                        <span class="np-stat-label">fiber</span>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Catatan (opsional)
                    </p>
                    <textarea class="np-textarea-modal" placeholder="Tambahkan catatan, misal: kurangi garam…"></textarea>
                </div>

            </div>

            <div class="modal-footer"
                style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-oren" onclick="pmSavePlan()">Simpan Plan →</button>
            </div>

        </div>
    </div>
</div>
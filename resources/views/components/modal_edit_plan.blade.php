<div class="modal fade" id="modalEditPlan" tabindex="-1" aria-labelledby="modalEditPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0 d-flex align-items-center gap-2" id="modalEditPlanLabel"
                        style="font-size:1rem; color:#111827;">
                        Edit Plan
                        <span class="badge-editing">Editing</span>
                    </h5>
                    <p class="m-0" id="ep-subtitle" style="font-size:0.72rem; color:#6B7280;">Memuat…</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding:18px 22px;">

                {{-- Current meal card --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Meal saat ini</p>
                    <div class="current-meal-card-modal">
                        <img class="cmc-img-modal" id="ep-meal-img" src="{{ asset('img/meal1_home.png') }}"
                            alt="meal"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="mrr-img" id="ep-meal-emoji" style="display:none;">🍽️</div>
                        <div class="flex-grow-1">
                            <p class="cmc-name-modal" id="ep-meal-name">—</p>
                            <div class="d-flex gap-1 flex-wrap mb-1" id="ep-meal-tags"></div>
                            <p class="m-0" id="ep-meal-macro" style="font-size:0.6rem; color:#6B7280;">—</p>
                        </div>
                        <button type="button" class="cmc-change-modal" onclick="epToggleReplace()">Replace →</button>
                    </div>
                </div>

                {{-- Replace area --}}
                <div id="ep-replace-area" style="display:none;" class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Ganti dengan</p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input class="np-input-search" type="text" placeholder="Cari meal pengganti…"
                            oninput="epFilterMeals(this.value)">
                    </div>
                    <div class="meal-scroll-modal mt-2" id="ep-meal-list">
                        <div class="meal-result-row" onclick="epToggleMeal(this)">
                            <div class="mrr-img">🥗</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Grilled Chicken Quinoa Bowl</p>
                                <p class="mrr-macro">560 kcal · 38g protein</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                        <div class="meal-result-row" onclick="epToggleMeal(this)">
                            <div class="mrr-img">🥑</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Avocado Toast & Poached Eggs</p>
                                <p class="mrr-macro">420 kcal · 22g protein</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                        <div class="meal-result-row" onclick="epToggleMeal(this)">
                            <div class="mrr-img">🐟</div>
                            <div class="flex-grow-1">
                                <p class="mrr-name">Salmon & Steamed Veggies</p>
                                <p class="mrr-macro">520 kcal · 45g protein</p>
                            </div>
                            <div class="mrr-check">✓</div>
                        </div>
                    </div>
                </div>

                {{-- Tab toggle --}}
                <div class="mb-3">
                    <div class="tab-toggle-modal">
                        <button type="button" class="tab-btn-modal active"
                            onclick="epSwitchTab(this,'details')">Details</button>
                        <button type="button" class="tab-btn-modal"
                            onclick="epSwitchTab(this,'reschedule')">Reschedule</button>
                        <button type="button" class="tab-btn-modal"
                            onclick="epSwitchTab(this,'nutrition')">Nutrition</button>
                    </div>
                </div>

                {{-- Tab: Details --}}
                <div id="ep-tab-details">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Porsi</p>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="serving-btn-modal"
                                    onclick="epChangeServ(-1)">−</button>
                                <span class="fw-bold" id="ep-serv-val"
                                    style="min-width:20px; text-align:center;">1</span>
                                <button type="button" class="serving-btn-modal" onclick="epChangeServ(1)">+</button>
                                <span style="font-size:0.72rem; color:#6B7280;">porsi</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Waktu</p>
                            <input class="np-input-modal" type="time" id="ep-time" value="13:00">
                        </div>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Catatan</p>
                        <textarea class="np-textarea-modal" id="ep-notes" placeholder="Update catatan untuk meal ini…"></textarea>
                    </div>
                </div>

                {{-- Tab: Reschedule --}}
                <div id="ep-tab-reschedule" style="display:none;">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Pindah ke hari
                        lain</p>
                    <div class="d-flex gap-1 mb-3">
                        @foreach (range(1, 6) as $i)
                            @php $d = now()->addDays($i); @endphp
                            <div class="date-chip {{ $i === 1 ? 'active' : '' }}"
                                data-date="{{ $d->format('Y-m-d') }}" onclick="epSelectDate(this)">
                                <span class="dc-day">{{ $d->format('D') }}</span>
                                <span class="dc-num">{{ $d->format('j') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Meal slot</p>
                    <div class="time-slots-modal">
                        <div class="time-slot-modal" onclick="epSelectSlot(this)">
                            <span class="ts-type">Breakfast</span><span class="ts-time">08:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="epSelectSlot(this)">
                            <span class="ts-type">Snack</span><span class="ts-time">10:30</span>
                        </div>
                        <div class="time-slot-modal active" onclick="epSelectSlot(this)">
                            <span class="ts-type">Lunch</span><span class="ts-time">13:00</span>
                        </div>
                        <div class="time-slot-modal" onclick="epSelectSlot(this)">
                            <span class="ts-type">Dinner</span><span class="ts-time">19:30</span>
                        </div>
                    </div>
                </div>

                {{-- Tab: Nutrition --}}
                <div id="ep-tab-nutrition" style="display:none;">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Rincian nutrisi
                    </p>
                    <div>
                        <div class="nutri-breakdown-row">
                            <span class="nutri-breakdown-label">Calories</span>
                            <span class="nutri-breakdown-val" id="ep-n-kcal"
                                style="color:var(--warna-oren);">—</span>
                        </div>
                        <div class="nutri-breakdown-row">
                            <span class="nutri-breakdown-label">Protein</span>
                            <span class="nutri-breakdown-val" id="ep-n-protein" style="color:#6e9c29;">—</span>
                        </div>
                        <div class="nutri-breakdown-row">
                            <span class="nutri-breakdown-label">Carbohydrates</span>
                            <span class="nutri-breakdown-val" id="ep-n-carbs">—</span>
                        </div>
                        <div class="nutri-breakdown-row">
                            <span class="nutri-breakdown-label">Fat</span>
                            <span class="nutri-breakdown-val" id="ep-n-fat">—</span>
                        </div>
                        <div class="nutri-breakdown-row">
                            <span class="nutri-breakdown-label">Fiber</span>
                            <span class="nutri-breakdown-val" id="ep-n-fiber">—</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer — tombol diberi warna proper --}}
            <div class="modal-footer"
                style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-delete-modal" onclick="epDeletePlan()">Hapus Plan</button>
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-ijo" onclick="epSavePlan()">Simpan →</button>
            </div>

        </div>
    </div>
</div>
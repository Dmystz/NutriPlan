<div class="modal fade" id="modalAdjustPlan" tabindex="-1" aria-labelledby="modalAdjustPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px; border:0.8px solid rgba(0,0,0,0.08); overflow:hidden;">

            <div class="modal-header" style="border-bottom:0.8px solid rgba(0,0,0,0.07); padding:18px 22px 14px;">
                <div>
                    <h5 class="modal-title fw-bold m-0" id="modalAdjustPlanLabel"
                        style="font-size:1rem; color:#111827;">
                        Adjust Meal Plan
                    </h5>
                    <p class="m-0" style="font-size:0.72rem; color:#6B7280;">Sesuaikan target dan preferensi nutrisi
                        harian</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding:18px 22px;">

                {{-- Calorie target --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <p style="font-size:0.72rem; font-weight:700; color:#374151; margin:0;">Target Kalori Harian</p>
                        <span style="font-size:0.78rem; font-weight:700; color:var(--warna-oren);"
                            id="adj-kcal-val">2200 kcal</span>
                    </div>
                    <input type="range" class="adj-slider" id="adj-kcal-slider" min="1200" max="3500"
                        step="50" value="2200" oninput="adjUpdateKcal(this.value)">
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
                            <span style="font-size:0.72rem; font-weight:700; color:#FB2C36;"
                                id="adj-protein-pct">25%</span>
                        </div>
                        <input type="range" class="adj-slider adj-slider-protein" min="10" max="50"
                            step="5" value="25" oninput="adjUpdateMacro('protein', this.value)">
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.72rem; color:#374151;">Carbs</span>
                            <span style="font-size:0.72rem; font-weight:700; color:#FE9A00;"
                                id="adj-carbs-pct">45%</span>
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

                    {{-- Visual bar --}}
                    <div style="display:flex; height:8px; border-radius:50px; overflow:hidden; gap:2px;"
                        id="adj-macro-bar">
                        <div style="width:25%; background:#FB2C36; border-radius:50px 0 0 50px;" id="adj-bar-protein">
                        </div>
                        <div style="width:45%; background:#FE9A00;" id="adj-bar-carbs"></div>
                        <div style="width:30%; background:#95CD41; border-radius:0 50px 50px 0;" id="adj-bar-fat"></div>
                    </div>
                </div>

                {{-- Dietary preference --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Preferensi Diet</p>
                    <div class="d-flex flex-wrap gap-2" id="adj-diet-chips">
                        <span class="adj-pref-chip active" onclick="adjTogglePref(this)">Balanced</span>
                        <span class="adj-pref-chip" onclick="adjTogglePref(this)">High Protein</span>
                        <span class="adj-pref-chip" onclick="adjTogglePref(this)">Keto</span>
                        <span class="adj-pref-chip" onclick="adjTogglePref(this)">Vegan</span>
                        <span class="adj-pref-chip" onclick="adjTogglePref(this)">Low Carb</span>
                        <span class="adj-pref-chip" onclick="adjTogglePref(this)">Mediterranean</span>
                    </div>
                </div>

                {{-- Meals per day --}}
                <div class="mb-3">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:8px;">Jumlah Makan per
                        Hari</p>
                    <div class="d-flex gap-2" id="adj-meals-per-day">
                        @foreach ([2, 3, 4, 5, 6] as $n)
                            <div class="adj-num-chip {{ $n === 5 ? 'active' : '' }}" onclick="adjSelectMeals(this)">
                                {{ $n }}x</div>
                        @endforeach
                    </div>
                </div>

                {{-- Allergy / avoid --}}
                <div class="mb-1">
                    <p style="font-size:0.72rem; font-weight:700; color:#374151; margin-bottom:6px;">Hindari / Alergi
                    </p>
                    <div class="np-search-wrap">
                        <svg class="np-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input class="np-input-search" type="text" placeholder="e.g. gluten, dairy, nuts…">
                    </div>
                    <div class="d-flex flex-wrap gap-1 mt-2">
                        <span class="adj-avoid-chip">🥜 Kacang <span onclick="this.parentElement.remove()"
                                style="cursor:pointer; margin-left:4px;">×</span></span>
                        <span class="adj-avoid-chip">🥛 Dairy <span onclick="this.parentElement.remove()"
                                style="cursor:pointer; margin-left:4px;">×</span></span>
                    </div>
                </div>

            </div>

            <div class="modal-footer"
                style="border-top:0.8px solid rgba(0,0,0,0.07); padding:12px 22px 16px; gap:8px;">
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-save-modal-ijo" onclick="adjSave()">Terapkan →</button>
            </div>

        </div>
    </div>
</div>
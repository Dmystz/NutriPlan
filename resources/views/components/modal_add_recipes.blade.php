{{-- ================================================================
     MODAL ADD RECIPE — NutriPlan
     Fungsional: validasi, preview, AJAX submit ke /api/recipes
     Sesuai struktur tabel: katalog_resep
     ================================================================ --}}

<div class="modal fade" id="modalAddRecipe" tabindex="-1" aria-labelledby="modalAddRecipeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content ar-modal-content">

            {{-- Accent bar --}}
            <div class="ar-accent-bar"></div>

            {{-- Header --}}
            <div class="modal-header ar-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="ar-header-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="#fff" stroke-width="2.2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold m-0" id="modalAddRecipeLabel"
                            style="font-size:1rem; color:#111827;">
                            Add New Recipe
                        </h5>
                        <p class="m-0" style="font-size:0.72rem; color:#6B7280;">Bagikan resep favoritmu ke komunitas NutriPlan</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body ar-body">

                {{-- ── Step indicator ── --}}
                <div class="ar-steps mb-4">
                    <div class="ar-step active" id="step-ind-1">
                        <div class="ar-step-circle">1</div>
                        <span class="ar-step-label">Info Dasar</span>
                    </div>
                    <div class="ar-step-line"></div>
                    <div class="ar-step" id="step-ind-2">
                        <div class="ar-step-circle">2</div>
                        <span class="ar-step-label">Bahan & Langkah</span>
                    </div>
                    <div class="ar-step-line"></div>
                    <div class="ar-step" id="step-ind-3">
                        <div class="ar-step-circle">3</div>
                        <span class="ar-step-label">Nutrisi & Publish</span>
                    </div>
                </div>

                {{-- Validation alert --}}
                <div id="ar-alert" class="ar-alert" style="display:none;"></div>

                {{-- ════ STEP 1 — Info Dasar ════ --}}
                <div id="ar-step-1">

                    {{-- Photo upload --}}
                    <div class="mb-3">
                        <label class="ar-label">Foto Resep</label>
                        <div class="ar-photo-upload" id="ar-photo-drop"
                            onclick="document.getElementById('ar-photo-input').click()">
                            <div class="ar-photo-placeholder" id="ar-photo-placeholder">
                                <div class="ar-photo-icon">📷</div>
                                <p class="ar-photo-text">Klik atau drag foto ke sini</p>
                                <p class="ar-photo-hint">JPG, PNG · Max 5 MB</p>
                            </div>
                            <img id="ar-photo-preview" src="" alt="preview"
                                style="display:none; width:100%; height:100%; object-fit:cover; border-radius:14px;">
                            <button type="button" id="ar-photo-remove"
                                onclick="arRemovePhoto(event)"
                                style="display:none; position:absolute; top:8px; right:8px; z-index:2;
                                       width:26px; height:26px; border-radius:50%; border:none;
                                       background:rgba(0,0,0,.55); color:#fff; font-size:.9rem;
                                       cursor:pointer; align-items:center; justify-content:center;">×</button>
                        </div>
                        <input type="file" id="ar-photo-input" accept="image/jpeg,image/png,image/webp" style="display:none"
                            onchange="arPreviewPhoto(this)">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <label class="ar-label">Nama Resep <span class="ar-required">*</span></label>
                            <input class="ar-input" type="text" placeholder="e.g. Grilled Salmon with Lemon Butter"
                                id="ar-name" maxlength="120" oninput="arUpdatePreviewTags()">
                            <div class="ar-field-err" id="err-name"></div>
                        </div>
                        <div class="col-12">
                            <label class="ar-label">Deskripsi Singkat</label>
                            <textarea class="ar-textarea" placeholder="Ceritakan sedikit tentang resep ini…"
                                id="ar-desc" rows="2" maxlength="500"></textarea>
                        </div>
                    </div>

                    {{-- Meal type + Preference tags --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="ar-label">Tipe Meal <span class="ar-required">*</span></label>
                            <div class="ar-chip-group" id="ar-meal-type">
                                @foreach (['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Desserts', 'Drinks'] as $t)
                                    <span class="ar-chip" data-value="{{ strtolower($t) }}"
                                        onclick="arToggleChip(this,'meal-type')">{{ $t }}</span>
                                @endforeach
                            </div>
                            <div class="ar-field-err" id="err-meal-type"></div>
                        </div>
                        <div class="col-6">
                            <label class="ar-label">Preferensi Diet</label>
                            <div class="ar-chip-group" id="ar-diet-pref">
                                @foreach (['Vegan', 'Keto', 'Low-Carb', 'High-Protein', 'Gluten-Free', 'Quick Meal'] as $p)
                                    <span class="ar-chip" data-value="{{ $p }}"
                                        onclick="arToggleChip(this,'diet-pref')">{{ $p }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Time + Servings + Difficulty --}}
                    <div class="row g-2">
                        <div class="col-4">
                            <label class="ar-label">Waktu Masak</label>
                            <div class="ar-input-unit-wrap">
                                <input class="ar-input" type="number" placeholder="30" min="1" max="600"
                                    id="ar-cook-time">
                                <span class="ar-unit">min</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="ar-label">Porsi</label>
                            <div class="ar-input-unit-wrap">
                                <input class="ar-input" type="number" placeholder="2" min="1" max="100"
                                    id="ar-servings">
                                <span class="ar-unit">pax</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="ar-label">Kesulitan</label>
                            <select class="ar-input ar-select" id="ar-difficulty">
                                <option value="">Pilih…</option>
                                <option value="easy">😊 Easy</option>
                                <option value="medium">😤 Medium</option>
                                <option value="hard">🔥 Hard</option>
                            </select>
                        </div>
                    </div>

                </div>

                {{-- ════ STEP 2 — Bahan & Langkah ════ --}}
                <div id="ar-step-2" style="display:none;">

                    {{-- Ingredients --}}
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="ar-label m-0">Bahan-Bahan <span class="ar-required">*</span></label>
                            <button type="button" class="ar-btn-add-row" onclick="arAddIngredient()">+ Tambah Bahan</button>
                        </div>
                        <div id="ar-ingredient-list">
                            <div class="ar-ingredient-row">
                                <input class="ar-input ar-ing-name" type="text" placeholder="e.g. Chicken breast">
                                <input class="ar-input ar-ing-qty" type="text" placeholder="200g">
                                <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>
                            </div>
                            <div class="ar-ingredient-row">
                                <input class="ar-input ar-ing-name" type="text" placeholder="e.g. Olive oil">
                                <input class="ar-input ar-ing-qty" type="text" placeholder="2 tbsp">
                                <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>
                            </div>
                        </div>
                        <div class="ar-field-err" id="err-ingredients"></div>
                    </div>

                    {{-- Steps --}}
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="ar-label m-0">Langkah Memasak <span class="ar-required">*</span></label>
                            <button type="button" class="ar-btn-add-row" onclick="arAddStep()">+ Tambah Langkah</button>
                        </div>
                        <div id="ar-step-list">
                            <div class="ar-step-row">
                                <div class="ar-step-num">1</div>
                                <textarea class="ar-textarea ar-flex-1" rows="2"
                                    placeholder="e.g. Marinate chicken with salt, pepper, and olive oil for 15 minutes…"></textarea>
                                <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>
                            </div>
                            <div class="ar-step-row">
                                <div class="ar-step-num">2</div>
                                <textarea class="ar-textarea ar-flex-1" rows="2"
                                    placeholder="e.g. Heat grill to medium-high and cook chicken for 6-7 minutes each side…"></textarea>
                                <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>
                            </div>
                        </div>
                        <div class="ar-field-err" id="err-steps"></div>
                    </div>

                </div>

                {{-- ════ STEP 3 — Nutrisi & Publish ════ --}}
                <div id="ar-step-3" style="display:none;">

                    <p class="ar-section-note mb-3">
                        💡 Info nutrisi bersifat opsional, tapi membantu pengguna lain memilih resep yang sesuai target mereka.
                    </p>

                    <div class="row g-2 mb-4">
                        @foreach ([
                            ['Calories', 'ar-n-kcal',    'kcal', '#ea5c2b'],
                            ['Protein',  'ar-n-protein',  'g',    '#6ab32b'],
                            ['Carbs',    'ar-n-carbs',    'g',    '#FE9A00'],
                            ['Fat',      'ar-n-fat',      'g',    '#f97316'],
                            ['Fiber',    'ar-n-fiber',    'g',    '#2B7FFF'],
                        ] as $n)
                            <div class="col-6 col-sm-4">
                                <label class="ar-label" style="color:{{ $n[3] }}; font-weight:800;">{{ $n[0] }}</label>
                                <div class="ar-input-unit-wrap">
                                    <input class="ar-input" type="number" placeholder="0" min="0" step="0.1"
                                        id="{{ $n[1] }}">
                                    <span class="ar-unit">{{ $n[2] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Visibility --}}
                    <div class="mb-3">
                        <label class="ar-label">Visibilitas Resep</label>
                        <div class="ar-visibility-group">
                            <label class="ar-vis-option active" id="vis-public" onclick="arSetVis('public')">
                                <span class="ar-vis-icon">🌍</span>
                                <div>
                                    <p class="ar-vis-title">Publik</p>
                                    <p class="ar-vis-sub">Semua orang bisa melihat</p>
                                </div>
                                <div class="ar-vis-check" id="vc-public">✓</div>
                            </label>
                            <label class="ar-vis-option" id="vis-private" onclick="arSetVis('private')">
                                <span class="ar-vis-icon">🔒</span>
                                <div>
                                    <p class="ar-vis-title">Pribadi</p>
                                    <p class="ar-vis-sub">Hanya kamu yang bisa lihat</p>
                                </div>
                                <div class="ar-vis-check" id="vc-private"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Preview card --}}
                    <div class="ar-preview-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="font-size:0.72rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.05em;">
                                Preview kartu resepmu
                            </span>
                        </div>
                        <div class="recipe-card" style="max-width:200px; pointer-events:none;">
                            <div id="ar-preview-img-wrap"
                                style="height:90px; background:linear-gradient(135deg,rgba(234,92,43,0.15),rgba(149,205,65,0.15));
                                       display:flex; align-items:center; justify-content:center; font-size:2.5rem; overflow:hidden;">
                                🍽️
                            </div>
                            <div class="recipe-card-body">
                                <p class="recipe-card-title" id="ar-preview-name">Nama Resepmu</p>
                                <div class="d-flex gap-1 flex-wrap" id="ar-preview-tags">
                                    <span class="recipe-tag" style="background:#9CA3AF;">Tag</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer ar-footer">
                <button type="button" class="ar-btn-back" id="ar-btn-back" onclick="arPrevStep()"
                    style="display:none;">← Kembali</button>
                <div class="ms-auto d-flex gap-2 align-items-center">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="ar-btn-next" id="ar-btn-next" onclick="arNextStep()">Lanjut →</button>
                    <button type="button" class="ar-btn-publish" id="ar-btn-publish" onclick="arPublish()"
                        style="display:none;">
                        🚀 Publish Resep
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- ── Add Recipe Styles ── --}}
<style>
    .ar-modal-content {
        border-radius: 20px !important;
        border: 0.8px solid rgba(0, 0, 0, 0.08) !important;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.14) !important;
    }
    .ar-accent-bar {
        height: 3px;
        background: linear-gradient(90deg, #ea5c2b 0%, #95cd41 100%);
    }
    .ar-header {
        border-bottom: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 16px 22px 14px;
    }
    .ar-header-icon {
        width: 34px; height: 34px;
        background: linear-gradient(135deg, #ea5c2b, #f97316);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(234, 92, 43, 0.3);
    }
    .ar-body  { padding: 20px 24px; }
    .ar-footer {
        border-top: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 12px 22px 16px;
        gap: 8px;
    }

    /* Steps indicator */
    .ar-steps { display: flex; align-items: center; gap: 0; }
    .ar-step  { display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 0 0 auto; }
    .ar-step-circle {
        width: 28px; height: 28px; border-radius: 50%;
        background: #E5E7EB; color: #9CA3AF;
        font-size: 0.75rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease;
    }
    .ar-step.active .ar-step-circle {
        background: var(--warna-oren, #ea5c2b); color: #fff;
        box-shadow: 0 4px 10px rgba(234, 92, 43, 0.35);
    }
    .ar-step.done .ar-step-circle {
        background: var(--warna-ijo, #95cd41); color: #fff;
        box-shadow: 0 4px 10px rgba(149, 205, 65, 0.3);
    }
    .ar-step-label { font-size: 0.62rem; font-weight: 600; color: #9CA3AF; white-space: nowrap; transition: color 0.3s; }
    .ar-step.active .ar-step-label { color: var(--warna-oren, #ea5c2b); }
    .ar-step.done   .ar-step-label { color: #6ab32b; }
    .ar-step-line {
        flex: 1; height: 2px; background: #E5E7EB;
        margin: 0 6px; margin-bottom: 18px; border-radius: 2px; transition: background 0.3s;
    }

    /* Alert */
    .ar-alert {
        border-radius: 10px; padding: 10px 14px;
        font-size: 0.78rem; margin-bottom: 14px;
        background: #FFF5F5; border: 1px solid #FECACA; color: #DC2626;
    }

    /* Field errors */
    .ar-field-err {
        font-size: 0.68rem; color: #DC2626; margin-top: 4px; min-height: 14px;
    }
    .ar-input.is-invalid, .ar-textarea.is-invalid, .ar-select.is-invalid {
        border-color: #EF4444 !important;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.10) !important;
    }

    /* Photo upload */
    .ar-photo-upload {
        width: 100%; height: 160px;
        border: 2px dashed #D1D5DB; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; background: #FAFAFA;
        transition: all 0.2s ease; overflow: hidden; position: relative;
    }
    .ar-photo-upload:hover { border-color: var(--warna-oren, #ea5c2b); background: rgba(234,92,43,0.04); }
    .ar-photo-placeholder { text-align: center; }
    .ar-photo-icon  { font-size: 2rem; margin-bottom: 6px; }
    .ar-photo-text  { font-size: 0.8rem; font-weight: 600; color: #374151; margin: 0; }
    .ar-photo-hint  { font-size: 0.65rem; color: #9CA3AF; margin: 2px 0 0; }

    /* Label & inputs */
    .ar-label { font-size: 0.72rem; font-weight: 700; color: #374151; display: block; margin-bottom: 5px; }
    .ar-required { color: var(--warna-oren, #ea5c2b); }
    .ar-input {
        width: 100%; border-radius: 10px; border: 1.5px solid #E5E7EB;
        background: #F9FAFB; padding: 0.4rem 0.7rem; font-size: 0.82rem;
        color: #374151; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit;
    }
    .ar-input:focus { border-color: var(--warna-ijo, #95cd41); box-shadow: 0 0 0 3px rgba(149,205,65,0.12); background: #fff; }
    .ar-select { appearance: none; cursor: pointer; }
    .ar-textarea {
        width: 100%; border-radius: 10px; border: 1.5px solid #E5E7EB;
        background: #F9FAFB; padding: 0.45rem 0.7rem; font-size: 0.78rem;
        color: #374151; outline: none; resize: none;
        transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit;
    }
    .ar-textarea:focus { border-color: var(--warna-ijo, #95cd41); box-shadow: 0 0 0 3px rgba(149,205,65,0.12); background: #fff; }
    .ar-input-unit-wrap { position: relative; }
    .ar-unit { position: absolute; right: 0.7rem; top: 50%; transform: translateY(-50%); font-size: 0.7rem; color: #9CA3AF; pointer-events: none; }

    /* Chips */
    .ar-chip-group { display: flex; flex-wrap: wrap; gap: 5px; }
    .ar-chip {
        background: #F3F4F6; border: 1.5px solid #E5E7EB; border-radius: 50px;
        padding: 3px 10px; font-size: 0.68rem; font-weight: 600; color: #6B7280;
        cursor: pointer; transition: all 0.15s; user-select: none;
    }
    .ar-chip:hover { border-color: var(--warna-oren, #ea5c2b); color: var(--warna-oren, #ea5c2b); background: rgba(234,92,43,0.06); }
    .ar-chip.active { border-color: var(--warna-oren, #ea5c2b); background: rgba(234,92,43,0.10); color: var(--warna-oren, #ea5c2b); font-weight: 700; }

    /* Ingredient / Step rows */
    .ar-ingredient-row { display: flex; align-items: center; gap: 6px; margin-bottom: 6px; }
    .ar-ing-name { flex: 2; }
    .ar-ing-qty  { flex: 1; }
    .ar-step-row { display: flex; align-items: flex-start; gap: 8px; margin-bottom: 8px; }
    .ar-step-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, var(--warna-oren, #ea5c2b), #f97316);
        color: #fff; font-size: 0.7rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 6px;
        box-shadow: 0 3px 8px rgba(234,92,43,0.28);
    }
    .ar-flex-1 { flex: 1; }
    .ar-remove-btn {
        width: 24px; height: 24px; border: 1.5px solid #FECACA; background: #FFF5F5;
        color: #EF4444; border-radius: 50%; font-size: 1rem; line-height: 1;
        cursor: pointer; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s; margin-top: 4px;
    }
    .ar-remove-btn:hover { background: #FEE2E2; border-color: #EF4444; }
    .ar-btn-add-row {
        border: none; background: transparent; color: var(--warna-ijo, #95cd41);
        font-size: 0.72rem; font-weight: 700; cursor: pointer; padding: 0; transition: color 0.15s;
    }
    .ar-btn-add-row:hover { color: #6ab32b; }

    /* Visibility */
    .ar-visibility-group { display: flex; gap: 8px; }
    .ar-vis-option {
        flex: 1; display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 12px; border: 1.5px solid #E5E7EB;
        background: #F9FAFB; cursor: pointer; transition: all 0.18s;
    }
    .ar-vis-option.active { border-color: var(--warna-ijo, #95cd41); background: rgba(149,205,65,0.07); box-shadow: 0 3px 10px rgba(149,205,65,0.18); }
    .ar-vis-icon  { font-size: 1.3rem; }
    .ar-vis-title { font-size: 0.78rem; font-weight: 700; color: #111827; margin: 0; }
    .ar-vis-sub   { font-size: 0.62rem; color: #9CA3AF; margin: 0; }
    .ar-vis-check {
        margin-left: auto; width: 20px; height: 20px; border-radius: 50%;
        border: 1.5px solid #E5E7EB; background: #F3F4F6; color: transparent;
        font-size: 0.7rem; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.15s;
    }
    .ar-vis-option.active .ar-vis-check { background: var(--warna-ijo, #95cd41); border-color: var(--warna-ijo, #95cd41); color: #fff; }

    /* Preview card */
    .ar-preview-card {
        background: rgba(149, 205, 65, 0.06); border: 1.5px dashed rgba(149,205,65,0.4);
        border-radius: 14px; padding: 12px 14px;
    }
    .ar-section-note {
        background: rgba(234,92,43,0.07); border: 1px solid rgba(234,92,43,0.18);
        border-radius: 10px; padding: 10px 12px; font-size: 0.75rem; color: #374151; margin: 0;
    }

    /* Footer buttons */
    .ar-btn-back {
        border: 1.5px solid #E5E7EB; background: #F9FAFB; color: #6B7280;
        border-radius: 50px; padding: 0.45rem 1rem; font-size: 0.8rem; font-weight: 600;
        cursor: pointer; transition: all 0.15s;
    }
    .ar-btn-back:hover { background: #F3F4F6; }
    .ar-btn-next {
        border: none; background: linear-gradient(135deg, #ea5c2b, #f97316); color: #fff;
        border-radius: 50px; padding: 0.45rem 1.3rem; font-size: 0.82rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 4px 14px rgba(234,92,43,0.35); transition: all 0.2s;
    }
    .ar-btn-next:hover { opacity: 0.88; transform: translateY(-1px); }
    .ar-btn-next:disabled { opacity: 0.55; transform: none; cursor: not-allowed; }
    .ar-btn-publish {
        border: none; background: linear-gradient(135deg, #95cd41, #6ab32b); color: #fff;
        border-radius: 50px; padding: 0.45rem 1.3rem; font-size: 0.82rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 4px 14px rgba(149,205,65,0.38); transition: all 0.2s;
    }
    .ar-btn-publish:hover { opacity: 0.88; transform: translateY(-1px); }
    .ar-btn-publish:disabled { opacity: 0.55; transform: none; cursor: not-allowed; }

    /* Loading spinner in button */
    .ar-spinner {
        display: inline-block; width: 14px; height: 14px;
        border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff;
        border-radius: 50%; animation: ar-spin 0.7s linear infinite; vertical-align: middle;
    }
    @keyframes ar-spin { to { transform: rotate(360deg); } }
</style>


{{-- ── Add Recipe JS ── --}}
<script>
/* ── State (global scope agar onclick= di HTML bisa akses) ── */
var arCurrentStep = 1;
var arVisibility  = 'public';
var arPhotoFile   = null;

/* ── Helpers ── */
function arEl(id)  { return document.getElementById(id); }
function arQsa(sel){ return document.querySelectorAll(sel); }

function arClearErrors() {
    ['err-name','err-meal-type','err-ingredients','err-steps'].forEach(function(id) {
        var el = arEl(id);
        if (el) el.textContent = '';
    });
    arQsa('#modalAddRecipe .ar-input, #modalAddRecipe .ar-textarea, #modalAddRecipe .ar-select')
        .forEach(function(el){ el.classList.remove('is-invalid'); });
    var alert = arEl('ar-alert');
    if (alert) alert.style.display = 'none';
}

function arShowAlert(msg) {
    var el = arEl('ar-alert');
    if (!el) return;
    el.textContent = msg;
    el.style.display = 'block';
}

function arFieldError(fieldId, errId, msg) {
    var field = arEl(fieldId);
    var err   = arEl(errId);
    if (field) field.classList.add('is-invalid');
    if (err)   err.textContent = msg;
}

/* ── Validasi Step 1 ── */
function arValidateStep1() {
    arClearErrors();
    var ok   = true;
    var name = arEl('ar-name') ? arEl('ar-name').value.trim() : '';
    if (!name) {
        arFieldError('ar-name', 'err-name', 'Nama resep wajib diisi.');
        ok = false;
    }
    var mealActive = document.querySelector('#ar-meal-type .ar-chip.active');
    if (!mealActive) {
        var errMeal = arEl('err-meal-type');
        if (errMeal) errMeal.textContent = 'Pilih minimal satu tipe meal.';
        ok = false;
    }
    if (!ok) arShowAlert('Mohon lengkapi field yang ditandai merah sebelum melanjutkan.');
    return ok;
}

/* ── Validasi Step 2 ── */
function arValidateStep2() {
    arClearErrors();
    var ok = true;
    var ingNames = Array.from(arQsa('#ar-ingredient-list .ar-ing-name'))
        .map(function(i){ return i.value.trim(); }).filter(Boolean);
    if (ingNames.length === 0) {
        var errIng = arEl('err-ingredients');
        if (errIng) errIng.textContent = 'Tambahkan minimal satu bahan.';
        ok = false;
    }
    var stepTexts = Array.from(arQsa('#ar-step-list .ar-textarea'))
        .map(function(t){ return t.value.trim(); }).filter(Boolean);
    if (stepTexts.length === 0) {
        var errSt = arEl('err-steps');
        if (errSt) errSt.textContent = 'Tambahkan minimal satu langkah memasak.';
        ok = false;
    }
    if (!ok) arShowAlert('Mohon lengkapi bahan dan langkah memasak.');
    return ok;
}

/* ── Step navigation ── */
function arNextStep() {
    if (arCurrentStep === 1 && !arValidateStep1()) return;
    if (arCurrentStep === 2 && !arValidateStep2()) return;
    if (arCurrentStep < 3) {
        var cur = arEl('step-ind-' + arCurrentStep);
        cur.classList.remove('active');
        cur.classList.add('done');
        arEl('ar-step-' + arCurrentStep).style.display = 'none';
        arCurrentStep++;
        arEl('ar-step-' + arCurrentStep).style.display = 'block';
        arEl('step-ind-' + arCurrentStep).classList.add('active');
        arEl('ar-btn-back').style.display = '';
        if (arCurrentStep === 3) {
            arEl('ar-btn-next').style.display    = 'none';
            arEl('ar-btn-publish').style.display = '';
            arUpdatePreviewTags();
        }
        arClearErrors();
    }
}

function arPrevStep() {
    if (arCurrentStep > 1) {
        arEl('ar-step-' + arCurrentStep).style.display = 'none';
        arEl('step-ind-' + arCurrentStep).classList.remove('active');
        arCurrentStep--;
        arEl('ar-step-' + arCurrentStep).style.display = 'block';
        arEl('step-ind-' + arCurrentStep).classList.remove('done');
        arEl('step-ind-' + arCurrentStep).classList.add('active');
        arEl('ar-btn-next').style.display    = '';
        arEl('ar-btn-publish').style.display = 'none';
        if (arCurrentStep === 1) arEl('ar-btn-back').style.display = 'none';
        arClearErrors();
    }
}

/* ── Chips ── */
function arToggleChip(el, group) {
    if (group === 'meal-type') {
        arQsa('#ar-meal-type .ar-chip').forEach(function(c){ c.classList.remove('active'); });
        el.classList.add('active');
    } else {
        el.classList.toggle('active');
    }
    arUpdatePreviewTags();
}

/* ── Preview update ── */
function arUpdatePreviewTags() {
    var nameEl = arEl('ar-name');
    var name   = (nameEl ? nameEl.value.trim() : '') || 'Nama Resepmu';
    var previewName = arEl('ar-preview-name');
    if (previewName) previewName.textContent = name;

    var active    = arQsa('#ar-meal-type .ar-chip.active, #ar-diet-pref .ar-chip.active');
    var container = arEl('ar-preview-tags');
    if (!container) return;

    var colors = {
        'breakfast':'#95CD41','lunch':'#EA5C2B','dinner':'#374151',
        'snacks':'#FBBF24','desserts':'#A78BFA','drinks':'#2B7FFF',
        'Vegan':'#2B7FFF','Keto':'#6B7280','Low-Carb':'#FBBF24',
        'High-Protein':'#EA5C2B','Gluten-Free':'#95CD41','Quick Meal':'#95CD41'
    };
    container.innerHTML = '';
    active.forEach(function(chip) {
        var val  = chip.dataset.value || chip.textContent.trim();
        var span = document.createElement('span');
        span.className        = 'recipe-tag';
        span.style.background = colors[val] || '#9CA3AF';
        // Display label dengan kapitalisasi untuk preview
        span.textContent = val.charAt(0).toUpperCase() + val.slice(1);
        container.appendChild(span);
    });
    if (!active.length) container.innerHTML = '<span class="recipe-tag" style="background:#9CA3AF">Tag</span>';

    var imgWrap = arEl('ar-preview-img-wrap');
    if (imgWrap && arPhotoFile) {
        imgWrap.innerHTML = '<img src="' + URL.createObjectURL(arPhotoFile) + '" style="width:100%;height:90px;object-fit:cover;" alt="preview">';
    }
}

/* ── Ingredient rows ── */
function arAddIngredient() {
    var list = arEl('ar-ingredient-list');
    var row  = document.createElement('div');
    row.className = 'ar-ingredient-row';
    row.innerHTML = '<input class="ar-input ar-ing-name" type="text" placeholder="Nama bahan">'
                  + '<input class="ar-input ar-ing-qty" type="text" placeholder="Jumlah">'
                  + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>';
    list.appendChild(row);
    row.querySelector('.ar-ing-name').focus();
}

/* ── Step rows ── */
function arAddStep() {
    var list = arEl('ar-step-list');
    var num  = list.children.length + 1;
    var row  = document.createElement('div');
    row.className = 'ar-step-row';
    row.innerHTML = '<div class="ar-step-num">' + num + '</div>'
                  + '<textarea class="ar-textarea ar-flex-1" rows="2" placeholder="Langkah ' + num + '…"></textarea>'
                  + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>';
    list.appendChild(row);
    row.querySelector('textarea').focus();
}

function arRemoveRow(btn) {
    btn.closest('.ar-ingredient-row, .ar-step-row').remove();
    arQsa('#ar-step-list .ar-step-num').forEach(function(el, i){ el.textContent = i + 1; });
}

/* ── Photo preview ── */
function arPreviewPhoto(input) {
    var file = input.files[0];
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) {
        arShowAlert('Ukuran foto melebihi 5 MB. Pilih foto yang lebih kecil.');
        input.value = '';
        return;
    }
    arPhotoFile = file;
    var reader = new FileReader();
    reader.onload = function(e) {
        arEl('ar-photo-placeholder').style.display = 'none';
        var prev = arEl('ar-photo-preview');
        prev.src = e.target.result;
        prev.style.display = 'block';
        var rmBtn = arEl('ar-photo-remove');
        if (rmBtn) rmBtn.style.display = 'flex';
    };
    reader.readAsDataURL(file);
}

function arRemovePhoto(e) {
    e.stopPropagation();
    arPhotoFile = null;
    arEl('ar-photo-input').value = '';
    arEl('ar-photo-preview').style.display = 'none';
    arEl('ar-photo-preview').src = '';
    arEl('ar-photo-placeholder').style.display = '';
    var rmBtn = arEl('ar-photo-remove');
    if (rmBtn) rmBtn.style.display = 'none';
    var imgWrap = arEl('ar-preview-img-wrap');
    if (imgWrap) imgWrap.innerHTML = '<span style="font-size:2.5rem">🍽️</span>';
}

/* ── Visibility ── */
function arSetVis(val) {
    arVisibility = val;
    ['public','private'].forEach(function(v) {
        var opt = arEl('vis-' + v);
        var ck  = arEl('vc-'  + v);
        if (v === val) { if(opt) opt.classList.add('active');    if(ck) ck.textContent = '✓'; }
        else           { if(opt) opt.classList.remove('active'); if(ck) ck.textContent = '';  }
    });
}

/* ══════════════════════════════════════════
   COLLECT DATA & SUBMIT
══════════════════════════════════════════ */
function arPublish() {
    arClearErrors();

    var btnPublish = arEl('ar-btn-publish');
    btnPublish.disabled  = true;
    btnPublish.innerHTML = '<span class="ar-spinner"></span> Menyimpan…';

    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        arShowAlert('CSRF token tidak ditemukan. Coba refresh halaman.');
        btnPublish.disabled  = false;
        btnPublish.innerHTML = '🚀 Publish Resep';
        return;
    }

    /* ── meal_type ── */
    var mealChip = document.querySelector('#ar-meal-type .ar-chip.active');
    var mealType = mealChip ? mealChip.dataset.value : '';

    /* ── diet tags ── */
    var dietTags = Array.from(arQsa('#ar-diet-pref .ar-chip.active'))
        .map(function(c){ return c.dataset.value || c.textContent.trim(); });

    var mealLabel = mealType ? (mealType.charAt(0).toUpperCase() + mealType.slice(1)) : '';
    var allTags   = mealLabel ? [mealLabel].concat(dietTags) : dietTags;

    /* ── ingredients ── */
    var ingredients = Array.from(arQsa('#ar-ingredient-list .ar-ingredient-row'))
        .map(function(row) {
            var name = row.querySelector('.ar-ing-name').value.trim();
            var qty  = row.querySelector('.ar-ing-qty').value.trim();
            if (!name) return null;
            return qty ? qty + ' ' + name : name;
        }).filter(Boolean);

    /* ── steps ── */
    var steps = Array.from(arQsa('#ar-step-list .ar-textarea'))
        .map(function(t){ return t.value.trim(); }).filter(Boolean);

    var calories = parseFloat(arEl('ar-n-kcal').value)    || 0;
    var protein  = parseFloat(arEl('ar-n-protein').value) || 0;
    var carbs    = parseFloat(arEl('ar-n-carbs').value)   || 0;
    var fat      = parseFloat(arEl('ar-n-fat').value)     || 0;
    var fiber    = parseFloat(arEl('ar-n-fiber').value)   || 0;

    if (arPhotoFile) {
        /* ── Ada foto: pakai FormData ── */
        var fd = new FormData();
        fd.append('nama_makanan',  arEl('ar-name').value.trim());
        fd.append('description',   arEl('ar-desc').value.trim());
        fd.append('meal_type',     mealType);
        fd.append('difficulty',    arEl('ar-difficulty').value);
        fd.append('cook_time',     arEl('ar-cook-time').value || '');
        fd.append('servings',      arEl('ar-servings').value  || '');
        fd.append('is_public',     arVisibility === 'public' ? '1' : '0');
        fd.append('calories',      calories);
        fd.append('protein',       protein);
        fd.append('carbs',         carbs);
        fd.append('fat',           fat);
        fd.append('fiber',         fiber);
        fd.append('total_nutrisi', calories);
        fd.append('ingredients',   JSON.stringify(ingredients));
        fd.append('cara_masak',    JSON.stringify(steps));
        fd.append('tags',          JSON.stringify(allTags));
        fd.append('image',         arPhotoFile, arPhotoFile.name);

        fetch('/api/recipes', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json'
                /* Content-Type TIDAK di-set manual — biar browser set otomatis dengan boundary */
            },
            body: fd
        })
        .then(function(res){ return res.json().then(function(json){ return {ok: res.ok, json: json}; }); })
        .then(arHandlePublishResponse)
        .catch(arHandlePublishError)
        .finally(function(){
            btnPublish.disabled  = false;
            btnPublish.innerHTML = '🚀 Publish Resep';
        });

    } else {
        /* ── Tanpa foto: pakai JSON body ── */
        var payload = {
            nama_makanan:  arEl('ar-name').value.trim(),
            description:   arEl('ar-desc').value.trim(),
            meal_type:     mealType,
            difficulty:    arEl('ar-difficulty').value,
            cook_time:     arEl('ar-cook-time').value  ? parseInt(arEl('ar-cook-time').value)  : null,
            servings:      arEl('ar-servings').value   ? parseInt(arEl('ar-servings').value)   : null,
            is_public:     arVisibility === 'public',
            calories:      calories,
            protein:       protein,
            carbs:         carbs,
            fat:           fat,
            fiber:         fiber,
            total_nutrisi: calories,
            ingredients:   ingredients,
            cara_masak:    steps,
            tags:          allTags
        };

        fetch('/api/recipes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(function(res){ return res.json().then(function(json){ return {ok: res.ok, json: json}; }); })
        .then(arHandlePublishResponse)
        .catch(arHandlePublishError)
        .finally(function(){
            btnPublish.disabled  = false;
            btnPublish.innerHTML = '🚀 Publish Resep';
        });
    }
}

function arHandlePublishResponse(r) {
    if (r.ok && r.json.success !== false && !r.json.errors) {
        var modal = bootstrap.Modal.getInstance(arEl('modalAddRecipe'));
        if (modal) modal.hide();
        var recipeName = (r.json.data ? r.json.data.nama_makanan : null) || arEl('ar-name').value.trim();
        arShowSuccessToast(recipeName);
        /* Refresh grid setelah publish — fungsi ini diekspos di recipes.blade.php */
        if (typeof window.fetchRecommended === 'function') window.fetchRecommended();
        if (typeof window.fetchPopular     === 'function') window.fetchPopular();
    } else {
        var errors = r.json.errors || {};
        if (errors.nama_makanan) arFieldError('ar-name', 'err-name', errors.nama_makanan[0]);
        var errMeal = arEl('err-meal-type');
        if (errors.meal_type && errMeal) errMeal.textContent = errors.meal_type[0];
        var errIng = arEl('err-ingredients');
        if (errors.ingredients && errIng) errIng.textContent = errors.ingredients[0];
        var errSt = arEl('err-steps');
        if (errors.cara_masak && errSt) errSt.textContent = errors.cara_masak[0];
        arShowAlert(r.json.message || 'Terjadi kesalahan. Silakan coba lagi.');
    }
}

function arHandlePublishError(err) {
    console.error('arPublish error:', err);
    arShowAlert('Gagal terhubung ke server. Periksa koneksi internet kamu.');
}

/* ── Success toast ── */
function arShowSuccessToast(recipeName) {
    var toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;'
        + 'background:#fff;border-radius:14px;padding:14px 18px;'
        + 'box-shadow:0 8px 30px rgba(0,0,0,.18);display:flex;align-items:center;gap:12px;'
        + 'border-left:4px solid #95cd41;max-width:300px;animation:ar-slide-in .3s ease;';
    toast.innerHTML = '<span style="font-size:1.5rem">🎉</span>'
        + '<div><p style="margin:0;font-size:.82rem;font-weight:700;color:#111827;">Resep berhasil dipublish!</p>'
        + '<p style="margin:0;font-size:.72rem;color:#6B7280;">' + (recipeName || '') + '</p></div>';
    var style = document.createElement('style');
    style.textContent = '@keyframes ar-slide-in{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:none}}';
    document.head.appendChild(style);
    document.body.appendChild(toast);
    setTimeout(function() {
        toast.style.transition = 'opacity .4s';
        toast.style.opacity = '0';
        setTimeout(function(){ toast.remove(); }, 400);
    }, 3500);
}

/* ── Reset modal on close ── */
document.addEventListener('DOMContentLoaded', function() {
    var nameEl = arEl('ar-name');
    if (nameEl) nameEl.addEventListener('input', arUpdatePreviewTags);

    var modalEl = arEl('modalAddRecipe');
    if (!modalEl) return;
    modalEl.addEventListener('hidden.bs.modal', function() {
        arCurrentStep = 1;
        arPhotoFile   = null;
        arVisibility  = 'public';

        ['ar-step-1','ar-step-2','ar-step-3'].forEach(function(id, i){
            arEl(id).style.display = i === 0 ? 'block' : 'none';
        });
        [1,2,3].forEach(function(i){
            var el = arEl('step-ind-' + i);
            el.classList.remove('active','done');
            if (i === 1) el.classList.add('active');
        });

        arEl('ar-btn-back').style.display    = 'none';
        arEl('ar-btn-next').style.display    = '';
        arEl('ar-btn-publish').style.display = 'none';
        arEl('ar-btn-publish').disabled      = false;
        arEl('ar-btn-publish').innerHTML     = '🚀 Publish Resep';

        arEl('ar-name').value       = '';
        arEl('ar-desc').value       = '';
        arEl('ar-cook-time').value  = '';
        arEl('ar-servings').value   = '';
        arEl('ar-difficulty').value = '';
        ['ar-n-kcal','ar-n-protein','ar-n-carbs','ar-n-fat','ar-n-fiber'].forEach(function(id){ arEl(id).value = ''; });

        arEl('ar-photo-input').value = '';
        arEl('ar-photo-preview').style.display = 'none';
        arEl('ar-photo-preview').src = '';
        arEl('ar-photo-placeholder').style.display = '';
        var rmBtn = arEl('ar-photo-remove');
        if (rmBtn) rmBtn.style.display = 'none';
        var imgWrap = arEl('ar-preview-img-wrap');
        if (imgWrap) imgWrap.innerHTML = '<span style="font-size:2.5rem">🍽️</span>';

        arQsa('#modalAddRecipe .ar-chip').forEach(function(c){ c.classList.remove('active'); });
        arSetVis('public');
        arEl('ar-preview-name').textContent = 'Nama Resepmu';
        arEl('ar-preview-tags').innerHTML   = '<span class="recipe-tag" style="background:#9CA3AF">Tag</span>';

        arEl('ar-ingredient-list').innerHTML =
            '<div class="ar-ingredient-row">'
            + '<input class="ar-input ar-ing-name" type="text" placeholder="e.g. Chicken breast">'
            + '<input class="ar-input ar-ing-qty" type="text" placeholder="200g">'
            + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>'
            + '</div>'
            + '<div class="ar-ingredient-row">'
            + '<input class="ar-input ar-ing-name" type="text" placeholder="e.g. Olive oil">'
            + '<input class="ar-input ar-ing-qty" type="text" placeholder="2 tbsp">'
            + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>'
            + '</div>';

        arEl('ar-step-list').innerHTML =
            '<div class="ar-step-row">'
            + '<div class="ar-step-num">1</div>'
            + '<textarea class="ar-textarea ar-flex-1" rows="2" placeholder="e.g. Marinate chicken…"></textarea>'
            + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>'
            + '</div>'
            + '<div class="ar-step-row">'
            + '<div class="ar-step-num">2</div>'
            + '<textarea class="ar-textarea ar-flex-1" rows="2" placeholder="e.g. Heat grill…"></textarea>'
            + '<button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>'
            + '</div>';

        arClearErrors();
    });
});
</script>
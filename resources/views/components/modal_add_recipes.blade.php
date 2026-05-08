{{-- ================================================================
     MODAL ADD RECIPE — NutriPlan
     Include di recipes.blade.php atau layout
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
                        <p class="m-0" style="font-size:0.72rem; color:#6B7280;">Bagikan resep favoritmu ke komunitas
                            NutriPlan</p>
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
                        </div>
                        <input type="file" id="ar-photo-input" accept="image/*" style="display:none"
                            onchange="arPreviewPhoto(this)">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <label class="ar-label">Nama Resep <span class="ar-required">*</span></label>
                            <input class="ar-input" type="text" placeholder="e.g. Grilled Salmon with Lemon Butter"
                                id="ar-name">
                        </div>
                        <div class="col-12">
                            <label class="ar-label">Deskripsi Singkat</label>
                            <textarea class="ar-textarea" placeholder="Ceritakan sedikit tentang resep ini…" id="ar-desc" rows="2"></textarea>
                        </div>
                    </div>

                    {{-- Meal type + Preference tags --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="ar-label">Tipe Meal <span class="ar-required">*</span></label>
                            <div class="ar-chip-group" id="ar-meal-type">
                                @foreach (['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Desserts', 'Drinks'] as $t)
                                    <span class="ar-chip"
                                        onclick="arToggleChip(this,'meal-type')">{{ $t }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="ar-label">Preferensi Diet</label>
                            <div class="ar-chip-group" id="ar-diet-pref">
                                @foreach (['Vegan', 'Keto', 'Low-Carb', 'High-Protein', 'Gluten-Free', 'Quick Meal'] as $p)
                                    <span class="ar-chip"
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
                                <input class="ar-input" type="number" placeholder="30" min="1"
                                    id="ar-cook-time">
                                <span class="ar-unit">min</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="ar-label">Porsi</label>
                            <div class="ar-input-unit-wrap">
                                <input class="ar-input" type="number" placeholder="2" min="1"
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
                            <button type="button" class="ar-btn-add-row" onclick="arAddIngredient()">+ Tambah
                                Bahan</button>
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
                    </div>

                    {{-- Steps --}}
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="ar-label m-0">Langkah Memasak <span class="ar-required">*</span></label>
                            <button type="button" class="ar-btn-add-row" onclick="arAddStep()">+ Tambah
                                Langkah</button>
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
                    </div>

                </div>

                {{-- ════ STEP 3 — Nutrisi & Publish ════ --}}
                <div id="ar-step-3" style="display:none;">

                    <p class="ar-section-note mb-3">
                        💡 Info nutrisi bersifat opsional, tapi membantu pengguna lain memilih resep yang sesuai target
                        mereka.
                    </p>

                    <div class="row g-2 mb-4">
                        @foreach ([['Calories', 'ar-n-kcal', 'kcal', '#ea5c2b'], ['Protein', 'ar-n-protein', 'g', '#6ab32b'], ['Carbs', 'ar-n-carbs', 'g', '#FE9A00'], ['Fat', 'ar-n-fat', 'g', '#f97316'], ['Fiber', 'ar-n-fiber', 'g', '#2B7FFF']] as $n)
                            <div class="col-6 col-sm-4">
                                <label class="ar-label"
                                    style="color:{{ $n[3] }}; font-weight:800;">{{ $n[0] }}</label>
                                <div class="ar-input-unit-wrap">
                                    <input class="ar-input" type="number" placeholder="0" min="0"
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
                            <span
                                style="font-size:0.72rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.05em;">Preview
                                kartu resepmu</span>
                        </div>
                        <div class="recipe-card" style="max-width:200px;">
                            <div
                                style="height:90px; background:linear-gradient(135deg,rgba(234,92,43,0.15),rgba(149,205,65,0.15)); display:flex; align-items:center; justify-content:center; font-size:2.5rem;">
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
                <div class="ms-auto d-flex gap-2">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="ar-btn-next" id="ar-btn-next" onclick="arNextStep()">Lanjut
                        →</button>
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
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, #ea5c2b, #f97316);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(234, 92, 43, 0.3);
    }

    .ar-body {
        padding: 20px 24px;
    }

    .ar-footer {
        border-top: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 12px 22px 16px;
        gap: 8px;
    }

    /* Steps indicator */
    .ar-steps {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .ar-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        flex: 0 0 auto;
    }

    .ar-step-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #E5E7EB;
        color: #9CA3AF;
        font-size: 0.75rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .ar-step.active .ar-step-circle {
        background: var(--warna-oren);
        color: #fff;
        box-shadow: 0 4px 10px rgba(234, 92, 43, 0.35);
    }

    .ar-step.done .ar-step-circle {
        background: var(--warna-ijo);
        color: #fff;
        box-shadow: 0 4px 10px rgba(149, 205, 65, 0.3);
    }

    .ar-step-label {
        font-size: 0.62rem;
        font-weight: 600;
        color: #9CA3AF;
        white-space: nowrap;
        transition: color 0.3s;
    }

    .ar-step.active .ar-step-label {
        color: var(--warna-oren);
    }

    .ar-step.done .ar-step-label {
        color: #6ab32b;
    }

    .ar-step-line {
        flex: 1;
        height: 2px;
        background: #E5E7EB;
        margin: 0 6px;
        margin-bottom: 18px;
        border-radius: 2px;
        transition: background 0.3s;
    }

    /* Photo upload */
    .ar-photo-upload {
        width: 100%;
        height: 160px;
        border: 2px dashed #D1D5DB;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #FAFAFA;
        transition: all 0.2s ease;
        overflow: hidden;
        position: relative;
    }

    .ar-photo-upload:hover {
        border-color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.04);
    }

    .ar-photo-placeholder {
        text-align: center;
    }

    .ar-photo-icon {
        font-size: 2rem;
        margin-bottom: 6px;
    }

    .ar-photo-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin: 0;
    }

    .ar-photo-hint {
        font-size: 0.65rem;
        color: #9CA3AF;
        margin: 2px 0 0;
    }

    /* Label & inputs */
    .ar-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #374151;
        display: block;
        margin-bottom: 5px;
    }

    .ar-required {
        color: var(--warna-oren);
    }

    .ar-input {
        width: 100%;
        border-radius: 10px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.4rem 0.7rem;
        font-size: 0.82rem;
        color: #374151;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .ar-input:focus {
        border-color: var(--warna-ijo);
        box-shadow: 0 0 0 3px rgba(149, 205, 65, 0.12);
        background: #fff;
    }

    .ar-select {
        appearance: none;
        cursor: pointer;
    }

    .ar-textarea {
        width: 100%;
        border-radius: 10px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.45rem 0.7rem;
        font-size: 0.78rem;
        color: #374151;
        outline: none;
        resize: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .ar-textarea:focus {
        border-color: var(--warna-ijo);
        box-shadow: 0 0 0 3px rgba(149, 205, 65, 0.12);
        background: #fff;
    }

    .ar-input-unit-wrap {
        position: relative;
    }

    .ar-unit {
        position: absolute;
        right: 0.7rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.7rem;
        color: #9CA3AF;
        pointer-events: none;
    }

    /* Chips */
    .ar-chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .ar-chip {
        background: #F3F4F6;
        border: 1.5px solid #E5E7EB;
        border-radius: 50px;
        padding: 3px 10px;
        font-size: 0.68rem;
        font-weight: 600;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.15s;
    }

    .ar-chip:hover {
        border-color: var(--warna-oren);
        color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.06);
    }

    .ar-chip.active {
        border-color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.10);
        color: var(--warna-oren);
        font-weight: 700;
    }

    /* Ingredient rows */
    .ar-ingredient-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .ar-ing-name {
        flex: 2;
    }

    .ar-ing-qty {
        flex: 1;
    }

    .ar-step-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 8px;
    }

    .ar-step-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--warna-oren), #f97316);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 6px;
        box-shadow: 0 3px 8px rgba(234, 92, 43, 0.28);
    }

    .ar-flex-1 {
        flex: 1;
    }

    .ar-remove-btn {
        width: 24px;
        height: 24px;
        border: 1.5px solid #FECACA;
        background: #FFF5F5;
        color: #EF4444;
        border-radius: 50%;
        font-size: 1rem;
        line-height: 1;
        cursor: pointer;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
        margin-top: 4px;
    }

    .ar-remove-btn:hover {
        background: #FEE2E2;
        border-color: #EF4444;
    }

    .ar-btn-add-row {
        border: none;
        background: transparent;
        color: var(--warna-ijo);
        font-size: 0.72rem;
        font-weight: 700;
        cursor: pointer;
        padding: 0;
        transition: color 0.15s;
    }

    .ar-btn-add-row:hover {
        color: #6ab32b;
    }

    /* Visibility */
    .ar-visibility-group {
        display: flex;
        gap: 8px;
    }

    .ar-vis-option {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        cursor: pointer;
        transition: all 0.18s;
    }

    .ar-vis-option.active {
        border-color: var(--warna-ijo);
        background: rgba(149, 205, 65, 0.07);
        box-shadow: 0 3px 10px rgba(149, 205, 65, 0.18);
    }

    .ar-vis-icon {
        font-size: 1.3rem;
    }

    .ar-vis-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .ar-vis-sub {
        font-size: 0.62rem;
        color: #9CA3AF;
        margin: 0;
    }

    .ar-vis-check {
        margin-left: auto;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1.5px solid #E5E7EB;
        background: #F3F4F6;
        color: transparent;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }

    .ar-vis-option.active .ar-vis-check {
        background: var(--warna-ijo);
        border-color: var(--warna-ijo);
        color: #fff;
    }

    /* Preview */
    .ar-preview-card {
        background: rgba(149, 205, 65, 0.06);
        border: 1.5px dashed rgba(149, 205, 65, 0.4);
        border-radius: 14px;
        padding: 12px 14px;
    }

    .ar-section-note {
        background: rgba(234, 92, 43, 0.07);
        border: 1px solid rgba(234, 92, 43, 0.18);
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.75rem;
        color: #374151;
        margin: 0;
    }

    /* Footer buttons */
    .ar-btn-back {
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        color: #6B7280;
        border-radius: 50px;
        padding: 0.45rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }

    .ar-btn-back:hover {
        background: #F3F4F6;
    }

    .ar-btn-next {
        border: none;
        background: linear-gradient(135deg, #ea5c2b, #f97316);
        color: #fff;
        border-radius: 50px;
        padding: 0.45rem 1.3rem;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(234, 92, 43, 0.35);
        transition: all 0.2s;
    }

    .ar-btn-next:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .ar-btn-publish {
        border: none;
        background: linear-gradient(135deg, #95cd41, #6ab32b);
        color: #fff;
        border-radius: 50px;
        padding: 0.45rem 1.3rem;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(149, 205, 65, 0.38);
        transition: all 0.2s;
    }

    .ar-btn-publish:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }
</style>


{{-- ── Add Recipe JS ── --}}
<script>
    let arCurrentStep = 1;

    function arNextStep() {
        if (arCurrentStep < 3) {
            document.getElementById('step-ind-' + arCurrentStep).classList.remove('active');
            document.getElementById('step-ind-' + arCurrentStep).classList.add('done');
            document.getElementById('ar-step-' + arCurrentStep).style.display = 'none';
            arCurrentStep++;
            document.getElementById('ar-step-' + arCurrentStep).style.display = 'block';
            document.getElementById('step-ind-' + arCurrentStep).classList.add('active');
            document.getElementById('ar-btn-back').style.display = '';
            if (arCurrentStep === 3) {
                document.getElementById('ar-btn-next').style.display = 'none';
                document.getElementById('ar-btn-publish').style.display = '';
            }
        }
    }

    function arPrevStep() {
        if (arCurrentStep > 1) {
            document.getElementById('ar-step-' + arCurrentStep).style.display = 'none';
            document.getElementById('step-ind-' + arCurrentStep).classList.remove('active');
            arCurrentStep--;
            document.getElementById('ar-step-' + arCurrentStep).style.display = 'block';
            document.getElementById('step-ind-' + arCurrentStep).classList.remove('done');
            document.getElementById('step-ind-' + arCurrentStep).classList.add('active');
            document.getElementById('ar-btn-next').style.display = '';
            document.getElementById('ar-btn-publish').style.display = 'none';
            if (arCurrentStep === 1) document.getElementById('ar-btn-back').style.display = 'none';
        }
    }

    function arToggleChip(el, group) {
        // For meal type: single select
        if (group === 'meal-type') {
            document.querySelectorAll('#ar-meal-type .ar-chip').forEach(c => c.classList.remove('active'));
        }
        el.classList.toggle('active');
        arUpdatePreviewTags();
    }

    function arUpdatePreviewTags() {
        const name = document.getElementById('ar-name').value || 'Nama Resepmu';
        document.getElementById('ar-preview-name').textContent = name;
        const active = document.querySelectorAll('#ar-meal-type .ar-chip.active, #ar-diet-pref .ar-chip.active');
        const container = document.getElementById('ar-preview-tags');
        container.innerHTML = '';
        const colors = {
            'Breakfast': '#95CD41',
            'Lunch': '#EA5C2B',
            'Dinner': '#374151',
            'Snacks': '#FBBF24',
            'Desserts': '#A78BFA',
            'Drinks': '#2B7FFF',
            'Vegan': '#2B7FFF',
            'Keto': '#6B7280',
            'Low-Carb': '#FBBF24',
            'High-Protein': '#EA5C2B',
            'Gluten-Free': '#95CD41',
            'Quick Meal': '#95CD41'
        };
        active.forEach(chip => {
            const span = document.createElement('span');
            span.className = 'recipe-tag';
            span.style.background = colors[chip.textContent] || '#9CA3AF';
            span.textContent = chip.textContent;
            container.appendChild(span);
        });
        if (!active.length) container.innerHTML = '<span class="recipe-tag" style="background:#9CA3AF">Tag</span>';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('ar-name');
        if (nameInput) nameInput.addEventListener('input', arUpdatePreviewTags);
    });

    function arAddIngredient() {
        const list = document.getElementById('ar-ingredient-list');
        const row = document.createElement('div');
        row.className = 'ar-ingredient-row';
        row.innerHTML = `<input class="ar-input ar-ing-name" type="text" placeholder="Nama bahan">
                     <input class="ar-input ar-ing-qty" type="text" placeholder="Jumlah">
                     <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>`;
        list.appendChild(row);
    }

    function arAddStep() {
        const list = document.getElementById('ar-step-list');
        const num = list.children.length + 1;
        const row = document.createElement('div');
        row.className = 'ar-step-row';
        row.innerHTML = `<div class="ar-step-num">${num}</div>
                     <textarea class="ar-textarea ar-flex-1" rows="2" placeholder="Langkah ${num}…"></textarea>
                     <button type="button" class="ar-remove-btn" onclick="arRemoveRow(this)">×</button>`;
        list.appendChild(row);
    }

    function arRemoveRow(btn) {
        btn.closest('.ar-ingredient-row, .ar-step-row').remove();
        // Renumber steps
        document.querySelectorAll('#ar-step-list .ar-step-num').forEach((el, i) => el.textContent = i + 1);
    }

    function arPreviewPhoto(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('ar-photo-placeholder').style.display = 'none';
            const prev = document.getElementById('ar-photo-preview');
            prev.src = e.target.result;
            prev.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function arSetVis(val) {
        ['public', 'private'].forEach(v => {
            const opt = document.getElementById('vis-' + v);
            const ck = document.getElementById('vc-' + v);
            if (v === val) {
                opt.classList.add('active');
                ck.textContent = '✓';
            } else {
                opt.classList.remove('active');
                ck.textContent = '';
            }
        });
    }

    function arPublish() {
        // Hook up to backend
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAddRecipe'));
        if (modal) modal.hide();
        // TODO: submit form via AJAX
        alert('Resep berhasil dipublish! 🎉');
    }

    // Reset on close
    document.getElementById('modalAddRecipe').addEventListener('hidden.bs.modal', function() {
        arCurrentStep = 1;
        ['ar-step-1', 'ar-step-2', 'ar-step-3'].forEach((id, i) => {
            document.getElementById(id).style.display = i === 0 ? 'block' : 'none';
        });
        [1, 2, 3].forEach(i => {
            const el = document.getElementById('step-ind-' + i);
            el.classList.remove('active', 'done');
            if (i === 1) el.classList.add('active');
        });
        document.getElementById('ar-btn-back').style.display = 'none';
        document.getElementById('ar-btn-next').style.display = '';
        document.getElementById('ar-btn-publish').style.display = 'none';
    });
</script>
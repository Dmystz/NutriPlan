@extends('layout.layout')

@section('title', 'Recipes')

@section('content')

<div class="col-12 py-2">
    <div class="row py-0 g-3">

        {{-- ── SIDEBAR ── --}}
        <div class="col-12 col-md-3 col-xl-2">
            <div class="recipes-sidebar">
                <input type="text" id="searchInput" class="filter-search-box mb-2"
                    placeholder="Search by recipes and more">

                <div class="filter-group-title">
                    <span>🍽 Meal Type</span> <span>›</span>
                </div>
                @php $mealTypes = ['Breakfast','Lunch','Dinner','Snacks','Desserts','Drinks']; @endphp
                @foreach ($mealTypes as $t)
                    <div class="filter-item filter-meal-type {{ $t === 'Breakfast' ? 'active' : '' }}"
                         data-value="{{ strtolower($t) }}">
                        <span class="filter-dot {{ $t === 'Breakfast' ? 'oren' : '' }}"></span>{{ $t }}
                    </div>
                @endforeach

                <div class="filter-group-title" style="background:var(--warna-oren); color:#fff;">
                    <span>⚙ Preferences</span> <span>›</span>
                </div>
                @php
                    $prefs = ['Vegetarian','Vegan','Low-Carb','Gluten-Free','Keto',
                              'Dairy-Free','High-Protein','Low-Calorie','Quick Meals'];
                @endphp
                @foreach ($prefs as $p)
                    <div class="filter-item filter-pref" data-value="{{ $p }}">
                        <span class="filter-dot"></span>{{ $p }}
                    </div>
                @endforeach

                <div class="mt-2">
                    <button id="btnResetFilter" class="btn btn-sm w-100"
                            style="border:1px solid #ddd;font-size:.75rem;color:#6B7280;">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- ── MAIN CONTENT ── --}}
        <div class="col-12 col-md-9 col-xl-10">

            <div class="d-flex gap-3 mb-3 align-items-stretch">
                <div class="recipes-hero-banner flex-grow-1">
                    <h5 class="mb-1">✨ Got a Recipes That Rocks?</h5>
                    <p class="mb-2">Share it &amp; Plan!</p>
                    <a href="#" class="btn-add-recipe"
                       data-bs-toggle="modal" data-bs-target="#modalAddRecipe">
                        + Add Recipes
                    </a>
                </div>
                <a href="#" class="btn-your-recipe" id="btnYourRecipes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 31 31" fill="none">
                        <path d="M15.5 21.9583H21.9583C22.6717 21.9583 23.25 21.38 23.25 20.6667V7.75C23.25 6.32327 22.0934 5.16667 20.6667 5.16667L11.625 5.16667C9.4849 5.16667 7.75 6.90157 7.75 9.04167L7.75 23.8958" stroke="white" stroke-width="1.8"/>
                        <path d="M22.4997 25.8333C22.5477 25.8333 22.5789 25.7826 22.5583 25.7393C21.9617 24.4852 21.9739 23.2312 22.5948 21.9771C22.5991 21.9685 22.5929 21.9583 22.5833 21.9583L9.6875 21.9583C8.61745 21.9583 7.75 22.8258 7.75 23.8958C7.75 24.9659 8.61745 25.8333 9.6875 25.8333L22.4997 25.8333Z" stroke="white" stroke-width="1.8"/>
                        <path d="M14.2083 5.425C14.2083 5.28232 14.3239 5.16666 14.4666 5.16666H19.1166C19.2593 5.16666 19.3749 5.28232 19.3749 5.425V11.0954C19.3749 11.3106 19.1272 11.4314 18.9575 11.2989L16.9506 9.73102C16.8572 9.65801 16.726 9.65801 16.6325 9.73102L14.6256 11.2989C14.456 11.4314 14.2083 11.3106 14.2083 11.0954V5.425Z" stroke="white" stroke-width="1.8"/>
                    </svg>
                    Your Recipes
                </a>
            </div>

            {{-- Recommended --}}
            <div class="section-title" id="sectionRecommended">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M9 5H7C5.895 5 5 5.895 5 7V19C5 20.105 5.895 21 7 21H17C18.105 21 19 20.105 19 19V7C19 5.895 18.105 5 17 5H15M9 5C9 5.552 9.448 6 10 6H14C14.552 6 15 5.552 15 5M9 5C9 4.448 9.448 4 10 4H14C14.552 4 15 4.448 15 5" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Recommended
            </div>
            <div class="row py-0 g-3 mb-3" id="gridRecommended">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="recipe-card skeleton-card">
                            <div class="skeleton-img"></div>
                            <div class="recipe-card-body">
                                <div class="skeleton-line w-75 mb-2"></div>
                                <div class="skeleton-line w-100 mb-1"></div>
                                <div class="skeleton-line w-50"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Popular --}}
            <div class="section-title" id="sectionPopular">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5C5.754 5 4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="#374151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Popular
            </div>
            <div class="row py-0 g-3 mb-4" id="gridPopular">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="recipe-card skeleton-card">
                            <div class="skeleton-img"></div>
                            <div class="recipe-card-body">
                                <div class="skeleton-line w-75 mb-2"></div>
                                <div class="skeleton-line w-100 mb-1"></div>
                                <div class="skeleton-line w-50"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Search / Filter Results --}}
            <div id="searchResultsSection" style="display:none;">
                <div class="section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <span id="searchResultsLabel">Results</span>
                </div>
                <div class="row py-0 g-3 mb-4" id="gridSearch"></div>
                <div id="emptyState" class="text-center py-5" style="display:none;">
                    <div style="font-size:3rem;">🍽️</div>
                    <p class="text-muted mt-2">No recipes found. Try a different search.</p>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     MODAL — Recipe Detail
══════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalRecipeDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content recipe-detail-modal">

            {{-- ✅ CLOSE BUTTON — position:absolute, z-index tinggi, DI LUAR image wrapper --}}
            <button type="button"
                    class="recipe-modal-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>

            {{-- Hero Image --}}
            <div class="recipe-detail-hero">
                <img id="detailImage"
                     src="{{ asset('img/meal1_home.png') }}"
                     alt="recipe"
                     onerror="this.src='{{ asset('img/meal1_home.png') }}'">
                <div class="recipe-detail-overlay">
                    <div id="detailTags" class="d-flex gap-1 flex-wrap mb-2"></div>
                    <h5 id="detailTitle" class="detail-recipe-title"></h5>
                    <div id="detailMeta" class="d-flex gap-2 flex-wrap mt-2"></div>
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body p-0">

                {{-- Loading --}}
                <div id="detailLoading" class="text-center py-5">
                    <div class="spinner-border spinner-border-sm" style="color:#EA5C2B;" role="status"></div>
                    <p class="text-muted small mt-2 mb-0">Memuat resep...</p>
                </div>

                {{-- Content --}}
                <div id="detailContent" style="display:none;" class="recipe-detail-content">

                    <p id="detailDesc" class="detail-desc"></p>

                    {{-- Nutrition --}}
                    <div id="detailNutrition" class="detail-nutrition-row"></div>

                    <hr class="detail-divider">

                    {{-- Bahan-bahan --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="detail-section-title mb-0">🧂 Ingredients</h6>
                            <span id="detailServings" class="detail-servings-badge"></span>
                        </div>
                        <ul id="detailIngredients" class="detail-ingredients-list"></ul>
                    </div>

                    <hr class="detail-divider">

                    {{-- Cara Masak --}}
                    <div class="pb-2">
                        <h6 class="detail-section-title mb-3">👨‍🍳 How To Prepare</h6>
                        <ol id="detailSteps" class="detail-steps-list"></ol>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Modal Your Recipes ── --}}
<div class="modal fade" id="modalYourRecipes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">📖 Your Recipes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3" id="gridYourRecipes">
                    <div class="text-center text-muted py-5">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal_add_recipes')

{{-- ══════════════════════════ STYLES ══════════════════════════ --}}
<style>
/* ── Skeleton ── */
.skeleton-card { pointer-events:none; }
.skeleton-img  { width:100%;height:140px;
    background:linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%);
    background-size:200% 100%;animation:shimmer 1.4s infinite;border-radius:10px 10px 0 0; }
.skeleton-line { height:11px;
    background:linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%);
    background-size:200% 100%;animation:shimmer 1.4s infinite;border-radius:6px; }
@keyframes shimmer { 0%{background-position:200% 0}100%{background-position:-200% 0} }

/* ── Recipe card hover ── */
.recipe-card { cursor:pointer;transition:transform .18s,box-shadow .18s; }
.recipe-card:hover { transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.13); }

/* ══════════════════════════════════
   RECIPE DETAIL MODAL
══════════════════════════════════ */
.recipe-detail-modal {
    border:none;
    border-radius:20px;
    overflow:hidden;
}

/* ✅ Close button — absolute, z-index 1070 (di atas segalanya) */
.recipe-modal-close {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 1070;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,.92);
    color: #1F2937;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 12px rgba(0,0,0,.22);
    transition: transform .15s, background .15s;
    padding: 0;
    line-height: 1;
}
.recipe-modal-close:hover {
    background: #fff;
    transform: scale(1.1);
}
.recipe-modal-close:focus { outline:none; }

/* Hero */
.recipe-detail-hero {
    position: relative;
    height: 210px;
    overflow: hidden;
    flex-shrink: 0;
}
.recipe-detail-hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
.recipe-detail-overlay {
    position: absolute;
    inset: 0;
    /* Gradient dari bawah ke atas — teks terbaca, gambar tetap terlihat */
    background: linear-gradient(
        to top,
        rgba(0,0,0,.78) 0%,
        rgba(0,0,0,.35) 50%,
        rgba(0,0,0,0) 100%
    );
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 18px 20px 16px;
}
.detail-recipe-title {
    color: #fff;
    font-size: 1.15rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 1px 4px rgba(0,0,0,.5);
    line-height: 1.3;
}

/* Meta pills inside hero */
.detail-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 20px;
    padding: .2rem .6rem;
    font-size: .72rem;
    color: #fff;
    font-weight: 500;
}

/* Content wrapper */
.recipe-detail-content {
    padding: 18px 22px 24px;
}
.detail-desc {
    color: #6B7280;
    font-size: .875rem;
    line-height: 1.7;
    margin-bottom: 1rem;
}

/* Nutrition */
.detail-nutrition-row {
    display: flex;
    gap: .5rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
}
.detail-nut-badge {
    flex: 1;
    min-width: 60px;
    background: #FFF9F5;
    border: 1px solid #FFE5D0;
    border-radius: 12px;
    padding: .55rem .5rem .4rem;
    text-align: center;
}
.detail-nut-badge .nv { font-size:.95rem;font-weight:700;color:#EA5C2B;line-height:1; }
.detail-nut-badge .nl { font-size:.62rem;color:#9CA3AF;margin-top:3px;line-height:1.2; }

.detail-divider { border-color:#F3F4F6;margin:1.1rem 0; }
.detail-section-title { font-size:.9rem;font-weight:700;color:#111827; }
.detail-servings-badge {
    font-size:.72rem;font-weight:600;
    background:#FFF3E0;color:#EA5C2B;
    border-radius:20px;padding:.2rem .65rem;
}

/* Ingredients */
.detail-ingredients-list { list-style:none;padding:0;margin:0; }
.detail-ingredients-list li {
    display:flex;align-items:flex-start;gap:.6rem;
    padding:.45rem 0;
    border-bottom:1px solid #F9FAFB;
    font-size:.875rem;color:#374151;line-height:1.55;
}
.detail-ingredients-list li:last-child { border-bottom:none; }
.ing-bullet {
    width:8px;height:8px;border-radius:50%;
    background:#EA5C2B;margin-top:.38rem;flex-shrink:0;
}

/* Steps */
.detail-steps-list { list-style:none;padding:0;margin:0; }
.detail-steps-list li {
    display:flex;align-items:flex-start;gap:.7rem;
    padding:.6rem 0;
    border-bottom:1px solid #F9FAFB;
    font-size:.875rem;color:#374151;line-height:1.6;
}
.detail-steps-list li:last-child { border-bottom:none; }
.step-num {
    flex-shrink:0;width:26px;height:26px;border-radius:50%;
    background:#EA5C2B;color:#fff;
    font-size:.7rem;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    margin-top:.1rem;
}
</style>

{{-- ══════════════════════════ SCRIPT ══════════════════════════ --}}
<script>
(function () {
    const $id = id => document.getElementById(id);

    /* ── Utilities ── */
    function escHtml(s) {
        return String(s ?? '')
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    function truncate(s, n) {
        s = String(s ?? '');
        return s.length > n ? s.slice(0,n)+'…' : s;
    }
    function capitalize(s) {
        s = String(s ?? '');
        return s.charAt(0).toUpperCase() + s.slice(1);
    }

    /**
     * Safely parse to array.
     * Handles: already array | JSON string | double-encoded JSON string | null
     */
    function safeArray(val) {
        if (Array.isArray(val)) return val;
        if (!val && val !== 0) return [];
        if (typeof val === 'string') {
            try {
                let p = JSON.parse(val);
                if (typeof p === 'string') p = JSON.parse(p); // double-encoded
                return Array.isArray(p) ? p : [];
            } catch { return []; }
        }
        return [];
    }

    function tagColor(tag) {
        const m = {
            Breakfast:'#95CD41',Lunch:'#EA5C2B',Dinner:'#2B7FFF',
            Snacks:'#FBBF24',Desserts:'#A78BFA',Drinks:'#34D399',
            Vegan:'#2B7FFF',Vegetarian:'#95CD41','Low-Carb':'#FBBF24',
            'Gluten-Free':'#F472B6',Keto:'#8B5CF6','Dairy-Free':'#06B6D4',
            'High-Protein':'#EA5C2B','Low-Calorie':'#34D399','Quick Meals':'#95CD41',
        };
        return m[tag] || '#6B7280';
    }

    /* ── Card builder ── */
    function buildCard(r) {
        const tags = safeArray(r.tags).slice(0,2)
            .map(t=>`<span class="recipe-tag" style="background:${tagColor(t)}">${escHtml(t)}</span>`)
            .join('');
        const timeTag = r.cook_time
            ? `<span class="recipe-tag" style="background:#6B7280">#${r.cook_time}min</span>`:'';
        const img = r.image_url ?? '{{ asset("img/meal1_home.png") }}';
        return `
        <div class="col-6 col-md-4 col-xl-3">
          <div class="recipe-card" onclick="window.openDetail(${r.id})">
            <img src="${escHtml(img)}" alt="${escHtml(r.nama_makanan)}"
                 onerror="this.src='{{ asset('img/meal1_home.png') }}'">
            <div class="recipe-card-body">
              <div class="d-flex justify-content-between align-items-start mb-1">
                <p class="recipe-card-title mb-0">${escHtml(r.nama_makanan)}</p>
                <span class="recipe-card-menu">⋮</span>
              </div>
              <p class="recipe-card-desc">${escHtml(truncate(r.description??'',90))}</p>
              <div class="d-flex gap-1 flex-wrap">${tags}${timeTag}</div>
            </div>
          </div>
        </div>`;
    }

    function populateGrid(gridId, data) {
        const el = $id(gridId);
        el.innerHTML = (!data || data.length===0)
            ? '<p class="text-muted small ps-2 py-2">Belum ada resep.</p>'
            : data.map(buildCard).join('');
    }

    /* ── API calls ── */
    async function fetchRecommended() {
        try {
            const r = await fetch('/api/recipes/recommended?limit=4');
            if (!r.ok) throw new Error(r.status);
            populateGrid('gridRecommended', (await r.json()).data ?? []);
        } catch {
            $id('gridRecommended').innerHTML =
                '<p class="text-muted small ps-2">Gagal memuat. <a href="#" onclick="location.reload()">Refresh</a></p>';
        }
    }

    async function fetchPopular() {
        try {
            const r = await fetch('/api/recipes/popular?limit=4');
            if (!r.ok) throw new Error(r.status);
            populateGrid('gridPopular', (await r.json()).data ?? []);
        } catch {
            $id('gridPopular').innerHTML =
                '<p class="text-muted small ps-2">Gagal memuat. <a href="#" onclick="location.reload()">Refresh</a></p>';
        }
    }

    async function fetchFiltered() {
        const params = new URLSearchParams();
        if (activeMealType)    params.set('meal_type', activeMealType);
        if (activeTags.length) params.set('tags', activeTags.join(','));
        const kw = $id('searchInput').value.trim();
        if (kw) params.set('search', kw);
        try {
            const r    = await fetch('/api/recipes?'+params);
            const data = (await r.json()).data ?? [];
            populateGrid('gridSearch', data);
            $id('emptyState').style.display = data.length===0 ? 'block':'none';
        } catch {
            $id('gridSearch').innerHTML = '<p class="text-muted small ps-2">Gagal memuat.</p>';
        }
    }

    /* ── Search mode ── */
    let activeMealType=null, activeTags=[], searchTimeout=null;

    const HIDEABLE = ['sectionRecommended','gridRecommended','sectionPopular','gridPopular'];

    function enterSearchMode(label) {
        $id('searchResultsSection').style.display='block';
        $id('searchResultsLabel').textContent=label;
        HIDEABLE.forEach(id=>{ $id(id).style.display='none'; });
    }
    function exitSearchMode() {
        $id('searchResultsSection').style.display='none';
        $id('emptyState').style.display='none';
        HIDEABLE.forEach(id=>{ $id(id).style.display=''; });
    }
    function applyFilter() {
        const hasFilter = activeMealType || activeTags.length || $id('searchInput').value.trim();
        if (hasFilter) {
            enterSearchMode(activeMealType ? capitalize(activeMealType)+' Recipes' : 'Filter Results');
            fetchFiltered();
        } else { exitSearchMode(); }
    }

    document.querySelectorAll('.filter-meal-type').forEach(el=>{
        el.addEventListener('click', function(){
            const val = this.dataset.value;
            document.querySelectorAll('.filter-meal-type').forEach(e=>{
                e.classList.remove('active');
                e.querySelector('.filter-dot').classList.remove('oren');
            });
            activeMealType = (activeMealType===val) ? null : val;
            if (activeMealType) {
                this.classList.add('active');
                this.querySelector('.filter-dot').classList.add('oren');
            }
            applyFilter();
        });
    });

    document.querySelectorAll('.filter-pref').forEach(el=>{
        el.addEventListener('click', function(){
            const val = this.dataset.value;
            if (activeTags.includes(val)) {
                activeTags = activeTags.filter(t=>t!==val);
                this.classList.remove('active');
                this.querySelector('.filter-dot').classList.remove('oren');
            } else {
                activeTags.push(val);
                this.classList.add('active');
                this.querySelector('.filter-dot').classList.add('oren');
            }
            applyFilter();
        });
    });

    $id('btnResetFilter').addEventListener('click',()=>{
        activeMealType=null; activeTags=[];
        $id('searchInput').value='';
        document.querySelectorAll('.filter-item').forEach(e=>{
            e.classList.remove('active');
            e.querySelector('.filter-dot')?.classList.remove('oren');
        });
        exitSearchMode();
    });

    $id('searchInput').addEventListener('input',()=>{
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilter, 350);
    });

    /* ── Your Recipes ── */
    $id('btnYourRecipes').addEventListener('click', async e=>{
        e.preventDefault();
        new bootstrap.Modal($id('modalYourRecipes')).show();
        try {
            const r = await fetch('/api/recipes/mine');
            const data = (await r.json()).data ?? [];
            const grid = $id('gridYourRecipes');
            grid.innerHTML = data.length===0
                ? '<div class="col-12 text-center text-muted py-5">Kamu belum punya resep. Yuk tambah!</div>'
                : data.map(buildCard).join('');
        } catch {
            $id('gridYourRecipes').innerHTML=
                '<div class="col-12 text-center text-muted py-4">Gagal memuat.</div>';
        }
    });

    /* ══════════════════════════════════
       OPEN DETAIL MODAL
    ══════════════════════════════════ */
    window.openDetail = async function(id) {
        const modalEl = $id('modalRecipeDetail');
        const modal   = bootstrap.Modal.getOrCreateInstance(modalEl);

        // Reset
        $id('detailLoading').style.display  = 'block';
        $id('detailContent').style.display  = 'none';
        $id('detailTitle').textContent      = '';
        $id('detailTags').innerHTML         = '';
        $id('detailMeta').innerHTML         = '';
        $id('detailImage').src              = '{{ asset("img/meal1_home.png") }}';
        modal.show();

        try {
            const res  = await fetch(`/api/recipes/${id}`);
            if (!res.ok) throw new Error('HTTP '+res.status);
            const r    = (await res.json()).data;

            /* Image */
            $id('detailImage').src = r.image_url ?? '{{ asset("img/meal1_home.png") }}';
            $id('detailImage').alt = r.nama_makanan;

            /* Title */
            $id('detailTitle').textContent = r.nama_makanan;

            /* Tags */
            $id('detailTags').innerHTML = safeArray(r.tags).map(t=>
                `<span class="recipe-tag" style="background:${tagColor(t)};font-size:.68rem;opacity:.9">${escHtml(t)}</span>`
            ).join('');

            /* Meta */
            const metas = [];
            if (r.cook_time)  metas.push(['⏱', r.cook_time+' menit']);
            if (r.difficulty) metas.push(['📊', capitalize(r.difficulty)]);
            if (r.meal_type)  metas.push(['🍽', capitalize(r.meal_type)]);
            $id('detailMeta').innerHTML = metas.map(([icon,label])=>
                `<span class="detail-meta-pill">${icon} ${escHtml(label)}</span>`
            ).join('');

            /* Description */
            $id('detailDesc').textContent = r.description ?? '';

            /* Nutrition */
            const macros = [
                {val:r.calories, lbl:'Kalori',  unit:'kcal', int:true},
                {val:r.protein,  lbl:'Protein', unit:'g'},
                {val:r.carbs,    lbl:'Karbo',   unit:'g'},
                {val:r.fat,      lbl:'Lemak',   unit:'g'},
                {val:r.fiber,    lbl:'Serat',   unit:'g'},
            ];
            $id('detailNutrition').innerHTML = macros.map(m=>{
                const v = parseFloat(m.val??0);
                const d = m.int ? Math.round(v) : v.toFixed(1);
                return `<div class="detail-nut-badge">
                    <div class="nv">${d}</div>
                    <div class="nl">${m.lbl}<br><span style="font-size:.58rem">${m.unit}</span></div>
                </div>`;
            }).join('');

            /* Servings */
            $id('detailServings').textContent = r.servings ? `${r.servings} porsi` : '';

            /* ✅ Ingredients — handles text column yang berisi JSON string */
            const ings = safeArray(r.ingredients);
            $id('detailIngredients').innerHTML = ings.length
                ? ings.map(ing=>{
                    let html = '';
                    if (typeof ing === 'string') {
                        html = escHtml(ing);
                    } else if (ing && typeof ing === 'object') {
                        const qty = [ing.amount, ing.unit].filter(Boolean).join(' ');
                        html = qty
                            ? `<strong>${escHtml(qty)}</strong>&nbsp;${escHtml(ing.name??'')}`
                            : escHtml(ing.name??'');
                    }
                    return `<li><span class="ing-bullet"></span><span>${html}</span></li>`;
                }).join('')
                : `<li><span class="ing-bullet" style="background:#D1D5DB"></span>
                   <span class="text-muted">Data bahan belum tersedia.</span></li>`;

            /* ✅ Cara masak — handles text column yang berisi JSON string */
            const steps = safeArray(r.cara_masak);
            $id('detailSteps').innerHTML = steps.length
                ? steps.map((s,i)=>{
                    const txt = typeof s==='string' ? s : (s?.step ?? JSON.stringify(s));
                    return `<li>
                        <span class="step-num">${i+1}</span>
                        <span>${escHtml(txt)}</span>
                    </li>`;
                }).join('')
                : `<li><span class="step-num" style="background:#D1D5DB">?</span>
                   <span class="text-muted">Data langkah memasak belum tersedia.</span></li>`;

            /* Show */
            $id('detailLoading').style.display = 'none';
            $id('detailContent').style.display = 'block';

        } catch(err) {
            $id('detailLoading').innerHTML =
                '<p class="text-danger text-center py-3">Gagal memuat resep. Coba lagi.</p>';
        }
    };

    /* ── Init ── */
    fetchRecommended();
    fetchPopular();
})();
</script>

@endsection
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
            <div class="section-title d-flex align-items-center justify-content-between" id="sectionRecommended">
                <div class="d-flex align-items-center gap-1">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5H7C5.895 5 5 5.895 5 7V19C5 20.105 5.895 21 7 21H17C18.105 21 19 20.105 19 19V7C19 5.895 18.105 5 17 5H15M9 5C9 5.552 9.448 6 10 6H14C14.552 6 15 5.552 15 5M9 5C9 4.448 9.448 4 10 4H14C14.552 4 15 4.448 15 5" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Recommended
                </div>
                <div class="scroll-nav">
                    <button class="scroll-btn" onclick="scrollGrid('gridRecommended', -1)">&#8249;</button>
                    <button class="scroll-btn" onclick="scrollGrid('gridRecommended', 1)">&#8250;</button>
                </div>
            </div>

            {{-- Wrapper dengan posisi relative untuk fade edge --}}
            <div class="recipe-scroll-wrapper mb-3">
                <div class="recipe-scroll-track" id="gridRecommended">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="recipe-scroll-item">
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
                <div class="scroll-fade-right"></div>
            </div>

            {{-- Popular --}}
            <div class="section-title d-flex align-items-center justify-content-between" id="sectionPopular">
                <div class="d-flex align-items-center gap-1">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5C5.754 5 4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke="#374151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Popular
                </div>
                <div class="scroll-nav">
                    <button class="scroll-btn" onclick="scrollGrid('gridPopular', -1)">&#8249;</button>
                    <button class="scroll-btn" onclick="scrollGrid('gridPopular', 1)">&#8250;</button>
                </div>
            </div>

            <div class="recipe-scroll-wrapper mb-4">
                <div class="recipe-scroll-track" id="gridPopular">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="recipe-scroll-item">
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
                <div class="scroll-fade-right"></div>
            </div>

            {{-- Search / Filter Results --}}
            <div id="searchResultsSection" style="display:none;">
                <div class="section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" stroke="#374151" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <span id="searchResultsLabel">Results</span>
                </div>
                {{-- Search results pakai grid biasa (bukan horizontal scroll) --}}
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

                <div id="detailLoading" class="text-center py-5">
                    <div class="spinner-border spinner-border-sm" style="color:#EA5C2B;" role="status"></div>
                    <p class="text-muted small mt-2 mb-0">Memuat resep...</p>
                </div>

                <div id="detailContent" style="display:none;" class="recipe-detail-content">

                    <p id="detailDesc" class="detail-desc"></p>

                    <div id="detailNutrition" class="detail-nutrition-row"></div>

                    <hr class="detail-divider">

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="detail-section-title mb-0">🧂 Ingredients</h6>
                            <span id="detailServings" class="detail-servings-badge"></span>
                        </div>
                        <ul id="detailIngredients" class="detail-ingredients-list"></ul>
                    </div>

                    <hr class="detail-divider">

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
        <div class="modal-content border-0 yr-modal">
            <div class="modal-header yr-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="yr-header-icon">📖</div>
                    <div>
                        <h5 class="modal-title fw-bold m-0" style="font-size:.95rem;color:#111827;">Your Recipes</h5>
                        <p class="m-0" style="font-size:.68rem;color:#9CA3AF;">Resep yang kamu buat</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3" id="yr-body">
                <div class="d-flex justify-content-center align-items-center py-5">
                    <div class="spinner-border spinner-border-sm me-2" style="color:#EA5C2B;"></div>
                    <span class="text-muted small">Memuat resepmu...</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Confirm Delete Modal ── --}}
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;">
            <div style="height:3px;background:linear-gradient(90deg,#ef4444,#f97316);"></div>
            <div class="modal-body text-center p-4">
                <div style="width:52px;height:52px;background:#FEF2F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.5rem;">🗑️</div>
                <h6 class="fw-bold mb-1" style="color:#111827;">Hapus Resep?</h6>
                <p class="text-muted small mb-3" id="deleteRecipeName" style="font-size:.78rem;">Resep ini akan dihapus permanen.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="yr-btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="yr-btn-delete" id="btnConfirmDelete">
                        <span id="deleteSpinner" style="display:none;" class="spinner-border spinner-border-sm me-1"></span>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ══════════════════════════════════
   HORIZONTAL SCROLL RECIPE GRID
══════════════════════════════════ */

/* Wrapper luar — posisi relative untuk fade & overflow control */
.recipe-scroll-wrapper {
    position: relative;
    overflow: hidden; /* sembunyikan shadow kanan yang keluar */
}

/* Track yang bisa di-scroll */
.recipe-scroll-track {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: visible;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch; /* smooth scroll iOS */
    gap: 14px;
    padding-bottom: 10px;
    padding-right: 8px; /* sedikit ruang di ujung kanan */
    /* Sembunyikan scrollbar tapi tetap bisa scroll */
    scrollbar-width: none;        /* Firefox */
    -ms-overflow-style: none;     /* IE/Edge */
}
.recipe-scroll-track::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}

/* Tiap item card — lebar dinamis 1/4 container, min 180px
   Efek: 4 card pas di layar, kalau > 4 bisa di-scroll ke kanan */
.recipe-scroll-item {
    flex: 0 0 calc(25% - 11px);
    width: calc(25% - 11px);
    min-width: 180px;
}

/* Fade gradient di tepi kanan supaya kelihatan ada lebih banyak card */
.scroll-fade-right {
    position: absolute;
    top: 0;
    right: 0;
    width: 60px;
    height: calc(100% - 10px); /* minus padding-bottom track */
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.95));
    pointer-events: none; /* klik tetap tembus ke card */
    z-index: 2;
}

/* ── Skeleton ── */
.skeleton-card { pointer-events: none; }
.skeleton-img {
    width: 100%;
    height: 140px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 10px 10px 0 0;
}
.skeleton-line {
    height: 11px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 6px;
}
@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Recipe card hover ── */
.recipe-card {
    cursor: pointer;
    transition: transform .18s, box-shadow .18s;
    height: 100%; /* full height dalam item */
}
.recipe-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.13);
}

/* ── Scroll nav buttons ── */
.scroll-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid #E5E7EB;
    background: #fff;
    color: #374151;
    font-size: 1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s;
    padding: 0;
}
.scroll-btn:hover {
    background: #F3F4F6;
    border-color: #D1D5DB;
    transform: scale(1.08);
}
.scroll-btn:active {
    transform: scale(0.96);
}

/* ══════════════════════════════════
   RECIPE DETAIL MODAL
══════════════════════════════════ */
.recipe-detail-modal {
    border: none;
    border-radius: 20px;
    overflow: hidden;
}
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
.recipe-modal-close:hover { background: #fff; transform: scale(1.1); }
.recipe-modal-close:focus { outline: none; }

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
.recipe-detail-content { padding: 18px 22px 24px; }
.detail-desc { color: #6B7280; font-size: .875rem; line-height: 1.7; margin-bottom: 1rem; }

.detail-nutrition-row { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
.detail-nut-badge {
    flex: 1; min-width: 60px;
    background: #FFF9F5; border: 1px solid #FFE5D0;
    border-radius: 12px; padding: .55rem .5rem .4rem; text-align: center;
}
.detail-nut-badge .nv { font-size: .95rem; font-weight: 700; color: #EA5C2B; line-height: 1; }
.detail-nut-badge .nl { font-size: .62rem; color: #9CA3AF; margin-top: 3px; line-height: 1.2; }

.detail-divider { border-color: #F3F4F6; margin: 1.1rem 0; }
.detail-section-title { font-size: .9rem; font-weight: 700; color: #111827; }
.detail-servings-badge {
    font-size: .72rem; font-weight: 600;
    background: #FFF3E0; color: #EA5C2B;
    border-radius: 20px; padding: .2rem .65rem;
}

.detail-ingredients-list { list-style: none; padding: 0; margin: 0; }
.detail-ingredients-list li {
    display: flex; align-items: flex-start; gap: .6rem;
    padding: .45rem 0; border-bottom: 1px solid #F9FAFB;
    font-size: .875rem; color: #374151; line-height: 1.55;
}
.detail-ingredients-list li:last-child { border-bottom: none; }
.ing-bullet { width: 8px; height: 8px; border-radius: 50%; background: #EA5C2B; margin-top: .38rem; flex-shrink: 0; }

.detail-steps-list { list-style: none; padding: 0; margin: 0; }
.detail-steps-list li {
    display: flex; align-items: flex-start; gap: .7rem;
    padding: .6rem 0; border-bottom: 1px solid #F9FAFB;
    font-size: .875rem; color: #374151; line-height: 1.6;
}
.detail-steps-list li:last-child { border-bottom: none; }
.step-num {
    flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%;
    background: #EA5C2B; color: #fff;
    font-size: .7rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    margin-top: .1rem;
}

/* ══════════════════════════════════
   YOUR RECIPES MODAL
══════════════════════════════════ */
.yr-modal {
    border-radius: 20px !important;
    box-shadow: 0 24px 64px rgba(0,0,0,.14) !important;
    overflow: hidden;
}
.yr-header {
    border-bottom: 1px solid rgba(0,0,0,.07);
    padding: 16px 20px 14px;
}
.yr-header-icon {
    width: 34px; height: 34px;
    background: linear-gradient(135deg, #ea5c2b, #f97316);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    box-shadow: 0 4px 10px rgba(234,92,43,.3);
}
.yr-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 14px;
    border: 1px solid #F3F4F6;
    background: #FAFAFA;
    margin-bottom: 8px;
    transition: all .18s;
    cursor: pointer;
}
.yr-card:hover { background: #fff; border-color: #E5E7EB; box-shadow: 0 4px 16px rgba(0,0,0,.08); transform: translateY(-1px); }
.yr-card-img {
    width: 60px; height: 60px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
    background: #F3F4F6;
}
.yr-card-info { flex: 1; min-width: 0; }
.yr-card-title {
    font-size: .82rem; font-weight: 700; color: #111827;
    margin: 0 0 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.yr-card-meta { display: flex; gap: 5px; flex-wrap: wrap; align-items: center; }
.yr-card-tag {
    font-size: .62rem; font-weight: 600;
    background: rgba(234,92,43,.1); color: #ea5c2b;
    border-radius: 20px; padding: 2px 8px;
}
.yr-card-time { font-size: .62rem; color: #9CA3AF; }
.yr-card-vis {
    font-size: .62rem; font-weight: 600;
    border-radius: 20px; padding: 2px 8px;
}
.yr-card-vis.public  { background: rgba(149,205,65,.12); color: #6ab32b; }
.yr-card-vis.private { background: rgba(107,114,128,.1); color: #6B7280; }

.yr-btn-delete-card {
    flex-shrink: 0;
    width: 32px; height: 32px;
    border-radius: 50%;
    border: 1.5px solid #FECACA;
    background: #FFF5F5;
    color: #EF4444;
    font-size: .8rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all .15s;
    padding: 0;
}
.yr-btn-delete-card:hover { background: #FEE2E2; border-color: #EF4444; transform: scale(1.1); }

.yr-empty { text-align: center; padding: 40px 20px; }
.yr-empty-icon { font-size: 2.5rem; margin-bottom: 10px; }
.yr-empty-text { font-size: .82rem; color: #6B7280; margin: 0; }
.yr-empty-sub  { font-size: .72rem; color: #9CA3AF; margin: 4px 0 0; }

.yr-btn-cancel {
    border: 1.5px solid #E5E7EB; background: #F9FAFB; color: #6B7280;
    border-radius: 50px; padding: .4rem 1.1rem; font-size: .8rem; font-weight: 600;
    cursor: pointer; transition: all .15s;
}
.yr-btn-cancel:hover { background: #F3F4F6; }
.yr-btn-delete {
    border: none; background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff;
    border-radius: 50px; padding: .4rem 1.2rem; font-size: .8rem; font-weight: 700;
    cursor: pointer; box-shadow: 0 4px 12px rgba(239,68,68,.3); transition: all .15s;
    display: flex; align-items: center;
}
.yr-btn-delete:hover { opacity: .88; transform: translateY(-1px); }
.yr-btn-delete:disabled { opacity: .55; cursor: not-allowed; transform: none; }
</style>

{{-- ══════════════════════════
     BACKDROP CLEANUP UTILITY
══════════════════════════ --}}
<script>
function cleanupBackdrops() {
    var openModals = document.querySelectorAll('.modal.show');
    if (openModals.length === 0) {
        document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
        document.body.style.removeProperty('overflow');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    ['modalYourRecipes', 'modalConfirmDelete', 'modalRecipeDetail', 'modalAddRecipe'].forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('hidden.bs.modal', function() {
            setTimeout(cleanupBackdrops, 50);
        });
    });
});
</script>

{{-- ══════════════════════════
     YOUR RECIPES
══════════════════════════ --}}
<script>
(function() {
    var deleteTargetId   = null;
    var deleteTargetName = null;

    function yrTagColor(tag) {
        var m = {
            breakfast:'#95CD41',lunch:'#EA5C2B',dinner:'#2B7FFF',
            snacks:'#FBBF24',desserts:'#A78BFA',drinks:'#34D399',
            Breakfast:'#95CD41',Lunch:'#EA5C2B',Dinner:'#2B7FFF',
        };
        return m[tag] || '#6B7280';
    }

    function yrBuildCard(r) {
        var img      = r.image_url || '{{ asset("img/meal1_home.png") }}';
        var title    = r.nama_makanan || 'Resep';
        var tag      = (r.meal_type || '');
        var tagLabel = tag.charAt(0).toUpperCase() + tag.slice(1);
        var timeStr  = r.cook_time ? r.cook_time + ' min' : '';
        var vis      = r.is_public ? 'public' : 'private';
        var visLabel = r.is_public ? '🌍 Publik' : '🔒 Pribadi';
        var fallbackImg = '{{ asset("img/meal1_home.png") }}';

        var card = document.createElement('div');
        card.className = 'yr-card';
        card.dataset.id = r.id;
        card.innerHTML =
            '<img class="yr-card-img" src="' + img + '" alt="' + title + '" onerror="this.src=\'' + fallbackImg + '\'">'
        + '<div class="yr-card-info">'
        +   '<p class="yr-card-title">' + title + '</p>'
        +   '<div class="yr-card-meta">'
        +     (tag ? '<span class="yr-card-tag" style="background:' + yrTagColor(tag) + '22;color:' + yrTagColor(tag) + '">' + tagLabel + '</span>' : '')
        +     (timeStr ? '<span class="yr-card-time">⏱ ' + timeStr + '</span>' : '')
        +     '<span class="yr-card-vis ' + vis + '">' + visLabel + '</span>'
        +   '</div>'
        + '</div>'
        + '<button type="button" class="yr-btn-delete-card" title="Hapus resep" onclick="yrAskDelete(event,' + r.id + ',\'' + title.replace(/'/g, '') + '\')">'
        +   '<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
        + '</button>';

        card.addEventListener('click', function(e) {
            if (e.target.closest('.yr-btn-delete-card')) return;
            var yrModal = bootstrap.Modal.getInstance(document.getElementById('modalYourRecipes'));
            if (yrModal) {
                yrModal.hide();
                document.getElementById('modalYourRecipes').addEventListener('hidden.bs.modal', function openDetailAfterClose() {
                    document.getElementById('modalYourRecipes').removeEventListener('hidden.bs.modal', openDetailAfterClose);
                    window.openDetail(r.id);
                });
            } else {
                window.openDetail(r.id);
            }
        });

        return card;
    }

    window.yrLoadMyRecipes = async function() {
        var body = document.getElementById('yr-body');
        body.innerHTML = '<div class="d-flex justify-content-center align-items-center py-5"><div class="spinner-border spinner-border-sm me-2" style="color:#EA5C2B;"></div><span class="text-muted small">Memuat resepmu...</span></div>';

        try {
            var res  = await fetch('/api/recipes/mine');
            var json = await res.json();
            var data = Array.isArray(json.data) ? json.data : (json.data?.data ?? []);

            body.innerHTML = '';

            if (data.length === 0) {
                body.innerHTML = '<div class="yr-empty"><div class="yr-empty-icon">🍽️</div><p class="yr-empty-text">Belum ada resep.</p><p class="yr-empty-sub">Yuk tambah resep pertamamu!</p></div>';
                return;
            }

            var count = document.createElement('p');
            count.style.cssText = 'font-size:.72rem;color:#9CA3AF;margin:0 0 10px;padding:0 2px;';
            count.textContent = data.length + ' resep';
            body.appendChild(count);

            data.forEach(function(r) {
                body.appendChild(yrBuildCard(r));
            });
        } catch(e) {
            body.innerHTML = '<div class="yr-empty"><div class="yr-empty-icon">⚠️</div><p class="yr-empty-text">Gagal memuat resep.</p></div>';
        }
    };

    window.yrAskDelete = function(e, id, name) {
        e.stopPropagation();
        deleteTargetId   = id;
        deleteTargetName = name;
        document.getElementById('deleteRecipeName').textContent = '"' + name + '" akan dihapus permanen dan tidak bisa dikembalikan.';
        new bootstrap.Modal(document.getElementById('modalConfirmDelete')).show();
    };

    document.getElementById('btnConfirmDelete').addEventListener('click', async function() {
        if (!deleteTargetId) return;
        var btn     = this;
        var spinner = document.getElementById('deleteSpinner');
        btn.disabled = true;
        spinner.style.display = 'inline-block';

        try {
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            var res = await fetch('/api/recipes/' + deleteTargetId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                    'Accept': 'application/json'
                }
            });

            var json = await res.json();

            var cdModal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmDelete'));
            if (cdModal) {
                cdModal.hide();
                document.getElementById('modalConfirmDelete').addEventListener('hidden.bs.modal', function reopenYr() {
                    document.getElementById('modalConfirmDelete').removeEventListener('hidden.bs.modal', reopenYr);
                    new bootstrap.Modal(document.getElementById('modalYourRecipes')).show();
                });
            }

            if (res.ok) {
                var card = document.querySelector('#yr-body .yr-card[data-id="' + deleteTargetId + '"]');
                if (card) {
                    card.style.transition = 'all .25s';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    setTimeout(function() { card.remove(); }, 250);
                }

                var countEl = document.querySelector('#yr-body > p');
                if (countEl) {
                    var remaining = document.querySelectorAll('#yr-body .yr-card').length - 1;
                    if (remaining <= 0) {
                        document.getElementById('yr-body').innerHTML = '<div class="yr-empty"><div class="yr-empty-icon">🍽️</div><p class="yr-empty-text">Belum ada resep.</p><p class="yr-empty-sub">Yuk tambah resep pertamamu!</p></div>';
                    } else {
                        countEl.textContent = remaining + ' resep';
                    }
                }

                if (typeof window.fetchRecommended === 'function') window.fetchRecommended();
                if (typeof window.fetchPopular     === 'function') window.fetchPopular();

                yrShowToast('Resep "' + deleteTargetName + '" berhasil dihapus.');
            } else {
                yrShowToast(json.message || 'Gagal menghapus resep.', true);
            }
        } catch(err) {
            var cdModal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmDelete'));
            if (cdModal) {
                cdModal.hide();
                document.getElementById('modalConfirmDelete').addEventListener('hidden.bs.modal', function reopenYrErr() {
                    document.getElementById('modalConfirmDelete').removeEventListener('hidden.bs.modal', reopenYrErr);
                    new bootstrap.Modal(document.getElementById('modalYourRecipes')).show();
                });
            }
            yrShowToast('Gagal terhubung ke server.', true);
        } finally {
            btn.disabled = false;
            spinner.style.display = 'none';
            deleteTargetId = null;
        }
    });

    function yrShowToast(msg, isError) {
        var toast = document.createElement('div');
        var color = isError ? '#ef4444' : '#95cd41';
        toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;'
            + 'background:#fff;border-radius:14px;padding:12px 16px;'
            + 'box-shadow:0 8px 30px rgba(0,0,0,.18);display:flex;align-items:center;gap:10px;'
            + 'border-left:4px solid ' + color + ';max-width:280px;'
            + 'animation:yr-slide-in .3s ease;font-size:.78rem;color:#374151;font-weight:600;';
        toast.textContent = msg;
        var style = document.createElement('style');
        style.textContent = '@keyframes yr-slide-in{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:none}}';
        document.head.appendChild(style);
        document.body.appendChild(toast);
        setTimeout(function() {
            toast.style.transition = 'opacity .4s';
            toast.style.opacity = '0';
            setTimeout(function() { toast.remove(); }, 400);
        }, 3000);
    }

    document.getElementById('modalYourRecipes').addEventListener('show.bs.modal', function() {
        window.yrLoadMyRecipes();
    });

    document.getElementById('btnYourRecipes').addEventListener('click', function(e) {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('modalYourRecipes')).show();
    });
})();
</script>

@include('components.modal_add_recipes')

{{-- ══════════════════════════ SCRIPT UTAMA ══════════════════════════ --}}
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

    function safeArray(val) {
        if (Array.isArray(val)) return val;
        if (!val && val !== 0) return [];
        if (typeof val === 'string') {
            try {
                let p = JSON.parse(val);
                if (typeof p === 'string') p = JSON.parse(p);
                return Array.isArray(p) ? p : [];
            } catch { return []; }
        }
        return [];
    }

    function tagColor(tag) {
        const m = {
            Breakfast:'#95CD41',breakfast:'#95CD41',
            Lunch:'#EA5C2B',lunch:'#EA5C2B',
            Dinner:'#2B7FFF',dinner:'#2B7FFF',
            Snacks:'#FBBF24',snacks:'#FBBF24',
            Desserts:'#A78BFA',desserts:'#A78BFA',
            Drinks:'#34D399',drinks:'#34D399',
            Vegan:'#2B7FFF',Vegetarian:'#95CD41',
            'Low-Carb':'#FBBF24','Gluten-Free':'#F472B6',
            Keto:'#8B5CF6','Dairy-Free':'#06B6D4',
            'High-Protein':'#EA5C2B','Low-Calorie':'#34D399',
            'Quick Meals':'#95CD41','Quick Meal':'#95CD41',
        };
        return m[tag] || '#6B7280';
    }

    /* ── Card builder untuk horizontal scroll ── */
    function buildCard(r) {
        const tags = safeArray(r.tags).slice(0,2)
            .map(t=>`<span class="recipe-tag" style="background:${tagColor(t)}">${escHtml(capitalize(t))}</span>`)
            .join('');
        const timeTag = r.cook_time
            ? `<span class="recipe-tag" style="background:#6B7280">#${r.cook_time}min</span>` : '';
        const img = r.image_url ?? '{{ asset("img/meal1_home.png") }}';

        /* Bungkus dalam .recipe-scroll-item agar flex item fixed width */
        return `
        <div class="recipe-scroll-item">
          <div class="recipe-card" onclick="window.openDetail(${r.id})">
            <img src="${escHtml(img)}" alt="${escHtml(r.nama_makanan)}"
                 onerror="this.src='{{ asset('img/meal1_home.png') }}'">
            <div class="recipe-card-body">
              <div class="d-flex justify-content-between align-items-start mb-1">
                <p class="recipe-card-title mb-0">${escHtml(r.nama_makanan)}</p>
                <span class="recipe-card-menu">⋮</span>
              </div>
              <p class="recipe-card-desc">${escHtml(truncate(r.description ?? '', 90))}</p>
              <div class="d-flex gap-1 flex-wrap">${tags}${timeTag}</div>
            </div>
          </div>
        </div>`;
    }

    /* ── Card builder untuk search results (grid biasa, bukan scroll) ── */
    function buildGridCard(r) {
        const tags = safeArray(r.tags).slice(0,2)
            .map(t=>`<span class="recipe-tag" style="background:${tagColor(t)}">${escHtml(capitalize(t))}</span>`)
            .join('');
        const timeTag = r.cook_time
            ? `<span class="recipe-tag" style="background:#6B7280">#${r.cook_time}min</span>` : '';
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
              <p class="recipe-card-desc">${escHtml(truncate(r.description ?? '', 90))}</p>
              <div class="d-flex gap-1 flex-wrap">${tags}${timeTag}</div>
            </div>
          </div>
        </div>`;
    }

    /* ── Populate horizontal scroll track ── */
    function populateScrollTrack(trackId, data) {
        const el = $id(trackId);
        if (!data || data.length === 0) {
            el.innerHTML = '<p class="text-muted small ps-2 py-2 m-0" style="white-space:nowrap;">Belum ada resep.</p>';
            return;
        }
        el.innerHTML = data.map(buildCard).join('');
    }

    /* ── Populate grid biasa (untuk search results) ── */
    function populateGrid(gridId, data) {
        const el = $id(gridId);
        el.innerHTML = (!data || data.length === 0)
            ? '<p class="text-muted small ps-2 py-2">Belum ada resep.</p>'
            : data.map(buildGridCard).join('');
    }

    /* ══════════════════════════════════
       SCROLL FUNCTION — dipanggil dari tombol ‹ ›
    ══════════════════════════════════ */
    window.scrollGrid = function(trackId, direction) {
        const el = $id(trackId);
        if (!el) return;
        /* Geser 2 card sekaligus: lebar card (210) + gap (14) */
        const scrollAmount = (210 + 14) * 2;
        el.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    };

    /* ── Perbarui tombol scroll berdasarkan posisi ── */
    function updateScrollButtons(trackId) {
        const track = $id(trackId);
        if (!track) return;

        /* Cari wrapper dan tombol nav di sekitarnya */
        const wrapper = track.closest('.recipe-scroll-wrapper');
        if (!wrapper) return;

        /* Cari section title di atas wrapper */
        const section = wrapper.previousElementSibling;
        if (!section) return;

        const btnPrev = section.querySelector('.scroll-btn:first-child');
        const btnNext = section.querySelector('.scroll-btn:last-child');
        if (!btnPrev || !btnNext) return;

        const atStart = track.scrollLeft <= 5;
        const atEnd   = track.scrollLeft + track.clientWidth >= track.scrollWidth - 5;

        btnPrev.style.opacity  = atStart ? '0.35' : '1';
        btnPrev.style.cursor   = atStart ? 'default' : 'pointer';
        btnNext.style.opacity  = atEnd   ? '0.35' : '1';
        btnNext.style.cursor   = atEnd   ? 'default' : 'pointer';
    }

    /* Pasang listener scroll pada kedua track */
    ['gridRecommended', 'gridPopular'].forEach(function(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('scroll', function() { updateScrollButtons(id); }, { passive: true });
    });

    /* ── API calls ── */
    window.fetchRecommended = async function () {
        try {
            const r = await fetch('/api/recipes/recommended?limit=8');
            if (!r.ok) throw new Error(r.status);
            populateScrollTrack('gridRecommended', (await r.json()).data ?? []);
            updateScrollButtons('gridRecommended');
        } catch {
            $id('gridRecommended').innerHTML =
                '<p class="text-muted small ps-2" style="white-space:nowrap;">Gagal memuat. <a href="#" onclick="location.reload()">Refresh</a></p>';
        }
    };

    window.fetchPopular = async function () {
        try {
            const r = await fetch('/api/recipes/popular?limit=8');
            if (!r.ok) throw new Error(r.status);
            populateScrollTrack('gridPopular', (await r.json()).data ?? []);
            updateScrollButtons('gridPopular');
        } catch {
            $id('gridPopular').innerHTML =
                '<p class="text-muted small ps-2" style="white-space:nowrap;">Gagal memuat. <a href="#" onclick="location.reload()">Refresh</a></p>';
        }
    };

    async function fetchFiltered() {
        const params = new URLSearchParams();
        if (activeMealType)    params.set('meal_type', activeMealType);
        if (activeTags.length) params.set('tags', activeTags.join(','));
        const kw = $id('searchInput').value.trim();
        if (kw) params.set('search', kw);
        try {
            const r    = await fetch('/api/recipes?' + params);
            const data = (await r.json()).data ?? [];
            populateGrid('gridSearch', data);
            $id('emptyState').style.display = data.length === 0 ? 'block' : 'none';
        } catch {
            $id('gridSearch').innerHTML = '<p class="text-muted small ps-2">Gagal memuat.</p>';
        }
    }

    /* ── Search / filter mode ── */
    let activeMealType = null, activeTags = [], searchTimeout = null;
    const HIDEABLE = ['sectionRecommended', 'sectionPopular'];
    const HIDEABLE_WRAPPERS = [
        document.querySelector('#gridRecommended')?.closest('.recipe-scroll-wrapper'),
        document.querySelector('#gridPopular')?.closest('.recipe-scroll-wrapper'),
    ];

    function enterSearchMode(label) {
        $id('searchResultsSection').style.display = 'block';
        $id('searchResultsLabel').textContent = label;
        HIDEABLE.forEach(id => { const el = $id(id); if(el) el.style.display = 'none'; });
        HIDEABLE_WRAPPERS.forEach(el => { if(el) el.style.display = 'none'; });
    }
    function exitSearchMode() {
        $id('searchResultsSection').style.display = 'none';
        $id('emptyState').style.display = 'none';
        HIDEABLE.forEach(id => { const el = $id(id); if(el) el.style.display = ''; });
        HIDEABLE_WRAPPERS.forEach(el => { if(el) el.style.display = ''; });
    }
    function applyFilter() {
        const hasFilter = activeMealType || activeTags.length || $id('searchInput').value.trim();
        if (hasFilter) {
            enterSearchMode(activeMealType ? capitalize(activeMealType) + ' Recipes' : 'Filter Results');
            fetchFiltered();
        } else { exitSearchMode(); }
    }

    document.querySelectorAll('.filter-meal-type').forEach(el => {
        el.addEventListener('click', function () {
            const val = this.dataset.value;
            document.querySelectorAll('.filter-meal-type').forEach(e => {
                e.classList.remove('active');
                e.querySelector('.filter-dot').classList.remove('oren');
            });
            activeMealType = (activeMealType === val) ? null : val;
            if (activeMealType) {
                this.classList.add('active');
                this.querySelector('.filter-dot').classList.add('oren');
            }
            applyFilter();
        });
    });

    document.querySelectorAll('.filter-pref').forEach(el => {
        el.addEventListener('click', function () {
            const val = this.dataset.value;
            if (activeTags.includes(val)) {
                activeTags = activeTags.filter(t => t !== val);
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

    $id('btnResetFilter').addEventListener('click', () => {
        activeMealType = null; activeTags = [];
        $id('searchInput').value = '';
        document.querySelectorAll('.filter-item').forEach(e => {
            e.classList.remove('active');
            e.querySelector('.filter-dot')?.classList.remove('oren');
        });
        exitSearchMode();
    });

    $id('searchInput').addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilter, 350);
    });

    /* ══════════════════════════════════
       OPEN DETAIL MODAL
    ══════════════════════════════════ */
    window.openDetail = async function (id) {
        const modalEl = $id('modalRecipeDetail');
        const modal   = bootstrap.Modal.getOrCreateInstance(modalEl);

        $id('detailLoading').style.display  = 'block';
        $id('detailContent').style.display  = 'none';
        $id('detailTitle').textContent      = '';
        $id('detailTags').innerHTML         = '';
        $id('detailMeta').innerHTML         = '';
        $id('detailImage').src              = '{{ asset("img/meal1_home.png") }}';
        modal.show();

        try {
            const res = await fetch(`/api/recipes/${id}`);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const r   = (await res.json()).data;

            $id('detailImage').src = r.image_url ?? '{{ asset("img/meal1_home.png") }}';
            $id('detailImage').alt = r.nama_makanan;
            $id('detailTitle').textContent = r.nama_makanan;

            $id('detailTags').innerHTML = safeArray(r.tags).map(t =>
                `<span class="recipe-tag" style="background:${tagColor(t)};font-size:.68rem;opacity:.9">${escHtml(capitalize(t))}</span>`
            ).join('');

            const metas = [];
            if (r.cook_time)  metas.push(['⏱', r.cook_time + ' menit']);
            if (r.difficulty) metas.push(['📊', capitalize(r.difficulty)]);
            if (r.meal_type)  metas.push(['🍽', capitalize(r.meal_type)]);
            $id('detailMeta').innerHTML = metas.map(([icon, label]) =>
                `<span class="detail-meta-pill">${icon} ${escHtml(label)}</span>`
            ).join('');

            $id('detailDesc').textContent = r.description ?? '';

            const macros = [
                {val: r.calories, lbl: 'Kalori',  unit: 'kcal', int: true},
                {val: r.protein,  lbl: 'Protein', unit: 'g'},
                {val: r.carbs,    lbl: 'Karbo',   unit: 'g'},
                {val: r.fat,      lbl: 'Lemak',   unit: 'g'},
                {val: r.fiber,    lbl: 'Serat',   unit: 'g'},
            ];
            $id('detailNutrition').innerHTML = macros.map(m => {
                const v = parseFloat(m.val ?? 0);
                const d = m.int ? Math.round(v) : v.toFixed(1);
                return `<div class="detail-nut-badge">
                    <div class="nv">${d}</div>
                    <div class="nl">${m.lbl}<br><span style="font-size:.58rem">${m.unit}</span></div>
                </div>`;
            }).join('');

            $id('detailServings').textContent = r.servings ? `${r.servings} porsi` : '';

            const ings = safeArray(r.ingredients);
            $id('detailIngredients').innerHTML = ings.length
                ? ings.map(ing => {
                    let html = '';
                    if (typeof ing === 'string') {
                        html = escHtml(ing);
                    } else if (ing && typeof ing === 'object') {
                        const qty = [ing.amount, ing.unit].filter(Boolean).join(' ');
                        html = qty
                            ? `<strong>${escHtml(qty)}</strong>&nbsp;${escHtml(ing.name ?? '')}`
                            : escHtml(ing.name ?? '');
                    }
                    return `<li><span class="ing-bullet"></span><span>${html}</span></li>`;
                }).join('')
                : `<li><span class="ing-bullet" style="background:#D1D5DB"></span>
                   <span class="text-muted">Data bahan belum tersedia.</span></li>`;

            const steps = safeArray(r.cara_masak);
            $id('detailSteps').innerHTML = steps.length
                ? steps.map((s, i) => {
                    const txt = typeof s === 'string' ? s : (s?.step ?? JSON.stringify(s));
                    return `<li>
                        <span class="step-num">${i + 1}</span>
                        <span>${escHtml(txt)}</span>
                    </li>`;
                }).join('')
                : `<li><span class="step-num" style="background:#D1D5DB">?</span>
                   <span class="text-muted">Data langkah memasak belum tersedia.</span></li>`;

            $id('detailLoading').style.display = 'none';
            $id('detailContent').style.display = 'block';

        } catch (err) {
            $id('detailLoading').innerHTML =
                '<p class="text-danger text-center py-3">Gagal memuat resep. Coba lagi.</p>';
        }
    };

    /* ── Init ── */
    window.fetchRecommended();
    window.fetchPopular();
})();
</script>

@endsection
@extends('layout.layout')

@section('title', 'Nutrition')

@section('content')
@php
    /**
     * Helper: compute % of daily value
     * Falls back gracefully if model method isn't available in older code paths.
     */
    $dv = fn(string $macro, float $val): int => match($macro) {
        'calories' => (int) round($val / 2000 * 100),
        'protein'  => (int) round($val / 50   * 100),
        'carbs'    => (int) round($val / 275  * 100),
        'fat'      => (int) round($val / 78   * 100),
        'fiber'    => (int) round($val / 28   * 100),
        'sugar'    => (int) round($val / 50   * 100),
        'sodium'   => (int) round($val / 2300 * 100),
        default    => 0,
    };

    $macroMeta = [
        'calories' => ['label' => 'Calories', 'unit' => 'kcal', 'color' => '#FF6900',
            'icon' => '<path d="M8.5 14.5C9.16 14.5 9.8 14.24 10.27 13.77C10.74 13.3 11 12.66 11 12C11 10.62 10.5 10 10 9C9 7 9.78 5.95 12 4C12.5 6.5 14 8.9 16 10.5C18 12.1 19 13.5 19 15C19 17.76 16.76 20 14 20H12C9.24 20 7 17.76 7 15C7 13.89 7.37 12.78 8 12C8 12.66 8.26 13.3 8.73 13.77C9.2 14.24 9.84 14.5 10.5 14.5Z" stroke="#FF6900" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'],
        'protein'  => ['label' => 'Protein',  'unit' => 'g',    'color' => '#00A63E',
            'icon' => '<circle cx="12" cy="8" r="5" stroke="#00A63E" stroke-width="1.5"/><path d="M3 21C3 17 7 14 12 14C17 14 21 17 21 21" stroke="#00A63E" stroke-width="1.5" stroke-linecap="round"/>'],
        'carbs'    => ['label' => 'Carbs',    'unit' => 'g',    'color' => '#FBBF24',
            'icon' => '<path d="M12 3C7 3 4 7 4 11C4 15 7 18 12 18C17 18 20 15 20 11C20 7 17 3 12 3Z" stroke="#FBBF24" stroke-width="1.5"/><path d="M8 18V21M16 18V21" stroke="#FBBF24" stroke-width="1.5" stroke-linecap="round"/>'],
        'fat'      => ['label' => 'Fat',      'unit' => 'g',    'color' => '#FB923C',
            'icon' => '<path d="M12 2C8 2 5 5 5 9C5 13 8 16 12 22C16 16 19 13 19 9C19 5 16 2 12 2Z" stroke="#FB923C" stroke-width="1.5"/>'],
    ];

    $breakdownMeta = [
        ['key'=>'calories',  'label'=>'Calories',      'val_fmt'=>fn($m)=>$m->calories.' kcal', 'color'=>'#FF6900'],
        ['key'=>'protein',   'label'=>'Protein',        'val_fmt'=>fn($m)=>$m->protein.' g',    'color'=>'#00A63E'],
        ['key'=>'carbs',     'label'=>'Carbohydrates',  'val_fmt'=>fn($m)=>$m->carbs.' g',      'color'=>'#FBBF24'],
        ['key'=>'fat',       'label'=>'Fat',            'val_fmt'=>fn($m)=>$m->fat.' g',        'color'=>'#FB923C'],
        ['key'=>'fiber',     'label'=>'Fiber',          'val_fmt'=>fn($m)=>$m->fiber.' g',      'color'=>'#A78BFA'],
        ['key'=>'sugar',     'label'=>'Sugar',          'val_fmt'=>fn($m)=>$m->sugar.' g',      'color'=>'#F87171'],
        ['key'=>'sodium',    'label'=>'Sodium',         'val_fmt'=>fn($m)=>$m->sodium.' mg',    'color'=>'#94A3B8'],
    ];
@endphp

<style>
/* ── Nutrition page styles ───────────────────────────────── */
.nutrition-wrap { display:flex; flex-direction:column; gap:1.25rem; }

/* Search bar */
.nut-search-wrap {
    position: relative;
    max-width: 420px;
}

.nut-search-wrap input {
    width: 100%;
    padding: 0.55rem 1rem 0.55rem 2.6rem;
    border: none;
    border-radius: 50px;
    font-size: 0.85rem;
    outline: none;
    transition: all 0.3s ease;
    background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
    color: white;
    box-shadow: none;
}

.nut-search-wrap input::placeholder {
    color: rgba(255, 255, 255, 0.75);
}

.nut-search-wrap input:focus {
    background: linear-gradient(90deg, #7ab535 0%, #cd4c22 100%);
    color: white;
    box-shadow: 0 0 0 3px rgba(149, 205, 65, 0.35);
}

.nut-search-wrap svg {
    position: absolute;
    left: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    z-index: 2;
    pointer-events: none;
}

.nut-search-wrap svg circle,
.nut-search-wrap svg path {
    stroke: white !important;
    opacity: 0.9;
}

/* Hero detail panel */
.nutrition-hero-panel {
    bbackground: rgba(255, 248, 240, 0.92); border-radius:18px;
    padding:1.25rem 1.4rem; box-shadow:0 2px 10px rgba(0,0,0,.06);
}
.hero-meal-img { width:140px; height:110px; object-fit:cover; border-radius:14px; flex-shrink:0; }
.tag-toast { background:#FFF3E0; color:#FF6900; border-radius:20px; padding:.18rem .75rem; font-size:.75rem; font-weight:600; }
.tag-kcal  { background:#FFF3E0; color:#FF6900; border-radius:20px; padding:.18rem .75rem; font-size:.75rem; font-weight:600; }
.tag-time  { background:#E8F5E9; color:#00A63E; border-radius:20px; padding:.18rem .75rem; font-size:.75rem; font-weight:600; }

/* Macro cards */
.macro-card {
    flex:1 1 160px; background: rgba(255, 248, 240, 0.92); border-radius:14px;
    padding:1rem 1.1rem; box-shadow:0 1px 6px rgba(0,0,0,.06);
    min-width:140px;
}
.macro-num { font-size:1.8rem; font-weight:800; line-height:1.1; }
.macro-pct { font-size:.72rem; color:#9CA3AF; margin-bottom:.35rem; }
.macro-bar { background:#F3F4F6; border-radius:99px; height:5px; overflow:hidden; }
.macro-bar-fill { height:100%; border-radius:99px; transition:width .4s ease; }

/* Breakdown panel */
.breakdown-panel {
    background: rgba(255, 248, 240, 0.92); border-radius:14px;
    padding:1.1rem 1.2rem; box-shadow:0 1px 6px rgba(0,0,0,.06);
}
.breakdown-row { padding:.35rem 0; border-bottom:1px solid #F3F4F6; }
.breakdown-row:last-child { border-bottom:none; }
.bd-bar { background:#F3F4F6; border-radius:99px; height:5px; overflow:hidden; }
.bd-bar-fill { height:100%; border-radius:99px; }

/* Info panels */
.info-panel { background: rgba(255, 248, 240, 0.92); border-radius:14px; padding:1.1rem 1.2rem; box-shadow:0 1px 6px rgba(0,0,0,.06); }
.ing-dot { display:inline-block; width:10px; height:10px; border-radius:50%; flex-shrink:0; }
.step-circle {
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:22px; border-radius:50%;
    background:var(--warna-oren); color:#fff; font-size:.72rem; font-weight:700; flex-shrink:0;
}

/* ── Meal grid (scroll section) ─────────────────────────── */
.section-title-row { display:flex; align-items:center; justify-content:space-between; }
.meal-grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap:1rem;
}
.meal-card {
    background: rgba(255, 248, 240, 0.92); border-radius:14px; overflow:hidden;
    box-shadow:0 1px 6px rgba(0,0,0,.07);
    cursor:pointer; transition:transform .18s, box-shadow .18s;
    text-decoration:none; color:inherit;
    display:flex; flex-direction:column;
}
.meal-card:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(0,0,0,.1); }
.meal-card.active { outline:2.5px solid var(--warna-oren); }
.meal-card img { width:100%; height:130px; object-fit:cover; }
.meal-card-body { padding:.75rem .9rem; flex:1; }
.meal-card-name { font-weight:700; font-size:.88rem; margin-bottom:.2rem; }
.meal-card-cat  { font-size:.72rem; color:#9CA3AF; }
.meal-card-meta { display:flex; gap:.4rem; flex-wrap:wrap; margin-top:.5rem; }
.meal-card-meta span {
    font-size:.68rem; font-weight:600; border-radius:20px; padding:.12rem .55rem;
}
.badge-kcal { background:#FFF3E0; color:#FF6900; }
.badge-time { background:#E8F5E9; color:#00A63E; }

/* pagination */
.pagination { gap:.35rem; }
.pagination .page-link { border-radius:8px !important; font-size:.8rem; color:#374151; border-color:#e5e7eb; }
.pagination .page-item.active .page-link { background:var(--warna-oren); border-color:var(--warna-oren); }
</style>

<div class="col-12 py-2 nutrition-wrap">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
        <h5 class="fw-bold mb-0" style="color: var(--warna-oren);">Nutrition</h5>

        {{-- Search bar --}}
        <form method="GET" action="{{ route('nutrition') }}" class="nut-search-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="7" stroke="#374151" stroke-width="2"/>
                <path d="M16.5 16.5L21 21" stroke="#374151" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Search meals…" autocomplete="off">
        </form>
    </div>

    @if ($featured)
    {{-- ── Hero detail panel (updates on card click) ─────────────── --}}
    <div class="nutrition-hero-panel" id="nutrition-detail">

        {{-- Hero food card --}}
        <div class="nutrition-hero d-flex flex-wrap gap-3 align-items-center mb-3">
            <div class="flex-grow-1">
                <h4 class="fw-bold mb-1" id="d-name">{{ $featured->name }}</h4>
                <p class="text-muted mb-2" id="d-desc" style="font-size:.82rem; max-width:520px;">
                    {{ $featured->description }}
                </p>
                <div class="d-flex gap-2 flex-wrap" id="d-tags">
                    <span class="tag-toast">{{ $featured->category }}</span>
                    <span class="tag-kcal">🔥 {{ $featured->calories }}kcal</span>
                    @if($featured->prep_time)
                    <span class="tag-time">⏱ {{ $featured->prep_time }}min</span>
                    @endif
                </div>
            </div>
            <img id="d-img"
                 src="{{ $featured->image_path ? asset($featured->image_path) : asset('img/placeholder_meal.png') }}"
                 alt="{{ $featured->name }}" class="hero-meal-img">
        </div>

        {{-- Macro cards --}}
        <div class="d-flex flex-wrap gap-3 mb-3" id="d-macros">
        @foreach($macroMeta as $key => $m)
        @php
            $val = $featured->{$key};
            $pct = min($dv($key, $val), 100);
        @endphp
        <div class="macro-card">
            <div class="d-flex align-items-center gap-2 mb-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">{!! $m['icon'] !!}</svg>
                <span class="fw-bold" style="font-size:.78rem;">{{ $m['label'] }}</span>
            </div>
            <div class="macro-num" style="color:{{ $m['color'] }};">
                {{ $key==='calories' ? number_format($val,0) : number_format($val,1) }}
                <span style="font-size:.9rem;">{{ $m['unit'] }}</span>
            </div>
            <p class="macro-pct mb-1">{{ $pct }}% of daily value</p>
            <div class="macro-bar">
                <div class="macro-bar-fill" style="width:{{ $pct }}%;background:{{ $m['color'] }};"></div>
            </div>
        </div>
        @endforeach
        </div>

        {{-- Breakdown + right panels --}}
        <div class="row py-0 g-3">
            <div class="col-12 col-md-6">
                <div class="breakdown-panel h-100">
                    <h6 class="fw-bold mb-3">Nutrition Breakdown</h6>
                    <div id="d-breakdown">
                    @foreach($breakdownMeta as $row)
                    @php $val=$featured->{$row['key']}; $pct=min($dv($row['key'],$val),100); @endphp
                    <div class="breakdown-row d-flex align-items-center gap-2">
                        <span style="font-size:.8rem;font-weight:{{ $row['label']==='Carbohydrates'?'700':'400' }};min-width:110px;">{{ $row['label'] }}</span>
                        <span style="font-size:.8rem;min-width:60px;text-align:right;">{{ ($val%1==0)?number_format($val,0):number_format($val,1) }} {{ $row['key']==='sodium'?'mg':'g' }}{{ $row['key']==='calories'?' kcal':'' }}</span>
                        <div class="bd-bar flex-grow-1">
                            <div class="bd-bar-fill" style="width:{{ $pct }}%;background:{{ $row['color'] }};"></div>
                        </div>
                        <span style="font-size:.75rem;color:#6B7280;min-width:30px;text-align:right;">{{ $pct }}%</span>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 d-flex flex-column gap-3">
                {{-- Ingredients --}}
                <div class="info-panel">
                    <h6 class="fw-bold mb-3">Ingredients</h6>
                    <div id="d-ingredients">
                    @if($featured->ingredients)
                    @foreach($featured->ingredients as $ing)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="ing-dot" style="background:{{ $ing['color'] }};"></span>
                        <span style="font-size:.82rem;">{{ $ing['name'] }}</span>
                    </div>
                    @endforeach
                    @endif
                    </div>
                </div>

                {{-- How to Prepare --}}
                <div class="info-panel">
                    <h6 class="fw-bold mb-3">How To Prepare</h6>
                    <div id="d-steps">
                    @if($featured->steps)
                    @foreach($featured->steps as $i => $step)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <span class="step-circle">{{ $i+1 }}</span>
                        <span style="font-size:.82rem;line-height:1.5;">{{ $step }}</span>
                    </div>
                    @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /detail panel -->
    @else
    <div class="alert alert-warning rounded-3">No meals found.</div>
    @endif

    {{-- ── All Meals grid ─────────────────────────────────────────── --}}
    <div>
        <div class="section-title-row mb-2">
            <h6 class="fw-bold mb-0">All Meals
                @if($search)
                <small class="text-muted fw-normal">&nbsp;— "{{ $search }}"</small>
                @endif
            </h6>
            <small class="text-muted">{{ $meals->total() }} results</small>
        </div>

        <div class="meal-grid" id="meal-grid">
        @forelse($meals as $meal)
        <div class="meal-card {{ $loop->first && !request('search') ? 'active' : '' }}"
             data-meal="{{ json_encode([
                'id'          => $meal->id,
                'name'        => $meal->name,
                'description' => $meal->description,
                'category'    => $meal->category,
                'prep_time'   => $meal->prep_time,
                'image_path'  => $meal->image_path ? asset($meal->image_path) : asset('img/placeholder_meal.png'),
                'calories'    => $meal->calories,
                'protein'     => $meal->protein,
                'carbs'       => $meal->carbs,
                'fat'         => $meal->fat,
                'fiber'       => $meal->fiber,
                'sugar'       => $meal->sugar,
                'sodium'      => $meal->sodium,
                'ingredients' => $meal->ingredients,
                'steps'       => $meal->steps,
             ]) }}"
             onclick="selectMeal(this)">
            <img src="{{ $meal->image_path ? asset($meal->image_path) : asset('img/placeholder_meal.png') }}"
                 alt="{{ $meal->name }}"
                 onerror="this.src='{{ asset('img/placeholder_meal.png') }}'">
            <div class="meal-card-body">
                <div class="meal-card-name">{{ $meal->name }}</div>
                <div class="meal-card-cat">{{ $meal->category }}</div>
                <div class="meal-card-meta">
                    <span class="badge-kcal">🔥 {{ number_format($meal->calories,0) }} kcal</span>
                    @if($meal->prep_time)
                    <span class="badge-time">⏱ {{ $meal->prep_time }}min</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted col-span-full">No meals match your search.</p>
        @endforelse
        </div>

        {{-- Pagination --}}
        @if($meals->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $meals->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<script>
const dvRef = { calories:2000, protein:50, carbs:275, fat:78, fiber:28, sugar:50, sodium:2300 };
const macroMeta = {
    calories: { label:'Calories', unit:'kcal', color:'#FF6900',
        icon:`<path d="M8.5 14.5C9.16 14.5 9.8 14.24 10.27 13.77C10.74 13.3 11 12.66 11 12C11 10.62 10.5 10 10 9C9 7 9.78 5.95 12 4C12.5 6.5 14 8.9 16 10.5C18 12.1 19 13.5 19 15C19 17.76 16.76 20 14 20H12C9.24 20 7 17.76 7 15C7 13.89 7.37 12.78 8 12C8 12.66 8.26 13.3 8.73 13.77C9.2 14.24 9.84 14.5 10.5 14.5Z" stroke="#FF6900" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>` },
    protein:  { label:'Protein',  unit:'g',    color:'#00A63E',
        icon:`<circle cx="12" cy="8" r="5" stroke="#00A63E" stroke-width="1.5"/><path d="M3 21C3 17 7 14 12 14C17 14 21 17 21 21" stroke="#00A63E" stroke-width="1.5" stroke-linecap="round"/>` },
    carbs:    { label:'Carbs',    unit:'g',    color:'#FBBF24',
        icon:`<path d="M12 3C7 3 4 7 4 11C4 15 7 18 12 18C17 18 20 15 20 11C20 7 17 3 12 3Z" stroke="#FBBF24" stroke-width="1.5"/><path d="M8 18V21M16 18V21" stroke="#FBBF24" stroke-width="1.5" stroke-linecap="round"/>` },
    fat:      { label:'Fat',      unit:'g',    color:'#FB923C',
        icon:`<path d="M12 2C8 2 5 5 5 9C5 13 8 16 12 22C16 16 19 13 19 9C19 5 16 2 12 2Z" stroke="#FB923C" stroke-width="1.5"/>` },
};
const breakdownMeta = [
    { key:'calories', label:'Calories',     unit:'kcal', color:'#FF6900' },
    { key:'protein',  label:'Protein',      unit:'g',    color:'#00A63E' },
    { key:'carbs',    label:'Carbohydrates',unit:'g',    color:'#FBBF24' },
    { key:'fat',      label:'Fat',          unit:'g',    color:'#FB923C' },
    { key:'fiber',    label:'Fiber',        unit:'g',    color:'#A78BFA' },
    { key:'sugar',    label:'Sugar',        unit:'g',    color:'#F87171' },
    { key:'sodium',   label:'Sodium',       unit:'mg',   color:'#94A3B8' },
];

function pct(key, val) { return Math.min(Math.round(val / dvRef[key] * 100), 100); }
function fmt(val, key) {
    return key === 'calories' ? Math.round(val) : parseFloat(val).toFixed(1);
}

function selectMeal(el) {
    // update active card
    document.querySelectorAll('.meal-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');

    const m = JSON.parse(el.dataset.meal);

    // scroll detail into view
    document.getElementById('nutrition-detail').scrollIntoView({ behavior:'smooth', block:'nearest' });

    // name / desc / tags
    document.getElementById('d-name').textContent = m.name;
    document.getElementById('d-desc').textContent = m.description || '';
    document.getElementById('d-tags').innerHTML =
        `<span class="tag-toast">${m.category||''}</span>
         <span class="tag-kcal">🔥 ${Math.round(m.calories)}kcal</span>` +
        (m.prep_time ? `<span class="tag-time">⏱ ${m.prep_time}min</span>` : '');

    // image
    document.getElementById('d-img').src = m.image_path;
    document.getElementById('d-img').alt = m.name;

    // macros
    document.getElementById('d-macros').innerHTML =
        Object.entries(macroMeta).map(([key, meta]) => {
            const val = m[key] ?? 0;
            const p = pct(key, val);
            return `<div class="macro-card">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">${meta.icon}</svg>
                    <span class="fw-bold" style="font-size:.78rem;">${meta.label}</span>
                </div>
                <div class="macro-num" style="color:${meta.color};">
                    ${fmt(val,key)} <span style="font-size:.9rem;">${meta.unit}</span>
                </div>
                <p class="macro-pct mb-1">${p}% of daily value</p>
                <div class="macro-bar"><div class="macro-bar-fill" style="width:${p}%;background:${meta.color};"></div></div>
            </div>`;
        }).join('');

    // breakdown
    document.getElementById('d-breakdown').innerHTML =
        breakdownMeta.map(row => {
            const val = m[row.key] ?? 0;
            const p = pct(row.key, val);
            return `<div class="breakdown-row d-flex align-items-center gap-2">
                <span style="font-size:.8rem;font-weight:${row.label==='Carbohydrates'?'700':'400'};min-width:110px;">${row.label}</span>
                <span style="font-size:.8rem;min-width:70px;text-align:right;">${fmt(val,row.key)} ${row.unit}</span>
                <div class="bd-bar flex-grow-1"><div class="bd-bar-fill" style="width:${p}%;background:${row.color};"></div></div>
                <span style="font-size:.75rem;color:#6B7280;min-width:30px;text-align:right;">${p}%</span>
            </div>`;
        }).join('');

    // ingredients
    const ings = m.ingredients || [];
    document.getElementById('d-ingredients').innerHTML = ings.map(ing =>
        `<div class="d-flex align-items-center gap-2 mb-2">
            <span class="ing-dot" style="background:${ing.color};"></span>
            <span style="font-size:.82rem;">${ing.name}</span>
        </div>`
    ).join('');

    // steps
    const steps = m.steps || [];
    document.getElementById('d-steps').innerHTML = steps.map((s, i) =>
        `<div class="d-flex align-items-start gap-2 mb-2">
            <span class="step-circle">${i+1}</span>
            <span style="font-size:.82rem;line-height:1.5;">${s}</span>
        </div>`
    ).join('');
}
</script>
@endsection
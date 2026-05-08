@extends('layout.layout')

{{-- Section Nutrition --}}

@section('title', 'Nutrition')
@section('content')


    <div class="col-12 py-2">
        <h5 class="fw-bold mb-3" style="color: var(--warna-oren);">Nutrition</h5>

        {{-- Hero: food card --}}
        <div class="nutrition-hero d-flex flex-wrap gap-3 align-items-center mb-3">
            <div class="flex-grow-1">
                <h4 class="fw-bold mb-1">Avocado Egg Toast</h4>
                <p class="text-muted mb-2" style="font-size:0.82rem; max-width:520px;">
                    A healthy and satisfying dish made with toasted bread topped with mashed avocado and a cooked egg. Rich
                    in healthy fats and protein, perfect for breakfast or a light meal.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="tag-toast">Toast</span>
                    <span class="tag-kcal">🔥 189kcal</span>
                    <span class="tag-time">⏱ 7min</span>
                </div>
            </div>
            <img src="{{ asset('img/meal1_home.png') }}" alt="Avocado Egg Toast" class="hero-meal-img">
        </div>

        {{-- Macro cards row --}}
        <div class="d-flex flex-wrap gap-3 mb-3">
            {{-- Calories --}}
            <div class="macro-card">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M8.5 14.5C9.16304 14.5 9.79893 14.2366 10.2678 13.7678C10.7366 13.2989 11 12.663 11 12C11 10.62 10.5 10 10 9C9.00005 7.00004 9.77605 5.94604 12 4C12.5 6.5 14 8.9 16 10.5C18 12.1 19 13.5 19 15C19 15.9193 18.8189 16.8295 18.4672 17.6788C18.1154 18.5281 17.5998 19.2997 16.9497 19.9497C16.2997 20.5998 15.5281 21.1154 14.6788 21.4672C13.8295 21.8189 12.9193 22 12 22C11.0807 22 10.1705 21.8189 9.32121 21.4672C8.47194 21.1154 7.70026 20.5998 7.05025 19.9497C6.40024 19.2997 5.88463 18.5281 5.53284 17.6788C5.18106 16.8295 5 15.9193 5 15C5 13.885 5.37475 12.78 6 12C6 12.663 6.26339 13.2989 6.73223 13.7678C7.20107 14.2366 7.83696 14.5 8.5 14.5Z"
                            stroke="#FF6900" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="fw-bold" style="font-size:0.78rem;">Calories</span>
                </div>
                <div class="macro-num" style="color:#FF6900;">280 <span style="font-size:0.9rem;">kcal</span></div>
                <p class="macro-pct mb-1">14% of daily value</p>
                <div class="macro-bar">
                    <div class="macro-bar-fill" style="width:14%;background:#FF6900;"></div>
                </div>
            </div>

            {{-- Protein --}}
            <div class="macro-card">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="none">
                        <g clip-path="url(#np1)">
                            <path
                                d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="np1">
                                <rect width="16" height="16" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="fw-bold" style="font-size:0.78rem;">Protein</span>
                </div>
                <div class="macro-num" style="color:#00A63E;">10 <span style="font-size:0.9rem;">g</span></div>
                <p class="macro-pct mb-1">20% of daily value</p>
                <div class="macro-bar">
                    <div class="macro-bar-fill" style="width:20%;background:#00A63E;"></div>
                </div>
            </div>

            {{-- Carbs --}}
            <div class="macro-card">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3C7 3 4 7 4 11C4 15 7 18 12 18C17 18 20 15 20 11C20 7 17 3 12 3Z" stroke="#FBBF24"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 18V21M16 18V21" stroke="#FBBF24" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span class="fw-bold" style="font-size:0.78rem;">Carbs</span>
                </div>
                <div class="macro-num" style="color:#FBBF24;">25 <span style="font-size:0.9rem;">g</span></div>
                <p class="macro-pct mb-1">17% of daily value</p>
                <div class="macro-bar">
                    <div class="macro-bar-fill" style="width:17%;background:#FBBF24;"></div>
                </div>
            </div>

            {{-- Fat --}}
            <div class="macro-card">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8 2 5 5 5 9C5 13 8 16 12 22C16 16 19 13 19 9C19 5 16 2 12 2Z" stroke="#FB923C"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="fw-bold" style="font-size:0.78rem;">Fat</span>
                </div>
                <div class="macro-num" style="color:#FB923C;">12 <span style="font-size:0.9rem;">g</span></div>
                <p class="macro-pct mb-1">18% of daily value</p>
                <div class="macro-bar">
                    <div class="macro-bar-fill" style="width:18%;background:#FB923C;"></div>
                </div>
            </div>
        </div>

        {{-- Breakdown + Right panels --}}
        <div class="row py-0 g-3">
            {{-- Nutrition breakdown --}}
            <div class="col-12 col-md-6">
                <div class="breakdown-panel h-100">
                    <h6 class="fw-bold mb-3">Nutrition Breakdown</h6>
                    @php
                        $breakdown = [
                            ['label' => 'Calories', 'val' => '280 kcal', 'pct' => 14, 'color' => '#FF6900'],
                            ['label' => 'Protein', 'val' => '10 g', 'pct' => 20, 'color' => '#00A63E'],
                            ['label' => 'Carbohydrates', 'val' => '25 g', 'pct' => 17, 'color' => '#FBBF24'],
                            ['label' => 'Fat', 'val' => '12 g', 'pct' => 18, 'color' => '#FB923C'],
                            ['label' => 'Fiber', 'val' => '5 g', 'pct' => 18, 'color' => '#A78BFA'],
                            ['label' => 'Sugar', 'val' => '6 g', 'pct' => 12, 'color' => '#F87171'],
                            ['label' => 'Sodium', 'val' => '180 mg', 'pct' => 8, 'color' => '#94A3B8'],
                        ];
                    @endphp
                    @foreach ($breakdown as $row)
                        <div class="breakdown-row d-flex align-items-center gap-2">
                            <span
                                style="font-size:0.8rem; font-weight:{{ $row['label'] === 'Carbohydrates' ? '700' : '400' }}; min-width:110px;">{{ $row['label'] }}</span>
                            <span style="font-size:0.8rem; min-width:60px; text-align:right;">{{ $row['val'] }}</span>
                            <div class="bd-bar flex-grow-1">
                                <div class="bd-bar-fill"
                                    style="width:{{ $row['pct'] }}%; background:{{ $row['color'] }};"></div>
                            </div>
                            <span
                                style="font-size:0.75rem; color:#6B7280; min-width:30px; text-align:right;">{{ $row['pct'] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Ingredients + How to Prepare --}}
            <div class="col-12 col-md-6 d-flex flex-column gap-3">
                {{-- Ingredients --}}
                <div class="info-panel">
                    <h6 class="fw-bold mb-3">Ingredients</h6>
                    @php
                        $ingredients = [
                            ['name' => 'Whole grain bread', 'color' => '#94A3B8'],
                            ['name' => 'Avocado', 'color' => '#95CD41'],
                            ['name' => 'Egg', 'color' => '#FBBF24'],
                            ['name' => 'Olive oil', 'color' => '#FB923C'],
                            ['name' => 'Salt', 'color' => '#F87171'],
                            ['name' => 'Black pepper', 'color' => '#374151'],
                        ];
                    @endphp
                    @foreach ($ingredients as $ing)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="ing-dot" style="background:{{ $ing['color'] }};"></span>
                            <span style="font-size:0.82rem;">{{ $ing['name'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- How to Prepare --}}
                <div class="info-panel">
                    <h6 class="fw-bold mb-3">How To Prepare</h6>
                    @php
                        $steps = [
                            'Toast the bread until golden brown.',
                            'Mash the avocado and spread it on the toast.',
                            'Fry or poach the egg to your liking.',
                            'Place the egg on top of the avocado toast.',
                            'Season with salt and black pepper. Enjoy!',
                        ];
                    @endphp
                    @foreach ($steps as $i => $step)
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <span class="step-circle">{{ $i + 1 }}</span>
                            <span style="font-size:0.82rem; line-height:1.5;">{{ $step }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
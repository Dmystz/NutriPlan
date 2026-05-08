{{--
    meal_template.blade.php
    ───────────────────────
    Supports two rendering modes:

    1. DAYS VIEW (timeline mode) — pass these variables via @include:
       $time        (string)  e.g. '8:00'
       $meal_type   (string)  e.g. 'BREAKFAST'
       $meal_name   (string)  e.g. 'Avocado Toast & Poached Eggs'
       $meal_image  (string)  filename in public/img/, e.g. 'meal1_home.png'
       $ktg1_label  (string)  first category label
       $ktg1_class  (string)  first category CSS class (ktg-oren-home / ktg-ijo-home)
       $ktg2_label  (string)  second category label
       $ktg2_class  (string)  second category CSS class
       $kcal        (string)  calorie count, e.g. '420'
       $protein     (string)  protein grams, e.g. '22'
       $is_last     (bool)    true = hide the connecting line below the dot

    2. DEFAULT VIEW (card mode) — @include with no variables → original layout
--}}

@if (isset($time))
    {{-- ============================================================ --}}
    {{--  DAYS VIEW — timeline row with time + orange dot + meal card  --}}
    {{-- ============================================================ --}}
    <div class="d-flex align-items-start mb-3 timeline-meal-row">

        {{-- Time label --}}
        <div class="meal-time-col">
            <span class="meal-time-text">{{ $time }}</span>
        </div>

        {{-- Orange dot + vertical connecting line --}}
        <div class="meal-timeline-col">
            <div class="meal-dot-timeline"></div>
            @unless ($is_last ?? false)
                <div class="meal-line-timeline"></div>
            @endunless
        </div>

        {{-- Meal card --}}
        <div class="wrapper-content-meal-days d-flex px-2 py-2 flex-grow-1">

            {{-- Food image --}}
            <div class="d-flex align-items-center flex-shrink-0">
                <img src="{{ asset('img/' . ($meal_image ?? 'meal1_home.png')) }}" alt="{{ $meal_name ?? 'Meal' }}"
                    class="gambar-meal">
            </div>

            {{-- Meal info --}}
            <div class="d-flex flex-column ms-2 justify-content-center">

                {{-- Meal type (BREAKFAST / LUNCH etc.) --}}
                <p class="type-meal m-0 p-0">{{ $meal_type ?? 'MEAL' }}</p>

                {{-- Meal name --}}
                <h6 class="name-meal mb-1 p-0 fw-bold">{{ $meal_name ?? 'Meal Name' }}</h6>

                {{-- Category badges --}}
                <p class="category-meal d-flex mb-1 gap-1 fw-bold flex-wrap">
                    @if (isset($ktg1_label))
                        <span class="text-white px-1 {{ $ktg1_class ?? 'ktg-oren-home' }}">{{ $ktg1_label }}</span>
                    @endif
                    @if (isset($ktg2_label))
                        <span class="text-white px-1 {{ $ktg2_class ?? 'ktg-ijo-home' }}">{{ $ktg2_label }}</span>
                    @endif
                </p>

                {{-- Nutrition info --}}
                <div class="d-flex align-items-center gap-3 nutrition-meal flex-wrap">

                    {{-- Calories --}}
                    <div class="d-flex align-items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <p class="font-size-s m-0">{{ $kcal ?? '0' }} kcal</p>
                    </div>

                    {{-- Protein --}}
                    <div class="d-flex align-items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <g clip-path="url(#clip0_634_497b)">
                                <path
                                    d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_634_497b">
                                    <rect width="16" height="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p class="font-size-s m-0">{{ $protein ?? '0' }}g protein</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@else
    {{-- ============================================================ --}}
    {{--  DEFAULT VIEW — original card layout (backward compatible)   --}}
    {{-- ============================================================ --}}
    <div class="wrapper-content-meal-home d-flex px-2 py-2">
        <div class="align-items-center d-flex">
            {{-- Batas ukuran gambar 96 x 96 px ada di class gambar-meal --}}
            <img src="{{ asset('img/meal1_home.png') }}" alt="" class="gambar-meal">
        </div>
        <div class="d-flex flex-column ms-2">
            {{-- Type meal --}}
            <p class="type-meal m-0 p-o">Breakfast</p>
            {{-- Name meal --}}
            <h6 class="name-meal mb-1 p-0 fw-bold">Avocado Toast & Poached Eggs</h6>
            {{-- Category Meal --}}
            <p class="category-meal d-flex mb-1 gap-1 fw-bold">
                <span class="text-white px-1 ktg-oren-home">Quick Meal</span>
                <span class="text-white px-1 ktg-ijo-home">Balanced</span>
            </p>
            <div class="d-flex align-items-center gap-3 nutrition-meal">
                <div class="d-flex align-items-center">
                    {{-- Ikon kalori --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                            stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{-- Jumlah kalori --}}
                    <p class="font-size-s m-0">420 kcal</p>
                </div>
                <div class="d-flex align-items-center">
                    {{-- Ikon protein --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <g clip-path="url(#clip0_634_497)">
                            <path
                                d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_634_497">
                                <rect width="16" height="16" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    {{-- Jumlah protein --}}
                    <p class="font-size-s m-0">22g protein</p>
                </div>
            </div>
        </div>
    </div>
@endif
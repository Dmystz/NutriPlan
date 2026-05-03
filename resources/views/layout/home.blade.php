@extends('layout.layout')

{{-- Section homepage --}}

@section('title', 'Homepage')
@section('content')
    <div class="col-10">
        <div class="row py-0">
            <div class="col-4">
                <h5 class="fw-bold">Selamat datang, {{ session('user_name') }}</h5>
                {{-- Jumlah activity itu berdasarkan input pengguna --}}
                <p class="tgl">You have 0 activity today</p>
                <h4 class="mb-1 fw-500">Meal plan - Today</h4>
                {{-- Menampilkann tanggal --}}
                <p class="text-muted tgl">{{ date('l, d F Y') }}</p>

            </div>

            <div class="col-8">
                {{-- Search bar --}}
                <div class="position-relative">
                    <span id="input-group-sizing-sm"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        class="position-absolute lup">
                        <path
                            d="M20 20L18.4 18.4M4 11.6C4 7.40264 7.40263 4 11.6 4C15.7974 4 19.2 7.40264 19.2 11.6C19.2 15.7974 15.7974 19.2 11.6 19.2C7.40263 19.2 4 15.7974 4 11.6Z"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input type="text" class="form-control" aria-label="search bar home"
                        aria-describedby="form di homepage" placeholder="Search by recipes and more">
                </div>

            </div>
            {{-- Container meal & drink --}}
            <div class="col-5 pb-3">
                {{-- Wadah untuk meals-list dan headernya --}}
                <div class="wrapper-meal-home">
                    <div class="header-meals d-flex justify-content-between align-items-center mb-1">
                        <h5 class="m-0">Meals & Drinks</h5>
                        {{-- Jumlah meal (bergantung pada wrapper-content-meal-home) dan water bergantung pada input user --}}
                        <p class="text-muted tgl m-0">1 Meals - 1.2L Water</p>
                    </div>
                    {{-- Wadah untuk wrapper-content-meal-home --}}
                    <div class="meals-list gap-3">
                        {{-- Template untuk konten di meal --}}
                        {{-- Data gambar, type meal, name meal, category meal, dan nutrition meal diambil dari database --}}
                        @include('components.meal_template')
                    </div>

                </div>
            </div>
            <div class="col-7 d-flex justify-content-evenly flex-wrap">
                <div class="wrapper-report-home">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                            fill="none">
                            <path
                                d="M10 5H8C6.343 5 5 6.343 5 8V32C5 33.657 6.343 35 8 35H32C33.657 35 35 33.657 35 32V8C35 6.343 33.657 5 32 5H30V7H32C32.552 7 33 7.448 33 8V32C33 32.552 32.552 33 32 33H8C7.448 33 7 32.552 7 32V8C7 7.448 7.448 7 8 7H10V5Z"
                                fill="black" />
                            <path
                                d="M22 4C22.552 4 23 4.448 23 5V7C23 7.552 22.552 8 22 8H18C17.448 8 17 7.552 17 7V5C17 4.448 17.448 4 18 4H22ZM18 3C16.895 3 16 3.895 16 5V7C16 8.105 16.895 9 18 9H22C23.105 9 24 8.105 24 7V5C24 3.895 23.105 3 22 3H18Z"
                                fill="black" />

                            <g transform="translate(13,12)">
                                <path
                                    d="M0 10C0 9.17157 0.671573 8.5 1.5 8.5C2.32843 8.5 3 9.17157 3 10V12C3 12.8284 2.32843 13.5 1.5 13.5C0.671573 13.5 0 12.8284 0 12V10Z"
                                    fill="black" />
                                <path
                                    d="M4.5 7C4.5 6.17157 5.17157 5.5 6 5.5C6.82843 5.5 7.5 6.17157 7.5 7V12C7.5 12.8284 6.82843 13.5 6 13.5C5.17157 13.5 4.5 12.8284 4.5 12V7Z"
                                    fill="black" />
                                <path
                                    d="M9 3C9 2.17157 9.67157 1.5 10.5 1.5C11.3284 1.5 12 2.17157 12 3V12C12 12.8284 11.3284 13.5 10.5 13.5C9.67157 13.5 9 12.8284 9 12V3Z"
                                    fill="black" />
                            </g>
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Reports</h6>
                        <p class="tgl m-0">Goal this week</p>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="card-6 d-flex p-0">
                            <div class="crd6-content px-1 py-2">
                                <div class="p-0 d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <g clip-path="url(#clip0_222_514)">
                                            <path
                                                d="M3.5 8.14999C4.6 8.14999 5.5 7.23499 5.5 6.12499C5.5 5.54499 5.215 4.99499 4.645 4.52999C4.075 4.06499 3.645 3.37499 3.5 2.64999C3.355 3.37499 2.93 4.06999 2.355 4.52999C1.78 4.98999 1.5 5.54999 1.5 6.12499C1.5 7.23499 2.4 8.14999 3.5 8.14999Z"
                                                stroke="#2B7FFF" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M6.28004 3.29999C6.62392 2.75056 6.86769 2.14452 7.00004 1.50999C7.25004 2.75999 8.00004 3.95999 9.00004 4.75999C10 5.55999 10.5 6.50999 10.5 7.50999C10.5029 8.20114 10.3005 8.87757 9.91844 9.45354C9.5364 10.0295 8.99195 10.4791 8.35411 10.7452C7.71627 11.0114 7.01375 11.0822 6.33563 10.9486C5.65751 10.8151 5.03431 10.4832 4.54504 9.99499"
                                                stroke="#2B7FFF" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_222_514">
                                                <rect width="12" height="12" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p class="p-water m-0">Water</p>
                                    <div class="d-flex align-items-center ms-auto">
                                        <p class="p-crd-home my-0">Daily Week</p>
                                    </div>
                                </div>
                                <div class="water-container position-relative">
                                    <div class="water-slide position-absolute">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-6 d-flex p-0">
                            <div class="crd6-content py-2 px-1">
                                <div class="p-0 d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M6 4C6.82843 4 7.5 3.32843 7.5 2.5C7.5 1.67157 6.82843 1 6 1C5.17157 1 4.5 1.67157 4.5 2.5C4.5 3.32843 5.17157 4 6 4Z"
                                            stroke="#AD46FF" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M3.25011 4C3.03374 4.00225 2.82393 4.07461 2.65218 4.20624C2.48044 4.33787 2.35602 4.52165 2.29761 4.73L1.05011 9.25C1.01231 9.39629 1.00815 9.54925 1.03795 9.69737C1.06775 9.8455 1.13072 9.98495 1.22215 10.1052C1.31357 10.2255 1.43107 10.3236 1.56581 10.3919C1.70055 10.4603 1.84904 10.4972 2.00011 10.5H10.0001C10.1544 10.4999 10.3067 10.4642 10.4449 10.3955C10.5831 10.3268 10.7035 10.227 10.7967 10.104C10.8899 9.98101 10.9534 9.8381 10.9822 9.68647C11.011 9.53484 11.0043 9.3786 10.9626 9.23L9.70011 4.75C9.64504 4.5367 9.52109 4.34756 9.3475 4.21194C9.1739 4.07632 8.96039 4.00182 8.74011 4H3.25011Z"
                                            stroke="#AD46FF" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="p-water m-0">Weight</p>
                                    <div class="d-flex align-items-center ms-auto">
                                        <p class="p-crd-home my-0">kg</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-6">
                            <div class="crd6-content py-2 px-1">
                                <div class="p-0 d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11 6H9.76C9.54148 5.99953 9.32883 6.07065 9.15456 6.20248C8.98029 6.33431 8.854 6.5196 8.795 6.73L7.62 10.91C7.61243 10.936 7.59664 10.9588 7.575 10.975C7.55336 10.9912 7.52705 11 7.5 11C7.47295 11 7.44664 10.9912 7.425 10.975C7.40336 10.9588 7.38757 10.936 7.38 10.91L4.62 1.09C4.61243 1.06404 4.59664 1.04123 4.575 1.025C4.55336 1.00877 4.52705 1 4.5 1C4.47295 1 4.44664 1.00877 4.425 1.025C4.40336 1.04123 4.38757 1.06404 4.38 1.09L3.205 5.27C3.14623 5.47958 3.02069 5.66426 2.84743 5.79601C2.67417 5.92776 2.46266 5.99938 2.245 6H1"
                                            stroke="#00C950" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="p-water m-0">BMI Status</p>
                                    <div class="d-flex align-items-center ms-auto">
                                        <p class="p-crd-home my-0">170 cm</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-6">
                            <div class="crd6-content py-2 px-1">
                                <div class="p-0 d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M4.25 7.25C4.58152 7.25 4.89946 7.1183 5.13388 6.88388C5.3683 6.64946 5.5 6.33152 5.5 6C5.5 5.31 5.25 5 5 4.5C4.464 3.4285 4.888 2.473 6 1.5C6.25 2.75 7 3.95 8 4.75C9 5.55 9.5 6.5 9.5 7.5C9.5 7.95963 9.40947 8.41475 9.23358 8.83939C9.05769 9.26403 8.79988 9.64987 8.47487 9.97487C8.14987 10.2999 7.76403 10.5577 7.33939 10.7336C6.91475 10.9095 6.45963 11 6 11C5.54037 11 5.08525 10.9095 4.66061 10.7336C4.23597 10.5577 3.85013 10.2999 3.52513 9.97487C3.20012 9.64987 2.94231 9.26403 2.76642 8.83939C2.59053 8.41475 2.5 7.95963 2.5 7.5C2.5 6.9235 2.7165 6.353 3 6C3 6.33152 3.1317 6.64946 3.36612 6.88388C3.60054 7.1183 3.91848 7.25 4.25 7.25Z"
                                            stroke="#FF6900" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="p-water m-0">Calories</p>
                                    <div class="d-flex align-items-center ms-auto">
                                        <p class="p-crd-home my-0">Daily Goals</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper-shop-home">
                    <div class="d-flex mb-0 align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M0 3.75C0 3.33579 0.335786 3 0.75 3H3C3.34415 3 3.64414 3.23422 3.72761 3.5681L4.33558 6H21.75C21.981 6 22.199 6.1064 22.3412 6.28844C22.4833 6.47048 22.5336 6.70785 22.4776 6.9319L20.2276 15.9319C20.1441 16.2658 19.8442 16.5 19.5 16.5H6C5.65585 16.5 5.35586 16.2658 5.27239 15.9319L2.41442 4.5H0.75C0.335786 4.5 0 4.16421 0 3.75ZM4.71058 7.5L5.46058 10.5H7.5V7.5H4.71058ZM9 7.5V10.5H12V7.5H9ZM13.5 7.5V10.5H16.5V7.5H13.5ZM18 7.5V10.5H20.0394L20.7894 7.5H18ZM19.6644 12H18V15H18.9144L19.6644 12ZM16.5 12H13.5V15H16.5V12ZM12 12H9V15H12V12ZM7.5 12H5.83558L6.58558 15H7.5V12ZM7.5 19.5C6.67157 19.5 6 20.1716 6 21C6 21.8284 6.67157 22.5 7.5 22.5C8.32843 22.5 9 21.8284 9 21C9 20.1716 8.32843 19.5 7.5 19.5ZM4.5 21C4.5 19.3431 5.84315 18 7.5 18C9.15685 18 10.5 19.3431 10.5 21C10.5 22.6569 9.15685 24 7.5 24C5.84315 24 4.5 22.6569 4.5 21ZM18 19.5C17.1716 19.5 16.5 20.1716 16.5 21C16.5 21.8284 17.1716 22.5 18 22.5C18.8284 22.5 19.5 21.8284 19.5 21C19.5 20.1716 18.8284 19.5 18 19.5ZM15 21C15 19.3431 16.3431 18 18 18C19.6569 18 21 19.3431 21 21C21 22.6569 19.6569 24 18 24C16.3431 24 15 22.6569 15 21Z"
                                fill="black" />
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Shopping List</h6>
                    </div>
                    <div class="wrapper-shop-list-home">
                        {{-- Untuk templating, id bisa menggunakan loop sebagai pembeda --}}
                        @include('components.shop_template')
                    </div>
                </div>
                <div class="wrapper-daily-home">
                    <div class="d-flex align-items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M3 2V9C3 10.1 3.9 11 5 11H9C9.53043 11 10.0391 10.7893 10.4142 10.4142C10.7893 10.0391 11 9.53043 11 9V2"
                                stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 2V22" stroke="black" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M21 15V2C19.6739 2 18.4021 2.52678 17.4645 3.46447C16.5268 4.40215 16 5.67392 16 7V13C16 14.1 16.9 15 18 15H21ZM21 15V22"
                                stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Daily Intake</h6>
                    </div>
                    <div class="wrapper-daily-list-home">
                        @include('components.layout-daily')
                    </div>

                </div>
                <div class="wrapper-daily-home">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M22 12H19.52C19.083 11.9991 18.6577 12.1413 18.3091 12.405C17.9606 12.6686 17.708 13.0392 17.59 13.46L15.24 21.82C15.2249 21.8719 15.1933 21.9175 15.15 21.95C15.1067 21.9825 15.0541 22 15 22C14.9459 22 14.8933 21.9825 14.85 21.95C14.8067 21.9175 14.7751 21.8719 14.76 21.82L9.24 2.18C9.22485 2.12807 9.19327 2.08246 9.15 2.05C9.10673 2.01754 9.05409 2 9 2C8.94591 2 8.89327 2.01754 8.85 2.05C8.80673 2.08246 8.77515 2.12807 8.76 2.18L6.41 10.54C6.29246 10.9592 6.04138 11.3285 5.69486 11.592C5.34835 11.8555 4.92532 11.9988 4.49 12H2"
                                stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Activity</h6>
                    </div>
                    <div class="wrapper-activity-home d-flex">
                        @include('components.activity_home')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 pb-3">
        <div class="wrapper-home1 py-2 d-flex m-0">
            {{-- Ini untuk rekomendasi resep --}}
            {{-- Templating rekomendasi resep --}}
            @include('components.recipes_recomendation')
        </div>
    </div>
@endsection

@extends('layout.layout')

{{-- Section homepage --}}

@section('title', 'Homepage')
@section('content')
    <div class="col-10 border">
        <div class="row py-0">
            <div class="col-4">
                <h5 class="fw-bold">Selamat datang, {{ session('user_name') }}</h5>
                <p class="tgl">Let's set up your meal plan with NutriPlan.</p>
                <h4 class="mb-1 fw-500">Meal plan - Today</h4>
                <p class="text-muted tgl">{{ date('l, d F Y') }}</p>

            </div>

            <div class="col-8">
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
            <div class="col-4 border">
                <div class="wrapper-meal-home">

                </div>
            </div>
            <div class="col-8 d-flex justify-content-evenly flex-wrap">
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
                </div>
                <div class="wrapper-report-home">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M0 3.75C0 3.33579 0.335786 3 0.75 3H3C3.34415 3 3.64414 3.23422 3.72761 3.5681L4.33558 6H21.75C21.981 6 22.199 6.1064 22.3412 6.28844C22.4833 6.47048 22.5336 6.70785 22.4776 6.9319L20.2276 15.9319C20.1441 16.2658 19.8442 16.5 19.5 16.5H6C5.65585 16.5 5.35586 16.2658 5.27239 15.9319L2.41442 4.5H0.75C0.335786 4.5 0 4.16421 0 3.75ZM4.71058 7.5L5.46058 10.5H7.5V7.5H4.71058ZM9 7.5V10.5H12V7.5H9ZM13.5 7.5V10.5H16.5V7.5H13.5ZM18 7.5V10.5H20.0394L20.7894 7.5H18ZM19.6644 12H18V15H18.9144L19.6644 12ZM16.5 12H13.5V15H16.5V12ZM12 12H9V15H12V12ZM7.5 12H5.83558L6.58558 15H7.5V12ZM7.5 19.5C6.67157 19.5 6 20.1716 6 21C6 21.8284 6.67157 22.5 7.5 22.5C8.32843 22.5 9 21.8284 9 21C9 20.1716 8.32843 19.5 7.5 19.5ZM4.5 21C4.5 19.3431 5.84315 18 7.5 18C9.15685 18 10.5 19.3431 10.5 21C10.5 22.6569 9.15685 24 7.5 24C5.84315 24 4.5 22.6569 4.5 21ZM18 19.5C17.1716 19.5 16.5 20.1716 16.5 21C16.5 21.8284 17.1716 22.5 18 22.5C18.8284 22.5 19.5 21.8284 19.5 21C19.5 20.1716 18.8284 19.5 18 19.5ZM15 21C15 19.3431 16.3431 18 18 18C19.6569 18 21 19.3431 21 21C21 22.6569 19.6569 24 18 24C16.3431 24 15 22.6569 15 21Z"
                                fill="black" />
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Shopping List</h6>
                    </div>
                </div>
                <div class="wrapper-daily-home">
                    <div class="d-flex align-items-center">
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
                </div>
                <div class="wrapper-activity-home">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M22 12H19.52C19.083 11.9991 18.6577 12.1413 18.3091 12.405C17.9606 12.6686 17.708 13.0392 17.59 13.46L15.24 21.82C15.2249 21.8719 15.1933 21.9175 15.15 21.95C15.1067 21.9825 15.0541 22 15 22C14.9459 22 14.8933 21.9825 14.85 21.95C14.8067 21.9175 14.7751 21.8719 14.76 21.82L9.24 2.18C9.22485 2.12807 9.19327 2.08246 9.15 2.05C9.10673 2.01754 9.05409 2 9 2C8.94591 2 8.89327 2.01754 8.85 2.05C8.80673 2.08246 8.77515 2.12807 8.76 2.18L6.41 10.54C6.29246 10.9592 6.04138 11.3285 5.69486 11.592C5.34835 11.8555 4.92532 11.9988 4.49 12H2"
                                stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h6 class="fw-bold mb-0 mx-2">Activity</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 pb-5 border">
        <div class="wrapper-home1">

        </div>
    </div>
@endsection

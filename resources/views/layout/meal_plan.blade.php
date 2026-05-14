@extends('layout.layout')

@section('title', 'Meal Plan')

@section('content')

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="col-12">
        <div class="row g-0 py-0">

            {{-- HEADER --}}
            <div class="col-12 border p-3 rounded-3 mb-3">
                <h5 class="fw-bold m-0 p-0">
                    Hello, {{ session('user_name') }}
                </h5>

                <p class="tgl m-0 p-0">
                    Let's set up your meal plan with NutriPlan.
                </p>

                {{-- Toggle --}}
                <div class="btn-kalender mt-3">
                    <div class="d-flex gap-2" role="group" aria-label="Toggle hari dan minggu">

                        {{-- DAYS --}}
                        <input
                            type="radio"
                            class="btn-check"
                            name="btnradio"
                            id="hari"
                            autocomplete="off"
                            value="hari"
                            checked
                        >

                        <label for="hari" class="btn btn-outline-light bg-radio">
                            Days
                        </label>

                        {{-- WEEK --}}
                        <input
                            type="radio"
                            class="btn-check"
                            name="btnradio"
                            id="minggu"
                            autocomplete="off"
                            value="minggu"
                        >

                        <label for="minggu" class="btn btn-outline-light bg-radio">
                            Week
                        </label>

                    </div>
                </div>
            </div>

            {{-- DAYS SECTION --}}
            <div id="days-section" class="col-12">
                @include('components.days_meal_plan')
            </div>

            {{-- WEEK SECTION --}}
            <div id="week-section" class="col-12 d-none">
                @include('components.week_meal_plan')
            </div>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const daysSection = document.getElementById('days-section');
        const weekSection = document.getElementById('week-section');
        const hariRadio   = document.getElementById('hari');
        const mingguRadio = document.getElementById('minggu');

        /* ── Fungsi switch tab ── */
        function switchTab(tab) {
            if (tab === 'minggu') {
                weekSection.classList.remove('d-none');
                daysSection.classList.add('d-none');
                mingguRadio.checked = true;
            } else {
                daysSection.classList.remove('d-none');
                weekSection.classList.add('d-none');
                hariRadio.checked = true;
            }
            localStorage.setItem('mealPlanTab', tab);
        }

        /* ── Restore tab terakhir saat load/refresh ── */
        switchTab(localStorage.getItem('mealPlanTab') ?? 'hari');

        /* ── Listener klik radio ── */
        document.querySelectorAll("input[name='btnradio']").forEach(function (radio) {
            radio.addEventListener('change', function () {
                switchTab(this.value);
                (this.value === 'hari' ? daysSection : weekSection)
                    .scrollIntoView({ behavior: 'smooth' });
            });
        });
    });
    </script>

@endsection
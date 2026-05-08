@extends('layout.layout')

{{-- Section meal plan --}}

@section('title', 'Meal Plan')
@section('content')

    <div class="col-12">
        <div class="row g-0 py-0">
            <div class="col-12 border">
                <h5 class="fw-bold m-0 p-0">Hello, {{ session('user_name') }}</h5>
                <p class="tgl m-0 p-0">Let's set up your meal plan with NutriPlan.</p>
                <div class="btn-kalender mt-3">
                    <div class="d-flex gap-2" role="group" aria-label="Toggle hari dan minggu">
                        <input type="radio" class="btn-check" name="btnradio" id="hari" autocomplete="off"
                            value="hari" checked>
                        <label for="hari" class="btn btn-outline-light bg-radio">Days</label>
                        <input type="radio" class="btn-check" name="btnradio" id="minggu" autocomplete="off"
                            value="minggu">
                        <label for="minggu" class="btn btn-outline-light bg-radio">Week</label>
                    </div>
                </div>
            </div>
            <div id="days-section">
                @include('components.days_meal_plan')
            </div>
            <div id="week-section">
                @include('components.week_meal_plan')
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const daysSection = document.getElementById("days-section");
            const weekSection = document.getElementById("week-section");

            // Default: tampilkan Days, sembunyikan Week
            daysSection.classList.remove("d-none");
            weekSection.classList.add("d-none");

            // Event listener untuk radio buttons
            document.querySelectorAll("input[name='btnradio']").forEach(function(radio) {
                radio.addEventListener("change", function() {
                    if (this.value === "hari") {
                        daysSection.classList.remove("d-none");
                        weekSection.classList.add("d-none");
                        daysSection.scrollIntoView({
                            behavior: "smooth"
                        });
                    } else if (this.value === "minggu") {
                        weekSection.classList.remove("d-none");
                        daysSection.classList.add("d-none");
                        weekSection.scrollIntoView({
                            behavior: "smooth"
                        });
                    }
                });
            });
        });
    </script>
@endsection
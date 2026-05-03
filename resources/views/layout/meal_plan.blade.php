@extends('layout.layout')

{{-- Section meal plan --}}

@section('title', 'Meal Plan')
@section('content')
    <div class="col-9 border">
        <div class="row py-0">
            <div class="col-4 border">
                <h5 class="fw-bold">Hello, {{ session('user_name') }}</h5>
                <p class="tgl">Let's set up your meal plan with NutriPlan.</p>
                <div class="btn-kalender">
                    <div class="d-flex gap-2" role="group" aria-label="Toggle hari dan minggu">
                        <input type="radio" class="btn-check" name="btnradio" id="hari" autocomplete="off"
                            value="hari" checked>
                        <label for="hari" class="btn btn-outline-light bg-radio">Days</label>
                        <input type="radio" class="btn-check" name="btnradio" id="minggu" autocomplete="off"
                            value="minggu">
                        <label for="minggu" class="btn btn-outline-light bg-radio">Week</label>
                    </div>
                </div>
                <div class="p-2 border">
                    <h5 class="mb-1 fw-bold">Meal plan - Today</h5>
                    <p class="text-muted tgl">{{ date('l, d F Y') }}</p>
                </div>

            </div>
            <div class="col-8 border">

            </div>
        </div>
    </div>
    <div class="col-3 border-5 border">

    </div>
@endsection

@extends('layout.layout')

{{-- Section homepage --}}

@section('content')
    <div class="col-9 border">
        <div class="row py-0">
            <div class="col-4 border">
                <h5 class="fw-bold">Selamat datang, {{ session('user_name') }}</h5>
                <p>You have activity ...</p>
            </div>
            <div class="col-8 border">
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
        </div>
    </div>
    <div class="col-3 border-5 border">

    </div>
    <a href="/logout">Logout</a>
@endsection

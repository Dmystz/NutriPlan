<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Font style */

        @font-face {
            font-family: "SF Pro Display";
            src: url("fonts/SFProDisplay-Regular.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        /* Styling element */

        :root {
            font-size: 16px;
        }

        body {
            font-family: "SF Pro Display", sans-serif;
        }

        .navbar {
            height: 5rem;
            align-items: center;
            backdrop-filter: blur(24px);
            z-index: 1000;
            top: 0;
        }

        .prg {
            padding: 0 3vw;
        }

        .navbar-brand {
            margin-left: 6vw;
        }

        #navbarSupportedContent {
            width: 100%;
        }

        .konten {
            animation: fadeIn 0.5s ease;
        }

        .row {
            padding-top: 5rem;
        }

        .navbar-nav {
            gap: 1rem;
        }

        .nutri {
            color: #95cd41;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .plan {
            color: #ea5c2b;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .ijo {
            background-color: #95cd41;
            transition: all 0.3s ease;
        }

        .ijo:hover {
            background-color: #6e9c29;
        }

        .oren {
            background-color: #ea5c2b;
            transition: all 0.3s ease;
        }

        .oren:hover {
            background-color: #cd4c22;
        }

        .nav-link {
            font-size: 1rem;
        }

        .pg1-h1 {
            color: #ffcc00;
        }

        h1 {
            font-size: 2.9rem;
        }

        h2 {
            color: #ffcc00;
        }

        .pg2-h1 {
            text-align: center;
            background: linear-gradient(90deg, #fc0 30%, #ff7f3f 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pg3-h1 {
            text-align: center;
            background: linear-gradient(90deg, #ea5c2b 0%, #ffcc00 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pg3-h2 {
            color: black;
            text-align: center;
        }

        .parag-homepage {
            color: #ea5c2b;
        }

        .lat-blkg {
            background: linear-gradient(to top right, #ffd8df, #f0ffdf);
        }

        .brokoli {
            z-index: 2;
            position: absolute;
            top: 0;
            right: 0;
            transform: rotate(-12.98deg);
            width: 80px;
        }

        .elip1 {
            z-index: 1;
            top: 8%;
            right: 4%;
            position: absolute;
            width: 65px;
        }

        .plate {
            position: absolute;
            width: 350px;
        }

        .wortel {
            position: absolute;
            z-index: 2;
            bottom: 2%;
            left: 13%;
            width: 80px;
        }

        .elip2 {
            position: absolute;
            z-index: 1;
            bottom: 0;
            left: 0;
            width: 60px;
        }

        .protein {
            width: 250px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .serat {
            width: 320px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .wadah {
            min-height: 350px;
            max-height: 350px;
        }

        .jagung {
            position: absolute;
            z-index: 2;
            right: 0;
            bottom: 8%;
            width: 90px;
        }

        .p-card {
            font-size: 0.8rem;
        }

        .p-card2 {
            font-size: 0.625rem;
            font-weight: bold;
        }

        .p-card3 {
            font-size: 0.5rem;
            color: rgba(106, 114, 130, 1);
        }

        .tgl-day {
            border-radius: 4px;
            background: #f9fafb;
            min-width: 13%;
            padding-top: 2px;
        }

        .checklist {
            width: 1rem;
            height: 1rem;
            border-radius: 6px;
            border: 1px solid #000;
            position: relative;
        }

        .checklist::after {
            content: "";
            background: #000;
            height: 20px;
            width: 20px;
            top: 0;
            left: 0;
        }

        .tgl-day1 {
            border-radius: 4px;
            background: rgba(43, 127, 255, 1);
            min-width: 13%;
            padding-top: 2px;
        }

        .elm {
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .elip3 {
            position: absolute;
            z-index: 1;
            bottom: 0;
            right: 0;
            width: 90px;
        }

        .card-5 {
            width: 13rem;
            height: 15rem;
            background: #f4e8b8;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .card-1 {
            width: 18rem;
            min-height: 12rem;
            background: #fff;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .card-2 {
            width: 18rem;
            height: 28.5rem;
            background: #fff;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            z-index: 1;
        }

        .card-3 {
            width: 27rem;
            height: 12rem;
            border-radius: 10px;
            border: 1px solid #000;
            background: #fff;
            box-shadow: 10px 10px 10px 0 rgba(0, 0, 0, 0.25);
            z-index: 2;
            right: 0;
            bottom: 0;
        }

        .card-4 {
            width: 20rem;
            min-height: 35rem;
            background: rgba(139, 136, 136, 1);
            border-radius: 10px;
            z-index: 1;
        }

        #planner {
            padding-bottom: 5rem;
        }

        .pnl-pg5 {
            background: white;
            border-radius: 8px;
        }

        .clock-history {
            width: 1.5rem;
        }

        .txt-3 {
            color: black;
            font-size: 0.75rem;
        }

        .fw-500 {
            font-weight: 500;
        }

        .scale-1 {
            width: 25%;
            height: 10px;
            background: #95cd41;
            border-radius: 10px;
        }

        .scale-2 {
            width: 25%;
            height: 10px;
            background: #3cb12c;
            border-radius: 10px;
        }

        .scale-3 {
            width: 25%;
            height: 10px;
            background: #fb923c;
            border-radius: 10px;
        }

        .scale-4 {
            width: 25%;
            height: 10px;
            background: #e4680f;
            border-radius: 10px;
        }

        .n1950 {
            color: #f00;
            font-style: normal;
            font-weight: 700;
            line-height: 15px;
            font-size: 1.3rem;
        }

        .kcal {
            color: #000;
            font-style: normal;
            font-weight: 700;
            line-height: 15px;
        }

        .txt-1 {
            color: #446611;
            font-weight: 700;
        }

        .txt-2 {
            color: #ea5c2b;
            font-weight: 700;
        }

        .Num-ijo {
            font-weight: 700;
            background: #95cd41;
            padding: 0 0.5rem;
            border-radius: 200px;
        }

        .btn {
            height: auto;
            line-height: 1.2;
        }

        .Num-oren {
            font-weight: 700;
            background: #ea5c2b;
            padding: 0 0.5rem;
            border-radius: 200px;
        }

        .ktg-ijo {
            background: #95cd41;
            font-size: 0.625rem;
            padding: 0 0.5rem;
            border-radius: 5px;
        }

        .ktg-oren {
            background: #ea5c2b;
            font-size: 0.625rem;
            padding: 0 0.5rem;
            border-radius: 5px;
        }

        .prg-1 {
            padding: 0 3vw;
        }

        /* Media breakpoint*/

        @media (max-width: 1199px) {
            #navbarSupportedContent {
                position: absolute;
                top: 5rem;
                width: 100vw;
                background-color: rgba(255, 255, 255, 0.7);
                z-index: 1000;
            }

            .navbar-collapse.show {
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
            }

            .prg {
                padding-right: 3vw;
                min-height: calc(100vh - 5rem);
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .item {
                margin: 0 auto;
                width: 18.75rem;
            }
        }

        @media (max-width: 576px) {
            .brokoli {
                top: 47%;
                right: 6%;
            }

            .elip1 {
                top: 50%;
            }

            .jagung {
                bottom: 50%;
                width: 50px;
            }

            .elip3 {
                bottom: 45%;
                width: 50px;
            }

            .wortel {
                width: 90%;
                left: 28%;
                bottom: 2%;
            }

            .elip2 {
                width: 70%;
                left: 0;
            }
        }

        @media (min-width: 577px) and (max-width: 767px) {
            .brokoli {
                top: 20%;
                right: 8%;
            }

            .elip1 {
                top: 22%;
            }

            .jagung {
                width: 50%;
                bottom: 30%;
            }

            .elip3 {
                width: 50%;
                bottom: 25%;
            }
        }

        @media (max-width: 768px) {
            .plate {
                bottom: 0;
                left: 0;
            }

            .cust-btn {
                width: 200px;
            }
        }

        @media screen and (min-width: 769px) and (max-width: 991px) {
            .brokoli {
                top: 4%;
                right: 5%;
                width: 70px;
            }
        }

        .navbar-collapse {
            margin-right: 3vw;
        }

        @media screen and (min-width: 769px) and (max-width: 1199px) {
            .plate {
                top: 0;
                left: 0;
            }
        }

        @media (min-width: 1200px) {
            .item {
                width: 100%;
            }

            .plate {
                top: 0;
                left: 0;
            }
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl navbar-light fixed-top">
        <div class="container-fluid ps-0">
            <!-- Logo -->
            <div class="d-flex flex-grow-1 position-relative">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo NutriPlan" width="37px" height="37px">
                    <span class="nutri">Nutri</span><span class="plan">Plan</span>
                </a>
            </div>
            <!-- Button navbar responsive -->
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Elemen navbar -->
            <div class="collapse navbar-collapse py-xl-3 py-4" id="navbarSupportedContent">
                <div class="d-flex justify-content-center flex-grow-1">
                    <ul class="navbar-nav mb-xl-0 align-items-center mb-3">
                        <li class="nav-item">
                            <a class="me-xl-2 btn text-center nav-link ijo rounded-pill text-white fw-bold item"
                                aria-current="page" data-nutri="Index" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link oren rounded-pill text-white fw-bold item"
                                href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link ijo rounded-pill text-white fw-bold item"
                                href="#recipes">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link oren rounded-pill text-white fw-bold item"
                                href="#calculator">Calculator</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link ijo rounded-pill text-white fw-bold item"
                                href="#planner">Planner</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center flex-grow-0">
                    <ul class="navbar-nav align-items-center mb-xl-0">
                        <li class="nav-item item">
                            <a class="btn text-center nav-link oren rounded-pill text-white px-5 fw-bold"
                                href="{{ route('login') }}">Log In/Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <!-- Isi konten -->
        <div class="container-fluid min-vh-100 lat-blkg px-4 konten" id="home" width="100%">
            <!-- Page 1 -->
            <div class="row min-vh-100 align-items-center mb-5">
                <!-- Paragraf -->
                <div class="col-6 prg">
                    <h1 class="pg1-h1 fw-bold col-6 text-wrap">Cook Smart, Waste Less</h1>
                    <h2 class="fw-bold">Smart Meal Planning for a Healthier Life</h2>
                    <p class="parag-homepage fw-bold">
                        Plan healthier meals based on your BMI, calorie needs, and dietary preferences.
                        NutriPlan helps you create personalized meal plans using BMI analysis,
                        nutrition data, and smart recommendations.
                    </p>
                    <!-- Button main -->
                    <div class="col-md-12 d-md-flex">
                        <a href="#"
                            class="cust-btn btn ijo text-white rounded-pill fw-bold px-md-4 me-md-3 my-2">Calculate Your
                            Plan</a>
                        <a href="#"
                            class="cust-btn btn oren text-white rounded-pill fw-bold px-md-4 ms-md-3 my-2">Explore
                            Recipes</a>
                    </div>
                </div>
                <!-- Elemen gambar -->
                <div class="container col-6">
                    <div class="row text-center">
                        <div class="col-2 position-relative">
                            <img src="{{ asset('img/brokoli.png') }}" alt="" class="img-fluid brokoli">
                            <img src="{{ asset('img/Ellipse 3.png') }}" alt="" class="elip1 img-fluid">
                        </div>
                        <div class="col-8 position-relative">
                            <img src="{{ asset('img/tanaman.png') }}" alt="Ini plate" class="img-fluid plate">
                        </div>
                        <div class="col-2 position-relative wadah">
                            <img src="{{ asset('img/wortel.png') }}" alt="" class="wortel img-fluid">
                            <img src="{{ asset('img/Ellipse 1.png') }}" alt="" class="elip2 img-fluid">
                        </div>
                        <div class="col-xl-6 col-5 position-relative wadah">
                            <img src="{{ asset('img/protein.png') }}" alt="" class="img-fluid protein">
                            <img src="{{ asset('img/jagung.png') }}" alt="" class="img-fluid jagung">
                            <img src="{{ asset('img/Ellipse 2.png') }}" alt="" class="img-fluid elip3">
                        </div>
                        <div class="col-xl-6 col-7 position-relative wadah">
                            <img src="{{ asset('img/serat.png') }}" alt="" class="img-fluid serat">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 2 -->
            <div class="row min-vh-100" id="how-it-works">
                <div class="container col-12">
                    <h1 class="pg2-h1 fw-bold">How NutriPlan Works</h1>
                    <h2 class="text-center">From body data to personalized meals - everything is designed to help you
                        smarter and live healtier</h2>
                    <div class="container col-12 d-flex flex-wrap justify-content-evenly">
                        <div class="card-5 mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-ijo align-self-center">01</span>
                                        <span class="txt-1 text-center">Create Account</span>
                                    </h4>
                                </div>
                                <div class="col">
                                    <p class="ps-2 p-card mb-0 text-start">Sign Up to start your personalized nutrition
                                        journey with NutriPlan </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-5 mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-oren align-self-center">02</span>
                                        <span class="txt-2 text-center">Enter Body Data</span>
                                    </h4>
                                </div>
                                <div class="col-12">
                                    <p class="ps-2 p-card mb-0 text-start">Add your height, weight, age, and gender for
                                        accurate analysis</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-5 mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-ijo align-self-center me-1">03</span>
                                        <span class="txt-1 text-center">BMI Analysis</span>
                                    </h4>
                                </div>
                                <div class="col">
                                    <p class="ps-2 p-card mb-0 text-start">Get instant BMI results and understand your
                                        body condition better</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-5 mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-oren align-self-center">04</span>
                                        <span class="txt-2 text-center">Generate Meal Plan</span>
                                    </h4>
                                </div>
                                <div class="col">
                                    <p class="ps-2 p-card mb-0 text-start">Recieve meal recommendations tailored to
                                        your body need and goals</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-5 mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-ijo align-self-center">05</span>
                                        <span class="txt-1 text-center">Explore Recipes</span>
                                    </h4>
                                </div>
                                <div class="col">
                                    <p class="ps-2 p-card mb-0 text-start">Browse healthy recipes and discover
                                        nutritions meals you will enjoy</p>
                                </div>
                            </div>
                        </div>
                        <div class="container px-0 d-flex justify-content-center">
                            <div class="col-12 col-md-10 col-lg-8 col-xl-6 justify-content-center d-flex">
                                <div class="d-flex col-6 justify-content-center">
                                    <a href="#"
                                        class="btn ijo text-white rounded-pill fw-bold my-5 mx-2 px-4">Calculate Your
                                        Plan</a>
                                </div>
                                <div class="col-6 d-flex justify-content-center">
                                    <a href="#"
                                        class="btn oren text-white rounded-pill my-5 fw-bold mx-2 px-4">Explore
                                        Recipes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Page 3 -->
            <div class="row min-vh-100 mb-5" id="recipes">
                <div class="container col-12 px-5">
                    <h1 class="pg3-h1 fw-bold">Explore Healthy Recipes</h1>
                    <h2 class="pg3-h2">Discover nutritions and delicious recipes tailored to your lifestyle. From quick
                        breakfast to balanced dinners, NutriPlan helps you find meals you’ll actually enjoy</h2>
                    <div class="container">
                        <div class="d-flex justify-content-center my-4">
                            <a href="#" class="btn oren text-white rounded-pill fw-bold px-4"
                                width="33%">Explore Recipes</a>
                        </div>
                    </div>
                    {{-- Element Page 3 --}}
                    <div class="container col-12 d-flex flex-wrap justify-content-evenly">
                        <div class="card-1 m-3 px-2">
                            <div class="py-3 px-2 d-flex flex-column">
                                <img src="img/quick_meal.png" alt=""
                                    class="img-fluid mb-2 align-self-center">
                                <h5 class="fw-bold text-center">Avocado Egg Toast</h5>
                                <p class="d-flex justify-content-center">
                                    <span class="text-white mx-1 ktg-ijo">280 kcal</span>
                                    <span class="text-white mx-1 ktg-oren">10 min</span>
                                </p>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn oren text-white rounded-pill fw-bold px-4"
                                        width="33%">Quick Meal</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-1 m-3 px-2">
                            <div class="py-3 px-2 d-flex flex-column">
                                <img src="img/high_protein.png" alt=""
                                    class="img-fluid mb-2 align-self-center">
                                <h5 class="fw-bold text-center">Chicken Veggie Bowl</h5>
                                <p class="d-flex justify-content-center">
                                    <span class="text-white mx-1 ktg-ijo">430 kcal</span>
                                    <span class="text-white mx-1 ktg-oren">25 min</span>
                                </p>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn ijo text-white rounded-pill fw-bold px-4"
                                        width="33%">High Protein</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-1 m-3 px-2">
                            <div class="py-3 px-2 d-flex flex-column">
                                <img src="img/light_and_fresh.png" alt=""
                                    class="img-fluid mb-2 align-self-center">
                                <h5 class="fw-bold text-center">Berry Yoghurt Bowl</h5>
                                <p class="d-flex justify-content-center">
                                    <span class="text-white mx-1 ktg-ijo">280 kcal</span>
                                    <span class="text-white mx-1 ktg-oren">10 min</span>
                                </p>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn oren text-white rounded-pill fw-bold px-4"
                                        width="33%">Light and Fresh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 4 -->
            <div class="row min-vh-100" id="calculator">
                <div class="col-lg-7 col-6">
                    <div class="col-lg-10 col-12">
                        <h1 class="pg3-h1 text-start fw-bold">Calculate Your Health Need</h1>
                    </div>
                    <h2 class="pg3-h2 text-start">Use NutriPlan’s calculator to estimate your BMI, calori needs, and
                        personalized nutrition targets based on your body data and goals</h2>
                    <a href="#" class="btn ijo text-white rounded-pill fw-bold mt-4" width="33%">Try
                        Calculator</a>
                </div>
                {{-- Panel Page 4 --}}
                <div class="col-6 col-lg-5 d-flex flex-wrap justify-content-end">
                    <div class="card-2 position-relative d-flex flex-column p-3">
                        <h5 class="fw-bold text-center mb-4">Your Body Data</h5>
                        <div class="mb-4">
                            <p class="m-0">Height</p>
                            <div class="border-bottom border-dark"></div>
                        </div>
                        <div class="mb-4">
                            <p class="m-0">Weight</p>
                            <div class="border-bottom border-dark"></div>
                        </div>
                        <div class="mb-4">
                            <p class="m-0">Age</p>
                            <div class="border-bottom border-dark"></div>
                        </div>
                        <div class="mb-4">
                            <p class="m-0">Goal</p>
                            <div class="border-bottom border-dark"></div>
                        </div>
                        <div class="card-3 p-2 position-absolute px-4">
                            <h5 class="fw-bold">Result</h5>
                            <p class="fw-500">BMI: 20.2</p>
                            <div class="d-flex">
                                <div class="scale-1"></div>
                                <div class="scale-2"></div>
                                <div class="scale-3"></div>
                                <div class="scale-4"></div>
                            </div>
                            <div class="d-flex mb-4">
                                <div class="flex-fill text-start">Mid</div>
                                <div class="flex-fill text-center">Healthy</div>
                                <div class="flex-fill fw-bold text-end">High</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/fire.png') }}" alt="" class="img-fluid">
                                <h5 class="fw-bold mb-0">Daily Calories</h5>
                                <div class="d-flex flex-fill justify-content-end">
                                    <span class="n1950">1950</span><span class="kcal">kcal/day</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 5 -->
            <div class="row min-vh-100" id="planner">
                <div class="col-6 d-flex justify-content-center">
                    {{-- Panel Page 5 --}}
                    <div class="card-4 d-flex flex-column px-4 py-3">
                        <div class="d-flex align-items-start mb-2">
                            <img src="{{ asset('img/clock-history.png') }}" alt=""
                                class="clock-history img-fluid me-3">
                            <h6 class="text-white fw-bold pt-1 mb-0">Views Today's Schedule</h6>
                        </div>
                        {{-- Kalender --}}
                        <div class="p-2 w-100 pnl-pg5">
                            <div class="d-flex align-items-center mb-2 justify-content-between">
                                <p class="fw-bold txt-3 m-0">March 2026</p>
                                <div class="d-flex align-items-center">
                                    <p class="p-card2 elm px-2 me-1 mb-0">Today</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none" class="elm me-1 my-0">
                                        <path d="M10 12L6 8L10 4" stroke="#0A0A0A" stroke-width="1.33333"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none" class="elm me-1 my-0">
                                        <path d="M6 12L10 8L6 4" stroke="#0A0A0A" stroke-width="1.33333"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mb-1">
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">S</p>
                                    <p class="p-card2 m-0">15</p>
                                </div>
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">M</p>
                                    <p class="p-card2 m-0">16</p>
                                </div>
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">T</p>
                                    <p class="p-card2 m-0">17</p>
                                </div>
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">W</p>
                                    <p class="p-card2 m-0">18</p>
                                </div>
                                <div class="tgl-day1 d-flex align-items-center flex-column">
                                    <p class="p-card3 text-white m-0">T</p>
                                    <p class="p-card2 text-white m-0">19</p>
                                </div>
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">F</p>
                                    <p class="p-card2 m-0">20</p>
                                </div>
                                <div class="tgl-day d-flex align-items-center flex-column">
                                    <p class="p-card3 m-0">S</p>
                                    <p class="p-card2 m-0">21</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <p class="p-card3 m-0">Mar 15 - Mar 21</p>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">08.00-08.10 AM</h6>
                                <h6 class="m-0 fw-bold text-white">Water Intake</h6>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">08.00-08.30 AM</h6>
                                <h6 class="m-0 fw-bold text-white">Avocado Toast With Poached Egg</h6>
                                <p class="d-flex justify-content-start pt-2 ps-0 mb-0">
                                    <span class="text-white me-2 fw-bold ktg-oren">Breakfast</span>
                                    <span class="text-white me-2 fw-bold ktg-ijo">320 kcal</span>
                                    <span class="text-white fw-bold ktg-oren">15 mins</span>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">12.30-01.00 PM</h6>
                                <h6 class="m-0 fw-bold text-white">Quinoa and Kale Salad with Lemon V...</h6>
                                <p class="d-flex justify-content-start pt-2 ps-0 mb-0">
                                    <span class="text-white me-2 fw-bold ktg-oren">Lunch</span>
                                    <span class="text-white me-2 fw-bold ktg-ijo">450 kcal</span>
                                    <span class="text-white fw-bold ktg-oren">20 mins</span>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">01.00-01.10 PM</h6>
                                <h6 class="m-0 fw-bold text-white">Water Intake</h6>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">04.00-04.30 PM</h6>
                                <h6 class="m-0 fw-bold text-white">Workout (Strength training)</h6>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">07.00-07.30 PM</h6>
                                <h6 class="m-0 fw-bold text-white">Avocado Toast with Poached Egg</h6>
                                <p class="d-flex justify-content-start pt-2 ps-0 mb-0">
                                    <span class="text-white me-2 fw-bold ktg-oren">Dinner</span>
                                    <span class="text-white me-2 fw-bold ktg-ijo">320 kcal</span>
                                    <span class="text-white fw-bold ktg-oren">20 mins</span>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 p-0 d-flex">
                            <div class="checklist me-3 align-items-start"></div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0 fw-bold text-white">07.00-07.10 PM</h6>
                                <h6 class="m-0 fw-bold text-white">Water Intake</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h1 class="pg3-h1 text-end fw-bold">Stay On Track With Your Meals</h1>
                    <h2 class="pg3-h2 text-end">NutriPlan makes it easy to plan and personalized your meals for the day
                        and the week. Stay organized, track your nutrition, and achieve your health goals!</h2>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="#" class="btn oren text-white rounded-pill fw-bold mt-4" width="33%">Start
                            Planning</a>
                    </div>
                </div>
            </div>


        </div>
        </div>
        </div>
    </main>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Javascript -->
    <script src="script/script.js" defer></script>
</body>
</html>
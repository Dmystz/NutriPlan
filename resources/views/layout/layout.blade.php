<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - Homepage</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl navbar-light fixed-top">
        <div class="container-fluid ps-0">
            <!-- Logo -->
            <div class="d-flex flex-grow-1 position-relative">
                <a class="navbar-brand" href="#">
                    <img src="img/logo.png" alt="Logo NutriPlan" width="37px" height="37px">
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
                                aria-current="page" data-nutri="Index" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link oren rounded-pill text-white fw-bold item"
                                href="#">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link ijo rounded-pill text-white fw-bold item"
                                href="#">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link oren rounded-pill text-white fw-bold item"
                                href="#">Callculator</a>
                        </li>
                        <li class="nav-item">
                            <a class="mx-xl-2 btn text-center nav-link ijo rounded-pill text-white fw-bold item"
                                href="#">Planner</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center flex-grow-0">
                    <ul class="navbar-nav align-items-center mb-xl-0">
                        <li class="nav-item item">
                            <a class="btn text-center nav-link oren rounded-pill text-white px-5 fw-bold"
                                href="#">Log In/Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <!-- Isi konten -->
        <div class="container-fluid min-vh-100 lat-blkg px-4 konten" width="100%">
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
            <div class="row min-vh-100">
                <div class="container col-12">
                    <h1 class="pg2-h1 fw-bold">How NutriPlan Works</h1>
                    <h2 class="text-center">From body data to personalized meals - everything is designed to help you
                        smarter and live healtier</h2>
                    <div class="container col-12 d-flex flex-wrap justify-content-evenly">
                        <div class="card mt-5 mx-3 px-2">
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
                        <div class="card mt-5 mx-3 px-2">
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
                        <div class="card mt-5 mx-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <h4 class="d-flex align-items-center">
                                        <span class="Num-ijo align-self-center">03</span>
                                        <span class="txt-1 text-center">BMI Analysis</span>
                                    </h4>
                                </div>
                                <div class="col">
                                    <p class="ps-2 p-card mb-0 text-start">Get instant BMI results and understand your
                                        body condition better</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-5 mx-3 px-2">
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
                        <div class="card mt-5 mx-3 px-2">
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
            <div class="row min-vh-100">
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
            <div class="row min-vh-100 prg">
                <div class="col-7">
                    <div class="col-lg-10 col-12">
                        <h1 class="pg3-h1 text-start fw-bold">Calculate Your Health Need</h1>
                    </div>
                    <h2 class="pg3-h2 text-start">Use NutriPlan’s calculator to estimate your BMI, calori needs, and
                        personalized nutrition targets based on your body data and goals</h2>
                    <a href="#" class="btn ijo text-white rounded-pill fw-bold mt-4" width="33%">Try
                        Calculator</a>
                </div>
                <div class="col-5"></div>
            </div>
            <!-- Page 5 -->
            <div class="row min-vh-100 plg">
                <div class="col-6"></div>
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

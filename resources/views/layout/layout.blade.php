<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>@yield('title', 'default title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('style.php') }}">
    <script src="{{ asset('js/script.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-expand-xl navbar-light fixed-top">
        <div class="container-fluid ps-0">
            <!-- Logo -->
            <div class="d-flex flex-grow-1 position-relative">
                <a class="ms-5 navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo NutriPlan" width="37px" height="37px">
                    <span class="nutri">Nutri</span><span class="plan">Plan</span>
                </a>
            </div>
            <!-- Button navbar responsive -->
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Elemen navbar -->
            <div class="collapse navbar-collapse py-xl-3 py-4" id="navbarSupportedContent">
                <div class="d-flex justify-content-center flex-grow-1">
                    <ul class="navbar-nav mb-xl-0 align-items-center mb-3">
                        <li class="nav-item">
                            <a class="me-xl-2 btn align-items-center d-flex nav-link ijo rounded-pill text-white fw-bold item"
                                href="{{ route('home') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M16 22V18C16 15.7909 14.2091 14 12 14C9.79086 14 8 15.7909 8 18V22M21 10.1503V17.9668C21 20.1943 19.2091 22 17 22H7C4.79086 22 3 20.1943 3 17.9668V10.1503C3 8.93937 3.53964 7.7925 4.46986 7.02652L9.46986 2.90935C10.9423 1.69689 13.0577 1.69688 14.5301 2.90935L19.5301 7.02652C20.4604 7.7925 21 8.93937 21 10.1503Z"
                                        stroke="#F5F5F5" stroke-width="1.5" />
                                </svg></span>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="me-xl-2 btn align-items-center d-flex nav-link oren rounded-pill text-white fw-bold item"
                                href="{{ route('meal_plan') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 9V18C3 20.2091 4.79086 22 7 22H17C19.2091 22 21 20.2091 21 18V9M3 9V7.5C3 5.29086 4.79086 3.5 7 3.5H17C19.2091 3.5 21 5.29086 21 7.5V9M3 9H21M16 2V5M8 2V5"
                                        stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                </svg></span>
                                Meal Plans
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="me-xl-2 btn align-items-center d-flex nav-link ijo rounded-pill text-white fw-bold item"
                                href="{{ route('nutrition') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12.7378 11.2556V1.29891C12.7378 1.20095 12.699 1.1072 12.6298 1.03798C12.5606 0.968767 12.4667 0.929768 12.3689 0.929768C11.6284 0.929768 10.9956 1.44464 10.4878 2.45981C10.1209 3.1935 9.80942 4.20685 9.56206 5.47134C9.14641 7.59572 9.05192 9.68185 9.04807 9.76974V9.76992C9.04056 9.94497 9.1572 10.1013 9.32731 10.1438L10.5239 10.443V11.2556L10.1555 21.9272C10.145 22.2249 10.2569 22.5139 10.4651 22.727C10.6779 22.9476 10.9718 23.0716 11.2783 23.0701H11.9834C12.29 23.0716 12.5839 22.9476 12.7966 22.727C13.0048 22.5137 13.1167 22.2245 13.1063 21.9266L12.7378 11.2556Z" fill="white" />
                                </svg></span>
                                Nutrition
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="me-xl-2 btn align-items-center d-flex nav-link oren rounded-pill text-white fw-bold item"
                                href="{{ route('recipes') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 31 31" fill="none">
                                    <path d="M15.5 21.9583H21.9583C22.6717 21.9583 23.25 21.38 23.25 20.6667V7.75C23.25 6.32327 22.0934 5.16667 20.6667 5.16667L11.625 5.16667C9.4849 5.16667 7.75 6.90157 7.75 9.04167L7.75 23.8958" stroke="white" stroke-width="1.5" />
                                    <path d="M22.4997 25.8333C22.5477 25.8333 22.5789 25.7826 22.5583 25.7393C21.9617 24.4852 21.9739 23.2312 22.5948 21.9771C22.5991 21.9685 22.5929 21.9583 22.5833 21.9583L9.6875 21.9583C8.61745 21.9583 7.75 22.8258 7.75 23.8958C7.75 24.9659 8.61745 25.8333 9.6875 25.8333L22.4997 25.8333Z" stroke="white" stroke-width="1.5" />
                                    <path d="M14.2083 5.425C14.2083 5.28232 14.3239 5.16666 14.4666 5.16666H19.1166C19.2593 5.16666 19.3749 5.28232 19.3749 5.425V11.0954C19.3749 11.3106 19.1272 11.4314 18.9575 11.2989L16.9506 9.73102C16.8572 9.65801 16.726 9.65801 16.6325 9.73102L14.6256 11.2989C14.456 11.4314 14.2083 11.3106 14.2083 11.0954V5.425Z" stroke="white" stroke-width="1.5" />
                                </svg></span>
                                Recipes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="me-xl-2 btn align-items-center d-flex nav-link ijo rounded-pill text-white fw-bold item"
                                href="{{ route('analytic') }}">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_102_1720)">
                                        <path d="M24 24H3C2.20435 24 1.44129 23.6839 0.87868 23.1213C0.31607 22.5587 0 21.7956 0 21L0 0H2V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H24V24Z" fill="white" />
                                        <path d="M15.9998 11.0006H13.9998V20.0006H15.9998V11.0006Z" fill="white" />
                                        <path d="M8 11.0006H6V20.0006H8V11.0006Z" fill="white" />
                                        <path d="M20 6H18V20H20V6Z" fill="white" />
                                        <path d="M12.0002 6H10.0002V20H12.0002V6Z" fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_102_1720">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg></span>
                                Analytic
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center flex-grow-0">
                    <ul class="navbar-nav align-items-center mb-xl-0">
                        <li class="nav-item border item d-flex">
                            <a class="btn text-center nav-link oren-bunder me-2 p-1 flex-grow-0" href="#">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 1.33333C5.39763 1.33333 1.66667 4.3181 1.66667 8V9.33333H3.33333C4.25381 9.33333 5 9.93029 5 10.6667V14.6667C5 15.403 4.25381 16 3.33333 16H1.66667C0.746192 16 0 15.403 0 14.6667V8C0 3.58172 4.47715 0 10 0C15.5228 0 20 3.58172 20 8V16C20 17.841 18.1345 19.3333 15.8333 19.3333H12.277C11.9889 19.7319 11.4502 20 10.8333 20H9.16667C8.24619 20 7.5 19.403 7.5 18.6667C7.5 17.9303 8.24619 17.3333 9.16667 17.3333H10.8333C11.4502 17.3333 11.9889 17.6015 12.277 18H15.8333C17.214 18 18.3333 17.1046 18.3333 16H16.6667C15.7462 16 15 15.403 15 14.6667V10.6667C15 9.93029 15.7462 9.33333 16.6667 9.33333H18.3333V8C18.3333 4.3181 14.6024 1.33333 10 1.33333Z" fill="white" />
                                </svg></span>
                            </a>
                            <a href="#" class="btn text-center nav-link ijo-bunder p-1 flex-grow-0 me-2">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                                    <path d="M11.5 23C13.0878 23 14.375 21.7128 14.375 20.125H8.625C8.625 21.7128 9.91218 23 11.5 23Z" fill="white" />
                                    <path d="M11.5 2.75748L10.354 2.98892C7.72731 3.51942 5.75003 5.84291 5.75003 8.625C5.75003 9.5275 5.55688 11.7835 5.09041 14.0044C4.85884 15.1068 4.54903 16.2547 4.13726 17.25H18.8627C18.451 16.2547 18.1412 15.1068 17.9096 14.0043C17.4432 11.7835 17.25 9.52749 17.25 8.625C17.25 5.84289 15.2727 3.51939 12.646 2.98891L11.5 2.75748ZM20.4403 17.25C20.7612 17.8931 21.1334 18.4014 21.5625 18.6875H1.4375C1.86663 18.4014 2.23883 17.8931 2.55976 17.25C3.85138 14.6616 4.31253 9.88879 4.31253 8.625C4.31253 5.1453 6.78529 2.24314 10.0695 1.57987C10.0649 1.53304 10.0625 1.48554 10.0625 1.4375C10.0625 0.643591 10.7061 0 11.5 0C12.2939 0 12.9375 0.643591 12.9375 1.4375C12.9375 1.48554 12.9351 1.53303 12.9305 1.57986C16.2147 2.24311 18.6875 5.14528 18.6875 8.625C18.6875 9.88879 19.1486 14.6616 20.4403 17.25Z" fill="white" />
                                </svg></span>
                            </a>
                            <a class="btn text-center nav-link oren-bunder me-2 py-1 px-3 flex-grow-0" href="#"></a>
                        </li>
                    </ul>
                    <div class="user-account-info border d-flex align-items-center gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold info-user">{{ session('user_name') }}</h6>
                            <p class="mb-0 info-user">{{ session('user_email') }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="container-fluid min-vh-100 px-5 row lat-blkg konten">
            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
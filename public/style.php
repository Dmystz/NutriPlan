<?php
header("Content-type: text/css");
echo "body { background-color: #f0f0f0; }";
?>
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
        --warna-ijo: #95cd41 !important;
        --warna-oren: #ea5c2b !important;
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
        padding: 5rem 0;
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
        background-color: var(--warna-ijo);
        transition: all 0.3s ease;
    }

    .ijo:hover {
        background-color: #6e9c29;
    }

    .ijo-bunder {
        background-color: var(--warna-ijo);
        transition: all 0.3s ease;
        border-radius: 100%;
    }

    .ijo-bunder:hover {
        background-color: #6e9c29;
    }

    .oren-bunder {
        background-color: var(--warna-oren);
        transition: all 0.3s ease;
        border-radius: 100%;
    }

    .oren-bunder:hover {
        background-color: #cd4c22;
    }

    .oren {
        background-color: var(--warna-oren);
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

    .p-card-daily {
        font-size: 0.625rem;
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

    .card-6 {
        width: 6rem;
        height: 6rem;
        border-radius: 10px;
        background: #FFF;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.10), 0 2px 4px -2px rgba(0, 0, 0, 0.10);
        margin: 0.5rem;
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
        background: var(--warna-ijo);
        padding: 0 0.5rem;
        border-radius: 200px;
    }

    .btn {
        height: auto;
        line-height: 1.2;
    }

    .Num-oren {
        font-weight: 700;
        background: var(--warna-oren);
        padding: 0 0.5rem;
        border-radius: 200px;
    }

    .ktg-ijo {
        background: var(--warna-ijo);
        font-size: 0.625rem;
        padding: 0 0.5rem;
        border-radius: 5px;
    }

    .ktg-ijo-home {
        background: var(--warna-ijo);
        font-size: 0.5rem;
        padding: 0 0.5rem;
        border-radius: 5px;
    }

    .ktg-oren {
        background: var(--warna-oren);
        padding: 0 0.5rem;
        font-size: 0.625rem;
        border-radius: 5px;
    }

    .ktg-oren-home {
        background: var(--warna-oren);
        padding: 0 0.5rem;
        font-size: 0.5rem;
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

    /* Homepage */
    .form-control {
        background: linear-gradient(90deg, #EA5C2B 0%, #95CD41 100%);
        border-radius: 200px;
        padding-left: 2.5rem;
        box-shadow: none;
        border: none;
        outline: none;
    }

    .form-control::placeholder {
        color: #f0ffdf;
    }

    .form-control:focus {
        color: #f0ffdf;
        box-shadow: none;
        border: none;
        outline: none;
    }

    .btn-check:checked+.bg-radio {
        background-color: #FFF;
        color: #79716B;
        box-shadow: 0 0 0 2px #F5F5F4 inset;
    }

    .btn-kalender {
        background-color: #F5F5F4;
        border-radius: 26843500px;
        padding: 0.125rem 0.25rem;
        display: inline-block;
        color: #79716B;
    }

    .bg-radio {
        border-radius: 26843500px;
        color: #292524;
        padding: 0.5rem 2rem;
        transition: all 0.4s ease;
        font-size: 0.8rem;
    }

    .lup {
        top: 5px;
        left: 5px;
    }

    .info-user {
        height: max-content;
        width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wrapper-meal-home {
        min-width: 5rem;
        height: 80vh;
        padding: 1rem;
        overflow: hidden;
        border-radius: 24px;
        border: 0.8px solid rgba(255, 237, 212, 0.60);
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.25);
        backdrop-filter: blur(5px);
    }

    .wrapper-daily-home {
        width: 16rem;
        height: 20rem;
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 10px;
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.25);
        backdrop-filter: blur(5px);
        overflow: hidden;
    }

    .wrapper-home1 {
        border-radius: 10px;
        background: #FFF;
        box-shadow: 5px 5px 10px 0 rgba(0, 0, 0, 0.25);
        min-height: 100%;
        height: auto;
        min-width: 10rem;
    }

    .wrapper-report-home {
        border-radius: 10px;
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.50);
        backdrop-filter: blur(5px);
        width: 16rem;
        height: 20rem;
        margin-bottom: 1rem;
        padding: 1rem;
    }

    .wrapper-shop-home {
        border-radius: 10px;
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.50);
        backdrop-filter: blur(5px);
        width: 16rem;
        height: 20rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .wrapper-shop-list-home {
        overflow: hidden;
        background: none;
        margin: 0;
        height: calc(100% - 2rem);
    }

    .wrapper-daily-list-home {
        overflow: hidden;
        background: none;
        height: calc(100% - 2rem);
    }

    .daily-list {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        height: calc(100% - 1rem);
    }

    .daily-list::-webkit-scrollbar {
        display: none;
    }

    .wrapper-content-meal-home {
        border-radius: 16px;
        border: 0.8px solid #F5F5F4;
        background: #FFF;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.10), 0 1px 2px -1px rgba(0, 0, 0, 0.10);
        width: 17.5rem;
        height: 7rem;
        margin-left: auto;
    }

    .chart-activity {
        height: calc(100% - 2rem);
        margin-top: 2rem;
    }

    .bar {
        width: 100%;
        border-radius: 24px;
        background: rgba(30, 77, 106, 0.50);
        transition: height 0.3s ease;
    }

    .highest-bar {
        width: 100%;
        border-radius: 24px;
        background: linear-gradient(180deg, #51A2FF 0%, #155DFC 100%);
        transition: height 0.3s ease;
    }

    .nilai-bar {
        position: absolute;
        top: -1.2rem;
    }

    .day-bar {
        position: relative;
        height: 100%;
        width: 1.8rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: end;
    }

    .wrapper-activity-home {
        width: 100%;
        height: calc(100% - 2rem);
        margin: 0;
    }

    .meals-list {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        height: calc(100% - 2rem);
    }

    .meals-list::-webkit-scrollbar {
        display: none;
    }

    .header-meals {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .type-meal {
        font-size: 0.8rem;
        color: #EA5C2B;
    }

    .p-water {
        color: #364153;
        font-family: Inter;
        font-size: 0.625rem;
        font-style: normal;
        font-weight: 600;
        line-height: 15px;
    }

    .p-crd-home {
        font-size: 0.4rem;
    }

    .shopping-list {
        overflow-y: auto;
        height: calc(100% - 1rem);
    }

    .shopping-list::-webkit-scrollbar {
        display: none;
    }

    .container-content-daily {
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, 0.25);
        background: rgba(252, 252, 252, 0.23);
        backdrop-filter: blur(5px);
        width: 100%;
        height: 5rem;
    }

    .btn-daily {
        border-radius: 10px;
        border: 0.8px solid #E5E7EB;
        background: #FFF;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }


    .btn-daily:hover {
        background: #bfbfbf;
    }

    .progress-daily {
        height: 8px;
        border-radius: 50px;
        background: #E5E7EB;
    }

    .progress-bar-daily {
        background: #FE9A00;
        height: 100%;
        border-radius: 50px;
    }

    .progress-bar-daily-protein {
        background: #FB2C36;
        height: 100%;
        border-radius: 50px;
    }

    .progress-bar-daily-fats {
        background: #FF6900;
        height: 100%;
        border-radius: 50px;
    }

    .progress-bar-daily-water {
        background: #4285F4;
        height: 100%;
        border-radius: 50px;
    }

    .shopping-list input[type="checkbox"] {
        margin-right: 0.5rem;
        width: 1.125rem;
        height: 1.125rem;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: transparent;
        border: 1px solid #000;
        border-radius: 4px;
        padding: 0;
    }

    .shopping-list input[type="checkbox"]:checked+label {
        text-decoration: line-through;
        color: #364153;
    }

    .gambar-rekomendasi {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .shopping-list input[type="checkbox"]:checked {
        background-color: var(--warna-ijo);
    }

    .shopping-list input[type="checkbox"]:checked::after {
        content: "✔";
        color: white;
        font-size: 0.875rem;
        display: flex;
        padding: 0;
        margin-bottom: 3px;
        justify-content: center;
    }

    .crd6-content {
        width: 100%;
        justify-content: space-between;
    }

    .water-container {
        width: 100%;
        height: 3.2rem;
        background-color: rgba(74, 85, 101, 0.2);
        border-radius: 10px;
    }

    .font-size-s {
        font-size: 0.55rem;
    }

    .gambar-meal {
        width: 96px;
        height: 96px;
        border-radius: 14px;
    }

    .water-icon-daily {
        width: 16px;
        height: 16px;
        border-radius: 3px;
        background: #4285F4;
    }

    .icon-daily-padi {
        border-radius: 3px;
        background: #FE9A00;
        padding: 3px;
    }

    .icon-daily-fats {
        border-radius: 3px;
        padding: 3px;
        background: #FF6900;
    }

    .icon-daily-apokad {
        border-radius: 3px;
        padding: 3px;
        background: #FB2C36;
    }

    .tgl {
        font-size: 0.8rem;
    }
</style>
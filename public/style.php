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

    .card-7 {
        width: 14rem;
        height: 14rem;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.20);
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.25);
        backdrop-filter: blur(5px);
        margin: 0.5rem;
        padding: 0.25rem;
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
        color: #000;
        box-shadow: 0 0 0 2px #F5F5F4 inset;
    }

    .btn-kalender {
        background-color: #d1d1d1;
        border-radius: 50px;
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.25);
        backdrop-filter: blur(5px);
        display: inline-block;
        padding: 0.2rem 0.25rem;
    }

    .bg-radio {
        border-radius: 50px;
        color: #79716B;
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
        border: 0.8px solid rgba(0, 0, 0, 0.20);
        background: rgba(252, 252, 252, 0.23);
        box-shadow: 0 10px 24px 0 rgba(140, 136, 136, 0.25);
        backdrop-filter: blur(5px);
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


    .btn-report {
        border-radius: 10px;
        border: 0.8px solid #E5E7EB;
        background: #FFF;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 10px;
        height: 10px;
        cursor: pointer;
        padding: 0;
        margin: 0;
        z-index: 3;
    }

    .btn-report:hover {
        background: #bfbfbf;
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
        background-color: rgba(74, 85, 101, 0.5);
        border-radius: 10px;
        margin-bottom: 0.1rem;
        position: relative;
        overflow: hidden;
    }

    .mb-01 {
        margin-bottom: 0.1rem;
    }

    .svg-weight {
        z-index: 2;
        position: relative;
    }

    .water-bar {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 0%;
        background: #3B82F6;
        transition: height 0.3s ease, background 0.3s ease;
        z-index: 1;
    }

    #value-report-ml {
        z-index: 2;
        position: relative;
    }

    #current-weight {
        position: absolute;
        z-index: 1;
        transform: translate(-50%, -50%);
        top: 55%;
        left: 50%;
    }


    #current-bmi {
        position: absolute;
        z-index: 2;
        transform: translate(-50%, -50%);
        top: 70%;
        left: 50%;
    }

    #current-kkal {
        position: absolute;
        z-index: 2;
        transform: translate(-50%, -50%);
        top: 40%;
        left: 50%;
    }

    #target-p-kkal {
        z-index: 2;
        transform: translate(-50%, -50%);
        top: 60%;
        left: 50%;
    }

    .svg-bmi {
        height: 2.5rem;
    }

    #target-p-weight {
        position: absolute;
        top: 90%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    #water-value-report {
        z-index: 2;
        position: relative;
        color: #FFF;
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

    #ket-bmi {
        position: absolute;
        z-index: 2;
        transform: translate(-50%, -50%);
        top: 110%;
        left: 50%;
    }

    .tgl {
        font-size: 0.8rem;
    }

    .no-deco {
        text-decoration: none;
    }

    .wrapper-content-meal-week {
        height: 60%;
    }

    /* Tambahan styling code banyak */
    /* ================================================================
       DAYS MEAL PLAN — tambahkan di bawah style yang sudah ada
       ================================================================ */

    /* --- Motivational card (left sidebar) --- */
    .card-motivasi {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
    }

    /* --- Scrollable meal container (middle column) --- */
    .wrapper-meal-days {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        overflow-y: auto;
        max-height: 72vh;
    }

    .wrapper-meal-days::-webkit-scrollbar {
        display: none;
    }

    /* --- Meal card used inside the Days timeline --- */
    .wrapper-content-meal-days {
        border-radius: 14px;
        border: 0.8px solid rgba(0, 0, 0, 0.15);
        background: rgba(252, 252, 252, 0.50);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.20);
        backdrop-filter: blur(5px);
        width: 100%;
        min-height: 7rem;
        transition: box-shadow 0.2s ease;
    }

    .wrapper-content-meal-days:hover {
        box-shadow: 0 6px 20px 0 rgba(140, 136, 136, 0.35);
    }

    /* --- Timeline layout helpers --- */
    .timeline-meal-row {
        position: relative;
    }

    .meal-time-col {
        min-width: 2.6rem;
        text-align: right;
        padding-right: 0.5rem;
        padding-top: 0.3rem;
        flex-shrink: 0;
    }

    .meal-time-text {
        font-size: 0.68rem;
        font-weight: 700;
        color: #6B7280;
        white-space: nowrap;
    }

    .meal-timeline-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-right: 0.6rem;
        flex-shrink: 0;
    }

    .meal-dot-timeline {
        width: 11px;
        height: 11px;
        background: var(--warna-oren);
        border-radius: 50%;
        margin-top: 0.4rem;
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(234, 92, 43, 0.18);
    }

    .meal-line-timeline {
        width: 2px;
        flex: 1;
        min-height: 3.5rem;
        background: linear-gradient(to bottom, var(--warna-oren), rgba(234, 92, 43, 0.15));
        border-radius: 2px;
        margin-top: 2px;
    }

    /* --- Date navigation button --- */
    .btn-nav-date {
        border: 1px solid #D1D5DB;
        background: #FFF;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        line-height: 1;
        color: #374151;
        padding: 0;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .btn-nav-date:hover {
        background: #F3F4F6;
        border-color: #9CA3AF;
    }

    .date-pill {
        border: 1px solid #D1D5DB;
        background: #FFF;
        border-radius: 8px;
        padding: 0.25rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #111827;
    }

    .add-meal-btn {
        font-size: 0.78rem;
        padding: 0.4rem 1rem;
        line-height: 1.4;
    }

    /* --- Nutrition / Daily Goals panel --- */
    .nutrition-panel {
        border-radius: 16px;
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
    }

    /* --- Donut chart wrapper --- */
    .donut-wrapper {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .donut-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .donut-kcal-num {
        font-size: 1.05rem;
        line-height: 1.2;
        color: #111827;
    }

    .donut-kcal-label {
        font-size: 0.62rem;
        color: #6B7280;
    }

    /* --- Legend dot --- */
    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* --- Tip icon circle --- */
    .tip-icon-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #FE9A00;
        flex-shrink: 0;
    }

    .tip-icon-num {
        font-size: 0.75rem;
        color: #FFF;
    }

    /* ================================================================
       RESPONSIVE OVERRIDES
       ================================================================ */

    /* Tablet (≤ 992px): stack middle + right, allow meal list to grow */
    @media (max-width: 992px) {
        .wrapper-meal-days {
            max-height: none;
        }

        .wrapper-content-meal-days {
            min-height: 6rem;
        }
    }

    /* Mobile (≤ 768px): full-width columns, compact timeline */
    @media (max-width: 768px) {
        .meal-time-col {
            min-width: 2.2rem;
        }

        .meal-time-text {
            font-size: 0.6rem;
        }

        .gambar-meal {
            width: 70px;
            height: 70px;
        }

        .wrapper-content-meal-days {
            min-height: 5.5rem;
        }

        .donut-wrapper svg {
            width: 130px;
            height: 130px;
        }

        .add-meal-btn {
            font-size: 0.7rem;
            padding: 0.35rem 0.75rem;
        }
    }

    /* Small mobile (≤ 480px) */
    @media (max-width: 480px) {
        .meal-time-col {
            min-width: 2rem;
        }

        .gambar-meal {
            width: 56px;
            height: 56px;
        }
    }

    /* ── Nutrition page extra styles ── */
    .nutrition-hero {
        border-radius: 20px;
        background: rgba(252, 252, 252, 0.60);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.08);
        padding: 1.25rem 1.5rem;
    }

    .nutrition-hero img.hero-meal-img {
        width: 160px;
        height: 140px;
        border-radius: 16px;
        object-fit: cover;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .nutrition-hero img.hero-meal-img {
            width: 100px;
            height: 90px;
        }
    }

    .tag-toast {
        background: var(--warna-oren);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 2px 10px;
    }

    .tag-kcal {
        background: rgba(234, 92, 43, 0.12);
        color: var(--warna-oren);
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 2px 10px;
    }

    .tag-time {
        background: rgba(149, 205, 65, 0.15);
        color: #446611;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 2px 10px;
    }

    /* Macro cards */
    .macro-card {
        border-radius: 16px;
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1rem;
        flex: 1 1 120px;
        min-width: 120px;
    }

    .macro-num {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .macro-unit {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .macro-pct {
        font-size: 0.65rem;
        color: #6B7280;
    }

    .macro-bar {
        height: 4px;
        border-radius: 50px;
        background: #E5E7EB;
        margin-top: 6px;
    }

    .macro-bar-fill {
        height: 100%;
        border-radius: 50px;
    }

    /* Breakdown table */
    .breakdown-panel {
        border-radius: 16px;
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1.25rem;
    }

    .breakdown-row {
        border-bottom: 0.8px solid rgba(0, 0, 0, 0.06);
        padding: 0.45rem 0;
    }

    .breakdown-row:last-child {
        border-bottom: none;
    }

    .bd-bar {
        height: 5px;
        border-radius: 50px;
        background: #E5E7EB;
    }

    .bd-bar-fill {
        height: 100%;
        border-radius: 50px;
    }

    /* Ingredients / Prepare panels */
    .info-panel {
        border-radius: 16px;
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1.25rem;
    }

    .ing-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .step-circle {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--warna-oren);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 991px) {
        .wrapper-meal-home {
            height: auto;
            min-height: 20rem;
            max-height: 60vh;
            overflow-y: auto;
        }

        .wrapper-report-home,
        .wrapper-shop-home,
        .wrapper-daily-home {
            width: 100%;
            max-width: 100%;
            height: auto;
            min-height: 14rem;
        }

        .wrapper-home1 {
            min-height: 12rem;
        }
    }

    @media (max-width: 767px) {
        .wrapper-meal-home {
            height: auto;
            max-height: none;
        }

        .wrapper-report-home {
            width: 100%;
            height: auto;
        }

        .wrapper-shop-home,
        .wrapper-daily-home {
            width: 100%;
            height: auto;
            min-height: 12rem;
        }

        .card-6 {
            width: 5.5rem;
            height: 5.5rem;
        }
    }

    @media (max-width: 480px) {
        .wrapper-content-meal-home {
            width: 100%;
        }

        .card-6 {
            width: 5rem;
            height: 5rem;
        }

        .crd6-content .p-water {
            font-size: 0.55rem;
        }
    }

    /* ── Recipes page extra styles ── */

    /* Sidebar filter */
    .recipes-sidebar {
        border-radius: 16px;
        background: rgba(252, 252, 252, 0.70);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1rem 0.75rem;
        min-width: 160px;
    }

    .filter-search-box {
        border-radius: 50px;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.35rem 0.75rem;
        font-size: 0.78rem;
        outline: none;
        width: 100%;
        color: #374151;
    }

    .filter-group-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #374151;
        background: #F3F4F6;
        border-radius: 8px;
        padding: 4px 8px;
        margin-bottom: 4px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .filter-item {
        font-size: 0.72rem;
        color: #6B7280;
        padding: 3px 8px;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .filter-item:hover {
        background: rgba(234, 92, 43, 0.07);
        color: var(--warna-oren);
    }

    .filter-item.active {
        color: var(--warna-oren);
        font-weight: 600;
    }

    .filter-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #D1D5DB;
        flex-shrink: 0;
    }

    .filter-dot.oren {
        background: var(--warna-oren);
    }

    /* Hero banner */
    .recipes-hero-banner {
        border-radius: 20px;
        background: linear-gradient(120deg, var(--warna-oren) 0%, #f97316 100%);
        padding: 1.25rem 1.5rem;
        position: relative;
        overflow: hidden;
        min-height: 100px;
    }

    .recipes-hero-banner h5 {
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .recipes-hero-banner p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.78rem;
    }

    .btn-add-recipe {
        background: #fff;
        color: var(--warna-oren);
        font-size: 0.78rem;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
    }

    .btn-add-recipe:hover {
        background: #FFF3EE;
        color: var(--warna-oren);
    }

    .btn-your-recipe {
        background: var(--warna-ijo);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        border-radius: 16px;
        padding: 0;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
        text-decoration: none;
        flex-shrink: 0;
        width: 130px;
        min-height: 110px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.20);
    }

    .btn-your-recipe:hover {
        background: #6e9c29;
        color: #fff;
        box-shadow: 0 6px 20px 0 rgba(110, 156, 41, 0.30);
    }

    .btn-your-recipe:hover {
        background: #6e9c29;
        color: #fff;
    }

    /* Recipe card */
    .recipe-card {
        border-radius: 16px;
        background: rgba(252, 252, 252, 0.85);
        box-shadow: 0 4px 16px 0 rgba(140, 136, 136, 0.18);
        backdrop-filter: blur(5px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        overflow: hidden;
        transition: box-shadow 0.2s ease;
        cursor: pointer;
    }

    .recipe-card:hover {
        box-shadow: 0 6px 22px 0 rgba(140, 136, 136, 0.32);
    }

    .recipe-card img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .recipe-card-body {
        padding: 0.6rem 0.75rem;
    }

    .recipe-card-title {
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 3px;
    }

    .recipe-card-desc {
        font-size: 0.65rem;
        color: #6B7280;
        line-height: 1.4;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recipe-tag {
        font-size: 0.55rem;
        font-weight: 600;
        border-radius: 4px;
        padding: 1px 6px;
        color: #fff;
        display: inline-block;
    }

    .recipe-card-menu {
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #F3F4F6;
        cursor: pointer;
        flex-shrink: 0;
        font-size: 0.7rem;
        color: #6B7280;
    }

    /* Section title */
    .section-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0.75rem;
    }

    /* === ANALYTIC PAGE ADDITIONS ONLY === */

    .analytic-card {
        border-radius: 18px;
        background: rgba(252, 252, 252, 0.80);
        box-shadow: 0 4px 20px rgba(140, 136, 136, 0.15);
        backdrop-filter: blur(8px);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1.25rem;
    }

    .analytic-card-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .analytic-icon {
        font-size: 1.1rem;
    }

    /* Gender toggle */
    .gender-toggle {
        display: flex;
        border-radius: 50px;
        overflow: hidden;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
    }

    .gender-btn {
        border: none;
        background: transparent;
        padding: 0.3rem 1rem;
        font-size: 0.82rem;
        cursor: pointer;
        color: #6B7280;
        transition: all 0.2s;
    }

    .gender-btn.active {
        background: #ea5c2b;
        color: #fff;
        border-radius: 50px;
        font-weight: 600;
    }

    /* Inputs */
    .analytic-label {
        font-size: 0.78rem;
        color: #374151;
        font-weight: 600;
        display: block;
        margin-bottom: 0.2rem;
    }

    .analytic-input {
        width: 100%;
        border-radius: 10px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.4rem 0.75rem;
        font-size: 0.85rem;
        color: #374151;
        outline: none;
        transition: border-color 0.2s;
    }

    .analytic-input:focus {
        border-color: #95cd41;
    }

    .input-unit-wrap {
        position: relative;
    }

    .unit-badge {
        position: absolute;
        right: 0.65rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.72rem;
        color: #9CA3AF;
        pointer-events: none;
    }

    /* Calculate button */
    .btn-calculate {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        border-radius: 50px;
        background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.65rem 1rem;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(149, 205, 65, 0.35);
        transition: all 0.25s;
    }

    .btn-calculate:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    /* Gauge */
    .gauge-wrap {
        position: relative;
        width: 100%;
        max-width: 200px;
        margin: 0 auto;
    }

    .gauge-svg {
        width: 100%;
        height: auto;
    }

    .gauge-value-wrap {
        position: absolute;
        bottom: 8%;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        line-height: 1.1;
    }

    .gauge-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1F2937;
    }

    .gauge-unit {
        font-size: 0.65rem;
        color: #6B7280;
        display: block;
    }

    /* BMI Classification */
    .bmi-class-list {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .bmi-class-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 10px;
        padding: 0.35rem 0.6rem;
        font-size: 0.83rem;
        transition: background 0.2s;
    }

    .bmi-class-row.active-class {
        background: rgba(149, 205, 65, 0.12);
    }

    .bmi-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .bmi-class-name {
        font-size: 0.83rem;
        color: #374151;
    }

    .bmi-class-range {
        font-size: 0.78rem;
        color: #6B7280;
    }

    .bmi-you-badge {
        font-size: 0.6rem;
        font-weight: 700;
        background: #95cd41;
        color: #fff;
        border-radius: 50px;
        padding: 1px 6px;
    }

    /* Summary */
    .summary-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .summary-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 0.8px solid rgba(0, 0, 0, 0.06);
        font-size: 0.85rem;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-icon {
        font-size: 1rem;
    }

    .summary-label {
        color: #6B7280;
    }

    .summary-value {
        margin-left: auto;
        font-weight: 500;
        color: #1F2937;
    }

    .badge-category {
        margin-left: auto;
        font-size: 0.72rem;
        font-weight: 700;
        background: rgba(149, 205, 65, 0.15);
        color: #446611;
        border-radius: 50px;
        padding: 2px 10px;
    }

    /* Insights */
    .insight-card {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        border-radius: 12px;
        padding: 0.65rem 0.75rem;
    }

    .insight-green {
        background: rgba(220, 252, 231, 0.6);
    }

    .insight-orange {
        background: rgba(255, 237, 213, 0.6);
    }

    .insight-blue {
        background: rgba(219, 234, 254, 0.6);
    }

    .insight-icon-wrap {
        font-size: 1.1rem;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .insight-title {
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .insight-body {
        font-size: 0.75rem;
        color: #374151;
        margin-bottom: 0;
    }

    /* Chart */
    .chart-wrap {
        position: relative;
        height: 130px;
    }

    /* CTA Banner */
    .cta-banner {
        border-radius: 18px;
        background: rgba(252, 252, 252, 0.80);
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 20px rgba(140, 136, 136, 0.15);
        border: 0.8px solid rgba(0, 0, 0, 0.07);
        padding: 1.25rem 1.75rem;
    }

    .cta-icon {
        font-size: 2.5rem;
    }

    .btn-create-plan {
        background: linear-gradient(90deg, #ea5c2b 0%, #f97316 100%);
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        border-radius: 50px;
        padding: 0.65rem 1.5rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(234, 92, 43, 0.35);
        transition: all 0.25s;
        white-space: nowrap;
    }

    .btn-create-plan:hover {
        opacity: 0.88;
        transform: translateY(-1px);
        color: #fff;
        box-shadow: 0 6px 20px rgba(234, 92, 43, 0.45);
    }

    /* Responsive tweaks */
    @media (max-width: 767px) {
        .analytic-card {
            padding: 1rem;
        }

        .cta-banner {
            padding: 1rem 1.25rem;
        }

        .gauge-number {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 480px) {
        .bmi-class-row {
            font-size: 0.75rem;
        }

        .summary-row {
            font-size: 0.78rem;
        }
    }

    /* ── Quick suggestion chips (Add Meal) ── */
    .am-chip {
        background: #F3F4F6;
        border: 0.8px solid #E5E7EB;
        border-radius: 50px;
        padding: 4px 10px;
        font-size: 0.68rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s;
    }

    .am-chip:hover,
    .am-chip.active {
        background: rgba(234, 92, 43, 0.10);
        border-color: var(--warna-oren);
        color: var(--warna-oren);
    }

    /* ── Adjust Plan: preference chips ── */
    .adj-pref-chip {
        border: 0.8px solid #E5E7EB;
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 0.72rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        background: #F9FAFB;
        transition: all 0.15s;
    }

    .adj-pref-chip:hover {
        border-color: var(--warna-ijo);
        background: rgba(149, 205, 65, 0.10);
        color: #6e9c29;
    }

    .adj-pref-chip.active {
        border-color: var(--warna-ijo);
        background: rgba(149, 205, 65, 0.15);
        color: #6e9c29;
        font-weight: 700;
    }

    /* ── Adjust Plan: number chips ── */
    .adj-num-chip {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 0.8px solid #E5E7EB;
        background: #F9FAFB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 700;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s;
    }

    .adj-num-chip:hover {
        border-color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.08);
        color: var(--warna-oren);
    }

    .adj-num-chip.active {
        border-color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.12);
        color: var(--warna-oren);
    }

    /* ── Adjust Plan: slider ── */
    .adj-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 5px;
        border-radius: 50px;
        background: #E5E7EB;
        outline: none;
        cursor: pointer;
    }

    .adj-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--warna-oren);
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
    }

    .adj-slider-protein::-webkit-slider-thumb {
        background: #FB2C36;
    }

    .adj-slider-carbs::-webkit-slider-thumb {
        background: #FE9A00;
    }

    .adj-slider-fat::-webkit-slider-thumb {
        background: #95CD41;
    }

    /* ── Avoid chips ── */
    .adj-avoid-chip {
        background: rgba(234, 92, 43, 0.08);
        border: 0.8px solid rgba(234, 92, 43, 0.25);
        border-radius: 50px;
        padding: 3px 10px;
        font-size: 0.68rem;
        color: var(--warna-oren);
        font-weight: 500;
    }

    /* ================================================================
   MODAL EXTRA STYLES — Plan Manually · Add Meal · Edit Plan
   Tambahkan di bawah style.css yang sudah ada
   ================================================================ */

    /* ── Tombol footer modal ── */
    .btn-cancel-modal {
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        color: #6B7280;
        border-radius: 50px;
        padding: 0.48rem 1.2rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel-modal:hover {
        background: #F3F4F6;
        border-color: #D1D5DB;
        color: #374151;
    }

    /* Tombol simpan — oranye (Plan Manually & Add Meal) */
    .btn-save-modal-oren {
        border: none;
        background: linear-gradient(135deg, #ea5c2b 0%, #f97316 100%);
        color: #fff;
        border-radius: 50px;
        padding: 0.48rem 1.3rem;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(234, 92, 43, 0.35);
        transition: all 0.2s ease;
    }

    .btn-save-modal-oren:hover {
        background: linear-gradient(135deg, #cd4c22 0%, #ea6d0a 100%);
        box-shadow: 0 6px 18px rgba(234, 92, 43, 0.45);
        transform: translateY(-1px);
    }

    /* Tombol simpan — hijau (Edit Plan) */
    .btn-save-modal-ijo {
        border: none;
        background: linear-gradient(135deg, #95cd41 0%, #6ab32b 100%);
        color: #fff;
        border-radius: 50px;
        padding: 0.48rem 1.3rem;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(149, 205, 65, 0.38);
        transition: all 0.2s ease;
    }

    .btn-save-modal-ijo:hover {
        background: linear-gradient(135deg, #7ab535 0%, #5a9a24 100%);
        box-shadow: 0 6px 18px rgba(149, 205, 65, 0.48);
        transform: translateY(-1px);
    }

    /* Tombol hapus — merah tipis */
    .btn-delete-modal {
        border: 1.5px solid #FECACA;
        background: #FFF5F5;
        color: #EF4444;
        border-radius: 50px;
        padding: 0.48rem 1.1rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-delete-modal:hover {
        background: #FEE2E2;
        border-color: #EF4444;
        box-shadow: 0 3px 10px rgba(239, 68, 68, 0.2);
    }

    /* ── Date chips ── */
    .date-chip {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px 9px;
        border-radius: 10px;
        background: #F3F4F6;
        border: 1.5px solid #E5E7EB;
        cursor: pointer;
        transition: all 0.18s ease;
        min-width: 40px;
    }

    .date-chip:hover {
        background: rgba(234, 92, 43, 0.07);
        border-color: var(--warna-oren);
    }

    .date-chip.active {
        background: var(--warna-oren);
        border-color: var(--warna-oren);
        box-shadow: 0 4px 12px rgba(234, 92, 43, 0.35);
    }

    .date-chip.active .dc-day,
    .date-chip.active .dc-num {
        color: #fff;
    }

    .dc-day {
        font-size: 0.6rem;
        font-weight: 600;
        color: #9CA3AF;
        line-height: 1.2;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .dc-num {
        font-size: 0.82rem;
        font-weight: 800;
        color: #374151;
        line-height: 1.3;
    }

    /* ── Time slot cards ── */
    .time-slots-modal {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .time-slot-modal {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 6px 10px;
        border-radius: 10px;
        background: #F9FAFB;
        border: 1.5px solid #E5E7EB;
        cursor: pointer;
        transition: all 0.18s ease;
        min-width: 64px;
    }

    .time-slot-modal:hover {
        background: rgba(149, 205, 65, 0.08);
        border-color: var(--warna-ijo);
    }

    .time-slot-modal.active {
        background: rgba(149, 205, 65, 0.13);
        border-color: var(--warna-ijo);
        box-shadow: 0 3px 10px rgba(149, 205, 65, 0.25);
    }

    .time-slot-modal.active .ts-type {
        color: #446611;
    }

    .ts-type {
        font-size: 0.72rem;
        font-weight: 700;
        color: #374151;
        line-height: 1.3;
    }

    .ts-time {
        font-size: 0.62rem;
        color: #9CA3AF;
        line-height: 1.2;
    }

    /* ── Search input wrapper ── */
    .np-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .np-search-icon {
        position: absolute;
        left: 10px;
        pointer-events: none;
        z-index: 1;
    }

    .np-input-search {
        width: 100%;
        border-radius: 50px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.42rem 0.75rem 0.42rem 2rem;
        font-size: 0.82rem;
        color: #374151;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .np-input-search:focus {
        border-color: var(--warna-oren);
        box-shadow: 0 0 0 3px rgba(234, 92, 43, 0.10);
        background: #fff;
    }

    .np-input-search::placeholder {
        color: #C0C5CD;
        font-size: 0.78rem;
    }

    /* ── Generic modal input ── */
    .np-input-modal {
        width: 100%;
        border-radius: 10px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.4rem 0.7rem;
        font-size: 0.82rem;
        color: #374151;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .np-input-modal:focus {
        border-color: var(--warna-ijo);
        box-shadow: 0 0 0 3px rgba(149, 205, 65, 0.12);
        background: #fff;
    }

    /* ── Textarea ── */
    .np-textarea-modal {
        width: 100%;
        border-radius: 12px;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        padding: 0.5rem 0.75rem;
        font-size: 0.78rem;
        color: #374151;
        outline: none;
        resize: none;
        min-height: 68px;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }

    .np-textarea-modal:focus {
        border-color: var(--warna-ijo);
        box-shadow: 0 0 0 3px rgba(149, 205, 65, 0.12);
        background: #fff;
    }

    .np-textarea-modal::placeholder {
        color: #C0C5CD;
        font-size: 0.75rem;
    }

    /* ── Meal result rows ── */
    .meal-scroll-modal {
        max-height: 180px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding-right: 2px;
    }

    .meal-scroll-modal::-webkit-scrollbar {
        width: 4px;
    }

    .meal-scroll-modal::-webkit-scrollbar-thumb {
        background: #E5E7EB;
        border-radius: 4px;
    }

    .meal-result-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 12px;
        border: 1.5px solid #F3F4F6;
        background: #FAFAFA;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .meal-result-row:hover {
        border-color: rgba(234, 92, 43, 0.25);
        background: rgba(234, 92, 43, 0.04);
    }

    .meal-result-row.selected {
        border-color: var(--warna-oren);
        background: rgba(234, 92, 43, 0.06);
        box-shadow: 0 2px 8px rgba(234, 92, 43, 0.12);
    }

    .mrr-img {
        font-size: 1.5rem;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F3F4F6;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .meal-result-row.selected .mrr-img {
        background: rgba(234, 92, 43, 0.10);
    }

    .mrr-name {
        font-size: 0.78rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 2px;
        line-height: 1.3;
    }

    .mrr-macro {
        font-size: 0.65rem;
        color: #9CA3AF;
        margin: 0;
    }

    .mrr-check {
        font-size: 0.75rem;
        font-weight: 700;
        color: #D1D5DB;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1.5px solid #E5E7EB;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.15s;
    }

    .meal-result-row.selected .mrr-check {
        background: var(--warna-oren);
        border-color: var(--warna-oren);
        color: #fff;
    }

    /* ── Serving buttons ── */
    .serving-btn-modal {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1.5px solid #E5E7EB;
        background: #F9FAFB;
        color: #374151;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        padding: 0;
        line-height: 1;
    }

    .serving-btn-modal:hover {
        background: var(--warna-oren);
        border-color: var(--warna-oren);
        color: #fff;
        box-shadow: 0 3px 8px rgba(234, 92, 43, 0.25);
    }

    /* ── Nutrition preview bar ── */
    .nutri-preview-modal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, rgba(234, 92, 43, 0.06) 0%, rgba(149, 205, 65, 0.06) 100%);
        border: 1.5px solid rgba(234, 92, 43, 0.15);
        border-radius: 14px;
        padding: 10px 14px;
        gap: 4px;
    }

    .np-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .np-stat-val {
        font-size: 0.92rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
    }

    .np-stat-label {
        font-size: 0.58rem;
        color: #9CA3AF;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 1px;
    }

    .np-stat-divider {
        width: 1px;
        height: 28px;
        background: rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
    }

    /* ── Category / tab toggle (Add Meal) ── */
    .tab-toggle-modal {
        display: flex;
        gap: 5px;
        background: #F3F4F6;
        border-radius: 50px;
        padding: 4px;
    }

    .tab-btn-modal {
        border: none;
        background: transparent;
        border-radius: 50px;
        padding: 0.3rem 0.9rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .tab-btn-modal:hover {
        color: #374151;
        background: rgba(255, 255, 255, 0.7);
    }

    .tab-btn-modal.active {
        background: #fff;
        color: var(--warna-oren);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
    }

    /* ── Current meal card (Edit Plan) ── */
    .current-meal-card-modal {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 14px;
        background: rgba(149, 205, 65, 0.06);
        border: 1.5px solid rgba(149, 205, 65, 0.30);
    }

    .cmc-img-modal {
        width: 72px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .cmc-name-modal {
        font-size: 0.85rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 3px;
        line-height: 1.3;
    }

    .cmc-change-modal {
        border: 1.5px solid var(--warna-oren);
        background: transparent;
        color: var(--warna-oren);
        border-radius: 50px;
        padding: 0.3rem 0.8rem;
        font-size: 0.72rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.18s ease;
    }

    .cmc-change-modal:hover {
        background: var(--warna-oren);
        color: #fff;
        box-shadow: 0 3px 10px rgba(234, 92, 43, 0.25);
    }

    /* ── Badge "Editing" di header Edit Plan ── */
    .badge-editing {
        font-size: 0.62rem;
        font-weight: 700;
        background: rgba(234, 92, 43, 0.12);
        color: var(--warna-oren);
        border: 1px solid rgba(234, 92, 43, 0.25);
        border-radius: 50px;
        padding: 2px 9px;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        vertical-align: middle;
    }

    /* ── Nutrition breakdown rows (Edit Plan › Nutrition tab) ── */
    .nutri-breakdown-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 0;
        border-bottom: 0.8px solid rgba(0, 0, 0, 0.05);
    }

    .nutri-breakdown-row:last-child {
        border-bottom: none;
    }

    .nutri-breakdown-label {
        font-size: 0.78rem;
        color: #6B7280;
    }

    .nutri-breakdown-val {
        font-size: 0.82rem;
        font-weight: 700;
        color: #111827;
    }

    /* ── Modal header accent bar ── */
    .modal-content::before {
        content: '';
        display: block;
        height: 3px;
        background: linear-gradient(90deg, var(--warna-oren) 0%, var(--warna-ijo) 100%);
        width: 100%;
        border-radius: 20px 20px 0 0;
    }

    /* ── Subtle modal backdrop ── */
    .modal-content {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.14) !important;
    }

    /* ── Modal header icon tweak ── */
    .modal-header .btn-close {
        opacity: 0.45;
        transition: opacity 0.15s;
    }

    .modal-header .btn-close:hover {
        opacity: 0.85;
    }

    /* ── Scrollbar inside modal body ── */
    .modal-dialog-scrollable .modal-body::-webkit-scrollbar {
        width: 4px;
    }

    .modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb {
        background: #E5E7EB;
        border-radius: 4px;
    }
</style>
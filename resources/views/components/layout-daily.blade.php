{{-- Opsi increment (+) atau decrement (-) bebas buat tiap template, misal water per increment/decrement 200 ml --}}
<div class="daily-list gap-2 p-1">
    {{-- ini untuk template carbs --}}
    <div class="container-content-daily p-2">
        <div class="row g-0 p-0 m-0">
            <div class="col-1 m-0 p-0 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"
                    class="icon-daily-padi d-flex align-items-center ms-0">
                    <g clip-path="url(#clip0_518_1501)">
                        <path d="M1.33337 14.6666L10.6667 5.33331" stroke="black" stroke-width="1.33333"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M2.31335 8.35331L3.33335 7.33331L4.35335 8.35331C4.78895 8.79063 5.03353 9.38273 5.03353 9.99998C5.03353 10.6172 4.78895 11.2093 4.35335 11.6466L3.33335 12.6666L2.31335 11.6466C1.87775 11.2093 1.63318 10.6172 1.63318 9.99998C1.63318 9.38273 1.87775 8.79063 2.31335 8.35331Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M4.97998 5.68669L5.99998 4.66669L7.01998 5.68669C7.45558 6.124 7.70015 6.71611 7.70015 7.33335C7.70015 7.9506 7.45558 8.5427 7.01998 8.98002L5.99998 10L4.97998 8.98002C4.54438 8.5427 4.2998 7.9506 4.2998 7.33335C4.2998 6.71611 4.54438 6.124 4.97998 5.68669Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M7.64673 3.02L8.66673 2L9.68673 3.02C10.1223 3.45732 10.3669 4.04942 10.3669 4.66667C10.3669 5.28391 10.1223 5.87602 9.68673 6.31333L8.66673 7.33333L7.64673 6.31333C7.21113 5.87602 6.96655 5.28391 6.96655 4.66667C6.96655 4.04942 7.21113 3.45732 7.64673 3.02Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M13.3333 1.33331H14.6666V2.66665C14.6666 3.37389 14.3857 4.05217 13.8856 4.55226C13.3855 5.05236 12.7072 5.33331 12 5.33331H10.6666V3.99998C10.6666 3.29274 10.9476 2.61446 11.4477 2.11436C11.9478 1.61426 12.626 1.33331 13.3333 1.33331Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M7.64671 11.6467L8.66671 12.6667L7.64671 13.6867C7.20939 14.1223 6.61729 14.3668 6.00004 14.3668C5.38279 14.3668 4.79069 14.1223 4.35337 13.6867L3.33337 12.6667L4.35337 11.6467C4.79069 11.2111 5.38279 10.9665 6.00004 10.9665C6.61729 10.9665 7.20939 11.2111 7.64671 11.6467Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M10.3133 8.97998L11.3333 9.99998L10.3133 11.02C9.87602 11.4556 9.28391 11.7002 8.66667 11.7002C8.04942 11.7002 7.45732 11.4556 7.02 11.02L6 9.99998L7.02 8.97998C7.45732 8.54438 8.04942 8.2998 8.66667 8.2998C9.28391 8.2998 9.87602 8.54438 10.3133 8.97998Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12.98 6.31335L14 7.33335L12.98 8.35335C12.5426 8.78895 11.9505 9.03353 11.3333 9.03353C10.716 9.03353 10.1239 8.78895 9.68663 8.35335L8.66663 7.33335L9.68663 6.31335C10.1239 5.87775 10.716 5.63318 11.3333 5.63318C11.9505 5.63318 12.5426 5.87775 12.98 6.31335Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_518_1501">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="col-7 ps-1">
                <p class="p-0 m-0 p-card-daily fw-bold">Carbs</p>
                {{-- Ukuran maks dari karbo harian bisa disesuaikan dahulu --}}
                <p class="p-0 m-0 p-card-daily text-muted">180 / 210 g</p>

            </div>
            <div class="col-4">
                <div class="align-items-center d-flex justify-content-end h-100 gap-2">
                    <button class="btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="button btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 2.5V9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-12">
                {{-- Ini buat progress bar di card daily, modifnya ada di width buat progress barnya (progress-bar-daily), aria value itu buat nilai target user --}}
                <div class="progress-daily">
                    <div class="progress-bar-daily" role="progressbar" style="width: 86%" aria-valuenow="180"
                        aria-valuemin="0" aria-valuemax="210">
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                {{-- tiap elemen ini dinamis sesuai progress bar --}}
                <p class="p-0 m-0 p-card-daily text-muted">30 g left</p>
                <p class="p-0 m-0 p-card-daily text-muted">86%</p>
            </div>
        </div>
    </div>
    {{-- ini untuk template Protein --}}
    <div class="container-content-daily p-2">
        <div class="row g-0 p-0 m-0">
            <div class="col-1 m-0 p-0 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"
                    class="icon-daily-apokad d-flex align-items-center ms-0">
                    <g clip-path="url(#clip0_518_1473)">
                        <path
                            d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_518_1473">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="col-7 ps-1">
                <p class="p-0 m-0 p-card-daily fw-bold">Protein</p>
                {{-- Ukuran maks dari protein harian bisa disesuaikan dahulu --}}
                <p class="p-0 m-0 p-card-daily text-muted">65 / 85 g</p>

            </div>
            <div class="col-4">
                <div class="align-items-center d-flex justify-content-end h-100 gap-2">
                    <button class="btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="button btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 2.5V9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-12">
                {{-- Ini buat progress bar di card daily, modifnya ada di width buat progress barnya (progress-bar-daily), aria value itu buat nilai target user --}}
                <div class="progress-daily">
                    <div class="progress-bar-daily-protein" role="progressbar" style="width: 76%" aria-valuenow="65"
                        aria-valuemin="0" aria-valuemax="85">
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                {{-- tiap elemen ini dinamis sesuai progress bar --}}
                <p class="p-0 m-0 p-card-daily text-muted">20 g left</p>
                <p class="p-0 m-0 p-card-daily text-muted">76%</p>
            </div>
        </div>
    </div>
    {{-- ini template untuk fats --}}
    <div class="container-content-daily p-2">
        <div class="row g-0 p-0 m-0">
            <div class="col-1 m-0 p-0 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                    fill="none" class="icon-daily-fats d-flex align-items-center ms-0">
                    <g clip-path="url(#clip0_518_1534)">
                        <path
                            d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                            stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_518_1534">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="col-7 ps-1">
                <p class="p-0 m-0 p-card-daily fw-bold">Fats</p>
                {{-- Ukuran maks dari fats harian bisa disesuaikan dahulu --}}
                <p class="p-0 m-0 p-card-daily text-muted">48 / 65 g</p>

            </div>
            <div class="col-4">
                <div class="align-items-center d-flex justify-content-end h-100 gap-2">
                    <button class="btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="button btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 2.5V9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-12">
                {{-- Ini buat progress bar di card daily, modifnya ada di width buat progress barnya (progress-bar-daily), aria value itu buat nilai target user --}}
                <div class="progress-daily">
                    <div class="progress-bar-daily-fats" role="progressbar" style="width: 77%" aria-valuenow="48"
                        aria-valuemin="0" aria-valuemax="62">
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                {{-- tiap elemen ini dinamis sesuai progress bar --}}
                <p class="p-0 m-0 p-card-daily text-muted">14 g left</p>
                <p class="p-0 m-0 p-card-daily text-muted">77%</p>
            </div>
        </div>
    </div>
    {{-- ini untuk template water --}}
    <div class="container-content-daily p-2">
        <div class="row g-0 p-0 m-0">
            <div class="col-1 m-0 p-0 pt-1">
                <div class="water-icon-daily"></div>
            </div>
            <div class="col-7 ps-1">
                <p class="p-0 m-0 p-card-daily fw-bold">Water</p>
                {{-- Ukuran maks dari karbo harian bisa disesuaikan dahulu --}}
                <p class="p-0 m-0 p-card-daily text-muted">1500 / 2000 ml</p>
            </div>
            <div class="col-4">
                <div class="align-items-center d-flex justify-content-end h-100 gap-2">
                    <button class="btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="button btn-daily p-0 m-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                            fill="none">
                            <path d="M2.5 6H9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 2.5V9.5" stroke="#4A5565" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-12">
                {{-- Ini buat progress bar di card daily, modifnya ada di width buat progress barnya (progress-bar-daily), aria value itu buat nilai target user --}}
                <div class="progress-daily">
                    <div class="progress-bar-daily-water" role="progressbar" style="width: 75%" aria-valuenow="1500"
                        aria-valuemin="0" aria-valuemax="2000">
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                {{-- tiap elemen ini dinamis sesuai progress bar --}}
                <p class="p-0 m-0 p-card-daily text-muted">500 ml left</p>
                <p class="p-0 m-0 p-card-daily text-muted">75%</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notifikasiModal" tabindex="-1" aria-labelledby="notifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable notif-modal-dialog">
        <div class="modal-content notif-modal-content">

            {{-- ── Header ── --}}
            <div class="notif-modal-header d-flex align-items-center justify-content-between px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    {{-- Bell icon --}}
                    <div class="notif-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 23 23"
                            fill="none">
                            <path
                                d="M11.5 23C13.0878 23 14.375 21.7128 14.375 20.125H8.625C8.625 21.7128 9.91218 23 11.5 23Z"
                                fill="white" />
                            <path
                                d="M11.5 2.75748L10.354 2.98892C7.72731 3.51942 5.75003 5.84291 5.75003 8.625C5.75003 9.5275 5.55688 11.7835 5.09041 14.0044C4.85884 15.1068 4.54903 16.2547 4.13726 17.25H18.8627C18.451 16.2547 18.1412 15.1068 17.9096 14.0043C17.4432 11.7835 17.25 9.52749 17.25 8.625C17.25 5.84289 15.2727 3.51939 12.646 2.98891L11.5 2.75748ZM20.4403 17.25C20.7612 17.8931 21.1334 18.4014 21.5625 18.6875H1.4375C1.86663 18.4014 2.23883 17.8931 2.55976 17.25C3.85138 14.6616 4.31253 9.88879 4.31253 8.625C4.31253 5.1453 6.78529 2.24314 10.0695 1.57987C10.0649 1.53304 10.0625 1.48554 10.0625 1.4375C10.0625 0.643591 10.7061 0 11.5 0C12.2939 0 12.9375 0.643591 12.9375 1.4375C12.9375 1.48554 12.9351 1.53303 12.9305 1.57986C16.2147 2.24311 18.6875 5.14528 18.6875 8.625C18.6875 9.88879 19.1486 14.6616 20.4403 17.25Z"
                                fill="white" />
                        </svg>
                    </div>
                    <div>
                        <h6 class="notif-modal-title mb-0" id="notifikasiModalLabel">Notifikasi</h6>
                        <p class="notif-modal-subtitle mb-0">Pengingat makan hari ini</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- Unread count badge --}}
                    <span class="notif-unread-badge" id="notifUnreadCount">3 baru</span>
                    <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>

            {{-- ── Tabs ── --}}
            <div class="notif-tabs-wrap px-4 pt-2 pb-0">
                <div class="notif-tab-toggle">
                    <button class="notif-tab-btn active" data-notif-tab="semua"
                        onclick="switchNotifTab(this, 'semua')">Semua</button>
                    <button class="notif-tab-btn" data-notif-tab="belum" onclick="switchNotifTab(this, 'belum')">Belum
                        Dimakan</button>
                    <button class="notif-tab-btn" data-notif-tab="selesai"
                        onclick="switchNotifTab(this, 'selesai')">Selesai</button>
                </div>
            </div>

            {{-- ── Body ── --}}
            <div class="modal-body notif-modal-body px-3 py-3">

                {{-- ─── TAB: Semua ─── --}}
                <div id="notifTab-semua" class="notif-tab-pane">

                    {{-- Section: Akan Datang --}}
                    <p class="notif-section-label">🕐 Segera</p>

                    {{-- Notif Item 1 — unread, upcoming --}}
                    <div class="notif-item notif-item--unread" data-status="belum">
                        <div class="notif-item__dot"></div>
                        <div class="notif-item__time-col">
                            <span class="notif-time-text">08:00</span>
                            <span class="notif-time-rel">30 mnt lagi</span>
                        </div>
                        <div class="notif-meal-card d-flex align-items-center gap-2 flex-grow-1">
                            <img src="{{ asset('img/meal1_home.png') }}" alt="Avocado Egg Toast" class="notif-meal-img">
                            <div class="notif-meal-info flex-grow-1 min-w-0">
                                <p class="notif-meal-type mb-0">BREAKFAST</p>
                                <h6 class="notif-meal-name mb-1">Avocado Egg Toast</h6>
                                <p class="notif-meal-badges mb-1 d-flex gap-1 flex-wrap">
                                    <span class="text-white px-1 ktg-oren-home">Quick Meal</span>
                                    <span class="text-white px-1 ktg-ijo-home">Balanced</span>
                                </p>
                                <div class="d-flex align-items-center gap-3 notif-nutrition flex-wrap">
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                                stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <p class="font-size-s m-0">280 kcal</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <g clip-path="url(#clip-notif-1)">
                                                <path
                                                    d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip-notif-1">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <p class="font-size-s m-0">10g protein</p>
                                    </div>
                                </div>
                            </div>
                            <button class="notif-btn-done" onclick="markNotifDone(this)" title="Tandai sudah makan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Notif Item 2 — unread --}}
                    <div class="notif-item notif-item--unread" data-status="belum">
                        <div class="notif-item__dot"></div>
                        <div class="notif-item__time-col">
                            <span class="notif-time-text">12:30</span>
                            <span class="notif-time-rel">4 jam lagi</span>
                        </div>
                        <div class="notif-meal-card d-flex align-items-center gap-2 flex-grow-1">
                            <img src="{{ asset('img/meal1_home.png') }}" alt="Grilled Chicken Rice"
                                class="notif-meal-img">
                            <div class="notif-meal-info flex-grow-1 min-w-0">
                                <p class="notif-meal-type mb-0">LUNCH</p>
                                <h6 class="notif-meal-name mb-1">Grilled Chicken Rice</h6>
                                <p class="notif-meal-badges mb-1 d-flex gap-1 flex-wrap">
                                    <span class="text-white px-1 ktg-ijo-home">High Protein</span>
                                    <span class="text-white px-1 ktg-oren-home">Low Fat</span>
                                </p>
                                <div class="d-flex align-items-center gap-3 notif-nutrition flex-wrap">
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                                stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <p class="font-size-s m-0">520 kcal</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <g clip-path="url(#clip-notif-2)">
                                                <path
                                                    d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip-notif-2">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <p class="font-size-s m-0">38g protein</p>
                                    </div>
                                </div>
                            </div>
                            <button class="notif-btn-done" onclick="markNotifDone(this)" title="Tandai sudah makan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Section: Malam --}}
                    <p class="notif-section-label mt-3">🌙 Malam</p>

                    {{-- Notif Item 3 — unread --}}
                    <div class="notif-item notif-item--unread" data-status="belum">
                        <div class="notif-item__dot"></div>
                        <div class="notif-item__time-col">
                            <span class="notif-time-text">19:00</span>
                            <span class="notif-time-rel">10 jam lagi</span>
                        </div>
                        <div class="notif-meal-card d-flex align-items-center gap-2 flex-grow-1">
                            <img src="{{ asset('img/meal1_home.png') }}" alt="Salmon Salad" class="notif-meal-img">
                            <div class="notif-meal-info flex-grow-1 min-w-0">
                                <p class="notif-meal-type mb-0">DINNER</p>
                                <h6 class="notif-meal-name mb-1">Salmon Salad Bowl</h6>
                                <p class="notif-meal-badges mb-1 d-flex gap-1 flex-wrap">
                                    <span class="text-white px-1 ktg-ijo-home">Omega-3</span>
                                    <span class="text-white px-1 ktg-oren-home">Light</span>
                                </p>
                                <div class="d-flex align-items-center gap-3 notif-nutrition flex-wrap">
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M5.66671 9.66667C6.10873 9.66667 6.53266 9.49107 6.84522 9.17851C7.15778 8.86595 7.33337 8.44203 7.33337 8C7.33337 7.08 7.00004 6.66667 6.66671 6C5.95204 4.57133 6.51737 3.29733 8.00004 2C8.33337 3.66667 9.33337 5.26667 10.6667 6.33333C12 7.4 12.6667 8.66667 12.6667 10C12.6667 10.6128 12.546 11.2197 12.3115 11.7859C12.077 12.352 11.7332 12.8665 11.2999 13.2998C10.8665 13.7332 10.3521 14.0769 9.7859 14.3114C9.21971 14.546 8.61288 14.6667 8.00004 14.6667C7.38721 14.6667 6.78037 14.546 6.21418 14.3114C5.648 14.0769 5.13355 13.7332 4.70021 13.2998C4.26687 12.8665 3.92312 12.352 3.6886 11.7859C3.45408 11.2197 3.33337 10.6128 3.33337 10C3.33337 9.23133 3.62204 8.47067 4.00004 8C4.00004 8.44203 4.17564 8.86595 4.4882 9.17851C4.80076 9.49107 5.22468 9.66667 5.66671 9.66667Z"
                                                stroke="#FF6900" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <p class="font-size-s m-0">380 kcal</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 16 16" fill="none">
                                            <g clip-path="url(#clip-notif-3)">
                                                <path
                                                    d="M10.9334 9.13335C11.4802 8.72243 11.9219 8.18791 12.2225 7.57351C12.5231 6.95911 12.674 6.28228 12.6628 5.59839C12.6516 4.9145 12.4787 4.24297 12.1582 3.63872C11.8377 3.03447 11.3787 2.51468 10.8188 2.12184C10.2589 1.72901 9.61389 1.4743 8.93665 1.37855C8.2594 1.2828 7.5691 1.34872 6.92222 1.57093C6.27534 1.79314 5.69025 2.16532 5.2148 2.65704C4.73935 3.14875 4.38705 3.74603 4.18672 4.40001C3.45339 6.48668 3.66672 7.00002 2.06672 8.45335C1.74789 8.71473 1.51763 9.06825 1.40746 9.46553C1.29728 9.86281 1.31257 10.2844 1.45123 10.6727C1.5899 11.0609 1.84516 11.3969 2.18208 11.6345C2.519 11.8721 2.92111 11.9997 3.33339 12C6.00005 12 8.93338 10.8 10.9334 9.13335Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M12.3333 4L13.7933 7C14.0728 7.85924 14.0758 8.78448 13.8019 9.64552C13.5281 10.5066 12.9911 11.2601 12.2666 11.8C10.2666 13.4667 7.33331 14.6667 4.66664 14.6667C4.29548 14.6662 3.93177 14.5624 3.61623 14.3669C3.30069 14.1715 3.04576 13.8921 2.87998 13.56L1.59998 11"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M8.33329 7.33333C9.25377 7.33333 9.99996 6.58714 9.99996 5.66667C9.99996 4.74619 9.25377 4 8.33329 4C7.41282 4 6.66663 4.74619 6.66663 5.66667C6.66663 6.58714 7.41282 7.33333 8.33329 7.33333Z"
                                                    stroke="#00A63E" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip-notif-3">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <p class="font-size-s m-0">29g protein</p>
                                    </div>
                                </div>
                            </div>
                            <button class="notif-btn-done" onclick="markNotifDone(this)" title="Tandai sudah makan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- ─── TAB: Belum Dimakan ─── --}}
                <div id="notifTab-belum" class="notif-tab-pane d-none">
                    {{-- JS will filter & clone items here --}}
                    <p class="notif-section-label">⏳ Belum Dimakan</p>
                    <div id="notifBelumList"></div>
                </div>

                {{-- ─── TAB: Selesai ─── --}}
                <div id="notifTab-selesai" class="notif-tab-pane d-none">
                    <div id="notifSelesaiList">
                        <div class="notif-empty-state">
                            <div class="notif-empty-icon">✅</div>
                            <p class="notif-empty-text">Belum ada meal yang diselesaikan hari ini.</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Footer ── --}}
            <div class="notif-modal-footer px-4 py-3 d-flex align-items-center justify-content-between">
                <button class="notif-btn-mark-all" onclick="markAllDone()">
                    Tandai Semua Selesai
                </button>
                <a href="{{ url('/meal_plan') }}" class="notif-btn-see-plan" data-bs-dismiss="modal">
                    Lihat Meal Plan →
                </a>
            </div>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     JAVASCRIPT
     ════════════════════════════════════════════════════════ --}}
<script>
    /* ── Tab switcher ── */
    function switchNotifTab(btn, tab) {
        document.querySelectorAll('.notif-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.notif-tab-pane').forEach(p => p.classList.add('d-none'));

        if (tab === 'belum') {
            populateBelumTab();
        } else if (tab === 'selesai') {
            // already populated via markNotifDone
        }
        document.getElementById('notifTab-' + tab).classList.remove('d-none');
    }

    /* ── Populate "Belum" tab by cloning unread items ── */
    function populateBelumTab() {
        const list = document.getElementById('notifBelumList');
        list.innerHTML = '';
        const unread = document.querySelectorAll('#notifTab-semua .notif-item--unread:not(.notif-item--done)');
        if (unread.length === 0) {
            list.innerHTML =
                '<div class="notif-empty-state"><div class="notif-empty-icon">🎉</div><p class="notif-empty-text">Semua meal sudah selesai!</p></div>';
            return;
        }
        unread.forEach(item => {
            const clone = item.cloneNode(true);
            // re-bind button
            clone.querySelector('.notif-btn-done')?.addEventListener('click', function() {
                markNotifDone(this);
            });
            list.appendChild(clone);
        });
    }

    /* ── Mark single item done ── */
    function markNotifDone(btn) {
        const item = btn.closest('.notif-item');
        item.classList.remove('notif-item--unread');
        item.classList.add('notif-item--done');

        // Move to Selesai list
        const selesaiList = document.getElementById('notifSelesaiList');
        const emptyState = selesaiList.querySelector('.notif-empty-state');
        if (emptyState) emptyState.remove();

        const clone = item.cloneNode(true);
        clone.querySelector('.notif-btn-done')?.remove();
        const doneLabel = document.createElement('span');
        doneLabel.className = 'notif-done-badge';
        doneLabel.textContent = '✓ Selesai';
        clone.querySelector('.notif-meal-info')?.appendChild(doneLabel);
        selesaiList.appendChild(clone);

        updateUnreadCount();
    }

    /* ── Mark all done ── */
    function markAllDone() {
        document.querySelectorAll('#notifTab-semua .notif-item--unread:not(.notif-item--done)').forEach(item => {
            const btn = item.querySelector('.notif-btn-done');
            if (btn) markNotifDone(btn);
        });
    }

    /* ── Update badge count ── */
    function updateUnreadCount() {
        const count = document.querySelectorAll('#notifTab-semua .notif-item--unread:not(.notif-item--done)').length;
        const badge = document.getElementById('notifUnreadCount');
        const navBadge = document.getElementById('notifNavBadge');

        if (count === 0) {
            if (badge) badge.textContent = 'Semua selesai';
            if (navBadge) navBadge.style.display = 'none';
        } else {
            if (badge) badge.textContent = count + ' baru';
            if (navBadge) {
                navBadge.textContent = count;
                navBadge.style.display = 'flex';
            }
        }
    }
</script>

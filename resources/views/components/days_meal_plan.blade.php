<div class="col-12 mt-3">
    <div class="row py-0 g-3">

        {{-- ============ LEFT: Motivational Card ============ --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-12">
            <div class="card-motivasi p-3">
                <div class="mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L13.5 8.5H19L14.5 11.7L16 17.2L12 14L8 17.2L9.5 11.7L5 8.5H10.5L12 3Z"
                            stroke="#EA5C2B" stroke-width="1.5" stroke-linejoin="round" fill="rgba(234,92,43,0.1)" />
                        <path d="M5 3.5L5.8 5.3M3.5 5L5.3 5.8M19 3.5L18.2 5.3M20.5 5L18.7 5.8" stroke="#95CD41"
                            stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
                <h6 class="fw-bold mb-1">Stay consistent!</h6>
                <p class="tgl text-muted mb-0">Small steps every day build a healthier you.</p>
            </div>
        </div>

        {{-- ============ MIDDLE: Meal Plan Timeline ============ --}}
        <div class="col-xl-6 col-lg-5 col-md-8 col-12">

            {{-- Header --}}
            <div class="mb-3">
                <h5 class="fw-bold mb-0">Meal Plan &ndash; Today</h5>
                <p class="tgl text-muted mb-2">{{ date('l, d F Y') }}</p>

                {{-- Date nav + Add button --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-1">
                        <button class="btn-nav-date">&#8249;</button>
                        <span class="date-pill">{{ date('M j') }}</span>
                        <button class="btn-nav-date">&#8250;</button>
                    </div>
                    <button data-bs-toggle="modal" data-bs-target="#modalAddMeal"
                        class="btn oren text-white rounded-pill add-meal-btn fw-bold">
                        + Add Meal or Drinks or Snacks
                    </button>
                </div>
            </div>

            {{-- Meals container --}}
            <div class="wrapper-meal-days p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0 fw-bold">Meals &amp; Drinks</h5>
                    <p class="text-muted tgl m-0">5 Meals &middot; 1.2L Water</p>
                </div>

                {{-- Timeline meals --}}
                <div class="timeline-meals">

                    @include('components.meal_template', [
                        'time' => '8:00',
                        'meal_type' => 'BREAKFAST',
                        'meal_name' => 'Avocado Toast & Poached Eggs',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Quick Meal',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'Balanced',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '420',
                        'protein' => '22',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '10:30',
                        'meal_type' => 'SNACK',
                        'meal_name' => 'Greek Yogurt with Berries',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Light',
                        'ktg1_class' => 'ktg-ijo-home',
                        'ktg2_label' => 'High Protein',
                        'ktg2_class' => 'ktg-oren-home',
                        'kcal' => '180',
                        'protein' => '14',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '13:00',
                        'meal_type' => 'LUNCH',
                        'meal_name' => 'Grilled Chicken Quinoa Bowl',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'High Protein',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'Balanced',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '560',
                        'protein' => '38',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '16:00',
                        'meal_type' => 'SNACK',
                        'meal_name' => 'Mixed Nuts & Apple',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'Energy',
                        'ktg1_class' => 'ktg-ijo-home',
                        'ktg2_label' => 'Quick Meal',
                        'ktg2_class' => 'ktg-oren-home',
                        'kcal' => '220',
                        'protein' => '7',
                        'is_last' => false,
                    ])

                    @include('components.meal_template', [
                        'time' => '19:30',
                        'meal_type' => 'DINNER',
                        'meal_name' => 'Salmon with Roasted Vegetables',
                        'meal_image' => 'meal1_home.png',
                        'ktg1_label' => 'High Protein',
                        'ktg1_class' => 'ktg-oren-home',
                        'ktg2_label' => 'Balanced',
                        'ktg2_class' => 'ktg-ijo-home',
                        'kcal' => '610',
                        'protein' => '42',
                        'is_last' => true,
                    ])

                </div>
            </div>
        </div>

        {{-- ============ RIGHT: Nutrition Panel ============ --}}
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">

            {{-- Nutrition Summary --}}
            <div class="nutrition-panel p-3 mb-3">
                <h5 class="fw-bold mb-0">Nutrition Summary</h5>
                <p class="tgl text-muted mb-3">Macronutrient breakdown</p>

                {{-- Donut chart --}}
                {{--
                    Circumference (r=45): 2 * π * 45 ≈ 282.74
                    Protein  492 kcal → 69.9  | start: rotate(-90)
                    Carbs    840 kcal → 119.4 | start: rotate(-1.1)
                    Fat      522 kcal → 74.2  | start: rotate(150.8)
                --}}
                <div class="d-flex justify-content-center mb-3">
                    <div class="donut-wrapper">
                        <svg viewBox="0 0 120 120" width="160" height="160" aria-label="Macronutrient donut chart">
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB"
                                stroke-width="10" />
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#FB2C36"
                                stroke-width="10" stroke-dasharray="69.9 282.74" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#FE9A00"
                                stroke-width="10" stroke-dasharray="119.4 282.74" stroke-linecap="round"
                                transform="rotate(-1.1 60 60)" />
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#95CD41"
                                stroke-width="10" stroke-dasharray="74.2 282.74" stroke-linecap="round"
                                transform="rotate(150.8 60 60)" />
                        </svg>
                        <div class="donut-center-text">
                            <p class="fw-bold mb-0 donut-kcal-num">1,990</p>
                            <p class="tgl mb-0 text-muted donut-kcal-label">kcal today</p>
                        </div>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#FB2C36"></span>
                            <span class="tgl">Protein</span>
                        </div>
                        <p class="fw-bold tgl mb-0">123g</p>
                    </div>
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#FE9A00"></span>
                            <span class="tgl">Carbs</span>
                        </div>
                        <p class="fw-bold tgl mb-0">210g</p>
                    </div>
                    <div class="text-center">
                        <div class="d-flex align-items-center gap-1 justify-content-center">
                            <span class="legend-dot" style="background:#95CD41"></span>
                            <span class="tgl">Fat</span>
                        </div>
                        <p class="fw-bold tgl mb-0">58g</p>
                    </div>
                </div>
            </div>

            {{-- Daily Goals --}}
            <div class="nutrition-panel p-3 mb-3">
                <h5 class="fw-bold mb-3">Daily Goals</h5>

                @php
                    $goals = [
                        [
                            'label' => 'Calories',
                            'current' => 1990,
                            'target' => 2200,
                            'unit' => 'g',
                            'bar_class' => 'progress-bar-daily',
                        ],
                        [
                            'label' => 'Protein',
                            'current' => 123,
                            'target' => 150,
                            'unit' => 'g',
                            'bar_class' => 'progress-bar-daily-protein',
                        ],
                        [
                            'label' => 'Carbs',
                            'current' => 210,
                            'target' => 260,
                            'unit' => 'g',
                            'bar_class' => 'progress-bar-daily-fats',
                        ],
                        [
                            'label' => 'Fat',
                            'current' => 58,
                            'target' => 70,
                            'unit' => 'g',
                            'bar_class' => 'progress-bar-daily-water',
                        ],
                    ];
                @endphp

                @foreach ($goals as $goal)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="tgl mb-1">{{ $goal['label'] }}</p>
                            <p class="tgl mb-1 text-muted">{{ $goal['current'] }} /
                                {{ $goal['target'] }}{{ $goal['unit'] }}</p>
                        </div>
                        <div class="progress-daily">
                            <div class="{{ $goal['bar_class'] }}"
                                style="width: {{ min(($goal['current'] / $goal['target']) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Nutrition Tip --}}
            <div class="nutrition-panel p-3 mb-3">
                <div class="d-flex gap-2 align-items-start">
                    <div class="tip-icon-circle flex-shrink-0 d-flex align-items-center justify-content-center">
                        <span class="fw-bold tip-icon-num">9</span>
                    </div>
                    <div>
                        <p class="tgl fw-bold mb-1">Add more protein</p>
                        <p class="tgl text-muted mb-0" style="font-size:0.7rem">
                            You're 27g away from your protein goal. Try a Greek yogurt snack.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Adjust Meal Plan button --}}
            <button data-bs-toggle="modal" data-bs-target="#modalAdjustPlan"
                class="btn ijo text-white w-100 rounded-pill py-2 fw-bold">
                Adjust Meal Plan
            </button>

        </div>
    </div>
    @include('components.modal_add_meal')
    @include('components.modal_adjust_meal_plan')
</div>
<script>
    // ── ADD MEAL ────────────────────────────────────────────────
    let amServ = 1;

    function amSelectCategory(btn, cat) {
        btn.closest('#am-category-row').querySelectorAll('.tab-btn-modal')
            .forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function amSelectSlot(el) {
        el.closest('#am-slot-row').querySelectorAll('.time-slot-modal')
            .forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }

    function amToggleItem(el) {
        el.closest('.meal-scroll-modal').querySelectorAll('.meal-result-row')
            .forEach(r => r.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('am-kcal').textContent = el.dataset.kcal + '';
        document.getElementById('am-protein').textContent = el.dataset.protein + 'g';
        document.getElementById('am-carbs').textContent = el.dataset.carbs + 'g';
        document.getElementById('am-fat').textContent = el.dataset.fat + 'g';
    }

    function amQuickSelect(el) {
        document.getElementById('am-search').value = el.textContent.replace(/^.\s/, '');
        amFilterItems(el.textContent);
    }

    function amFilterItems(q) {
        document.querySelectorAll('#am-item-list .meal-result-row').forEach(r => {
            const name = r.querySelector('.mrr-name').textContent.toLowerCase();
            r.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    function amChangeServ(d) {
        amServ = Math.max(1, amServ + d);
        document.getElementById('am-serv-val').textContent = amServ;
    }

    function amToggleManual() {
        const el = document.getElementById('am-manual-area');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }

    function amSave() {
        bootstrap.Modal.getInstance(document.getElementById('modalAddMeal')).hide();
    }

    // ── ADJUST PLAN ─────────────────────────────────────────────
    function adjUpdateKcal(val) {
        document.getElementById('adj-kcal-val').textContent = val + ' kcal';
    }

    function adjUpdateMacro(type, val) {
        document.getElementById('adj-' + type + '-pct').textContent = val + '%';
        document.getElementById('adj-bar-' + type).style.width = val + '%';
    }

    function adjTogglePref(el) {
        el.classList.toggle('active');
    }

    function adjSelectMeals(el) {
        el.closest('#adj-meals-per-day').querySelectorAll('.adj-num-chip')
            .forEach(c => c.classList.remove('active'));
        el.classList.add('active');
    }

    function adjSave() {
        bootstrap.Modal.getInstance(document.getElementById('modalAdjustPlan')).hide();
    }
</script>
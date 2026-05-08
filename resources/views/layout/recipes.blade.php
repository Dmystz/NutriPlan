@extends('layout.layout')

{{-- Section Recipes --}}

@section('title', 'Recipes')
@section('content')


    <div class="col-12 py-2">
        <div class="row py-0 g-3">

            {{-- ── SIDEBAR ── --}}
            <div class="col-12 col-md-3 col-xl-2">
                <div class="recipes-sidebar">
                    <input type="text" class="filter-search-box mb-2" placeholder="Search by recipes and more">

                    {{-- Meal Type --}}
                    <div class="filter-group-title">
                        <span>🍽 Meal Type</span> <span>›</span>
                    </div>
                    @php
                        $mealTypes = ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Desserts', 'Drinks'];
                    @endphp
                    @foreach ($mealTypes as $t)
                        <div class="filter-item {{ $t === 'Breakfast' ? 'active' : '' }}">
                            <span class="filter-dot {{ $t === 'Breakfast' ? 'oren' : '' }}"></span>{{ $t }}
                        </div>
                    @endforeach

                    {{-- Preferences --}}
                    <div class="filter-group-title" style="background:var(--warna-oren); color:#fff;">
                        <span>⚙ Preferences</span> <span>›</span>
                    </div>
                    @php
                        $prefs = [
                            'Vegetarian',
                            'Vegan',
                            'Low-Carb',
                            'Gluten-Free',
                            'Keto',
                            'Dairy-Free',
                            'High-Protein',
                            'Low-Calorie',
                            'Quick Meals',
                        ];
                    @endphp
                    @foreach ($prefs as $p)
                        <div class="filter-item"><span class="filter-dot"></span>{{ $p }}</div>
                    @endforeach
                </div>
            </div>

            {{-- ── MAIN CONTENT ── --}}
            <div class="col-12 col-md-9 col-xl-10">

                {{-- Hero banner + Your Recipes --}}
                <div class="d-flex gap-3 mb-3 align-items-stretch">
                    <div class="recipes-hero-banner flex-grow-1">
                        <h5 class="mb-1">✨ Got a Recipes That Rocks?</h5>
                        <p class="mb-2">Share it &amp; Plan!</p>
                        <a href="#" class="btn-add-recipe" data-bs-toggle="modal" data-bs-target="#modalAddRecipe">
                            + Add Recipes
                        </a>
                    </div>
                    <a href="#" class="btn-your-recipe">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 31 31"
                            fill="none">
                            <path
                                d="M15.5 21.9583H21.9583C22.6717 21.9583 23.25 21.38 23.25 20.6667V7.75C23.25 6.32327 22.0934 5.16667 20.6667 5.16667L11.625 5.16667C9.4849 5.16667 7.75 6.90157 7.75 9.04167L7.75 23.8958"
                                stroke="white" stroke-width="1.8" />
                            <path
                                d="M22.4997 25.8333C22.5477 25.8333 22.5789 25.7826 22.5583 25.7393C21.9617 24.4852 21.9739 23.2312 22.5948 21.9771C22.5991 21.9685 22.5929 21.9583 22.5833 21.9583L9.6875 21.9583C8.61745 21.9583 7.75 22.8258 7.75 23.8958C7.75 24.9659 8.61745 25.8333 9.6875 25.8333L22.4997 25.8333Z"
                                stroke="white" stroke-width="1.8" />
                            <path
                                d="M14.2083 5.425C14.2083 5.28232 14.3239 5.16666 14.4666 5.16666H19.1166C19.2593 5.16666 19.3749 5.28232 19.3749 5.425V11.0954C19.3749 11.3106 19.1272 11.4314 18.9575 11.2989L16.9506 9.73102C16.8572 9.65801 16.726 9.65801 16.6325 9.73102L14.6256 11.2989C14.456 11.4314 14.2083 11.3106 14.2083 11.0954V5.425Z"
                                stroke="white" stroke-width="1.8" />
                        </svg>
                        Your Recipes
                    </a>
                </div>

                {{-- Recommended --}}
                <div class="section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M9 5H7C5.895 5 5 5.895 5 7V19C5 20.105 5.895 21 7 21H17C18.105 21 19 20.105 19 19V7C19 5.895 18.105 5 17 5H15M9 5C9 5.552 9.448 6 10 6H14C14.552 6 15 5.552 15 5M9 5C9 4.448 9.448 4 10 4H14C14.552 4 15 4.448 15 5"
                            stroke="#374151" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Recommended
                </div>

                @php
                    $recommended = [
                        [
                            'name' => 'Overnight Chia Pudding',
                            'desc' =>
                                'Overnight Chia Seeds is a simple and nutritious meal made by soaking chia seeds in liquid such as milk or plant...',
                            'tags' => [['Breakfast', '#95CD41'], ['Vegan', '#2B7FFF'], ['#7min', '#6B7280']],
                        ],
                        [
                            'name' => 'Tortilla Egg Sandwich',
                            'desc' =>
                                'A tortilla egg sandwich is a simple dish made by combining eggs with tortilla. The eggs are usually co...',
                            'tags' => [['Lunch', '#EA5C2B'], ['Quick Meal', '#95CD41'], ['#8min', '#6B7280']],
                        ],
                        [
                            'name' => 'Grilled Chicken Salad',
                            'desc' =>
                                'A nutritious dish made with grilled chicken breast, fresh vegetables, and light dressing. High in protein and goo...',
                            'tags' => [['Salad', '#95CD41'], ['High-Protein', '#EA5C2B'], ['#20min', '#6B7280']],
                        ],
                        [
                            'name' => 'Vegetable Stir Fry',
                            'desc' =>
                                'A quick dish made by sautéing mixed vegetables over high heat in a wok with sesame oil and soy sauce...',
                            'tags' => [['Vegan', '#2B7FFF'], ['Low-Carb', '#FBBF24'], ['#15min', '#6B7280']],
                        ],
                    ];
                @endphp
                <div class="row py-0 g-3 mb-3">
                    @foreach ($recommended as $recipe)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="recipe-card">
                                <img src="{{ asset('img/meal1_home.png') }}" alt="{{ $recipe['name'] }}">
                                <div class="recipe-card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <p class="recipe-card-title mb-0">{{ $recipe['name'] }}</p>
                                        <span class="recipe-card-menu">⋮</span>
                                    </div>
                                    <p class="recipe-card-desc">{{ $recipe['desc'] }}</p>
                                    <div class="d-flex gap-1 flex-wrap">
                                        @foreach ($recipe['tags'] as $tag)
                                            <span class="recipe-tag"
                                                style="background:{{ $tag[1] }}">{{ $tag[0] }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Popular --}}
                <div class="section-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5C5.754 5 4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            stroke="#374151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Popular
                </div>

                @php
                    $popular = [
                        [
                            'name' => 'Tomato Basil Soup',
                            'desc' =>
                                'A warm and comforting soup made from fresh tomatoes, basil, and simple seasonings. It is blended until smooth...',
                            'tags' => [['Soup', '#EA5C2B'], ['Vegan', '#95CD41'], ['#15min', '#6B7280']],
                        ],
                        [
                            'name' => 'Cinnamon Rolls',
                            'desc' =>
                                'A soft and sweet pastry made from rolled dough filled with cinnamon sugar, then baked until fluffy and golden...',
                            'tags' => [['Dessert', '#FBBF24'], ['Baked', '#A78BFA'], ['#60min', '#6B7280']],
                        ],
                        [
                            'name' => 'Spinach and Feta Omelettes',
                            'desc' =>
                                'A healthy and savory dish made with eggs, free spinach, and feta cheese. The omelette is cooked until fluffsy...',
                            'tags' => [['Breakfast', '#95CD41'], ['High-Protein', '#EA5C2B'], ['#10min', '#6B7280']],
                        ],
                        [
                            'name' => 'Acai Bowl',
                            'desc' =>
                                'A refreshing and nutritious bowl made from blended acai berries, usually topped with granola, fruits...',
                            'tags' => [['Vegan', '#2B7FFF'], ['Breakfast', '#95CD41'], ['#5min', '#6B7280']],
                        ],
                    ];
                @endphp
                <div class="row py-0 g-3">
                    @foreach ($popular as $recipe)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="recipe-card">
                                <img src="{{ asset('img/meal1_home.png') }}" alt="{{ $recipe['name'] }}">
                                <div class="recipe-card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <p class="recipe-card-title mb-0">{{ $recipe['name'] }}</p>
                                        <span class="recipe-card-menu">⋮</span>
                                    </div>
                                    <p class="recipe-card-desc">{{ $recipe['desc'] }}</p>
                                    <div class="d-flex gap-1 flex-wrap">
                                        @foreach ($recipe['tags'] as $tag)
                                            <span class="recipe-tag"
                                                style="background:{{ $tag[1] }}">{{ $tag[0] }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    @include('components.modal_add_recipes')
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    // ── List / search all meals  (GET /nutrition) ──────────────────────
    public function index(Request $request)
    {
        $search = $request->query('search');

        $meals = Meal::search($search)
                     ->orderBy('name')
                     ->paginate(9)
                     ->withQueryString();   // keep ?search= on pagination links

        // First meal is the "hero" shown in detail panel
        $featured = $meals->first();

        return view('layout.nutrition', compact('meals', 'featured', 'search'));
    }

    // ── Single meal detail  (GET /nutrition/{meal}) ────────────────────
    public function show(Meal $meal)
    {
        return view('layout.nutrition_detail', compact('meal'));
    }
}
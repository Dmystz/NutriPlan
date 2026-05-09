<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query
            ->select(
                'id',
                'name',
                'emoji',
                'image_path',
                'category',
                'calories',
                'protein',
                'carbs',
                'fat',
                'description'
            )
            ->orderBy('name')
            ->limit(40)
            ->get();

        return response()->json($foods);
    }
}
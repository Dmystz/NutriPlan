<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealLogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'food_id'  => 'nullable|integer',
            'name'     => 'required|string|max:120',
            'category' => 'required|in:meal,drink,snack',
            'meal_slot'=> 'nullable|string|max:30',
            'meal_time'=> 'nullable|string',
            'calories' => 'required|numeric|min:0',
            'protein'  => 'required|numeric|min:0',
            'carbs'    => 'required|numeric|min:0',
            'fat'      => 'required|numeric|min:0',
            'servings' => 'required|integer|min:1',
        ]);

        $data['user_id']    = auth()->id();   // null kalau belum pakai auth
        $data['log_date']   = now()->toDateString();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('planner_food')->insertGetId($data);

        return response()->json([
            'message' => 'Berhasil ditambahkan',
            'id'      => $id,
        ], 201);
    }

    public function index(Request $request)
    {
        $logs = DB::table('planner_food')
            ->whereDate('log_date', now()->toDateString())
            ->orderBy('meal_time')
            ->get();

        return response()->json($logs);
    }
}
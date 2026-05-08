<?php

namespace App\Http\Controllers;

use App\Models\Planner;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function index()
    {
        return response()->json(Planner::with(['user', 'jadwalMakanan', 'katalogResep'])->get());
    }

    public function show($id)
    {
        $planner = Planner::with(['user', 'jadwalMakanan.katalogResep', 'katalogResep'])->findOrFail($id);
        return response()->json($planner);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $planner = Planner::create($validated);
        return response()->json($planner, 201);
    }

    public function destroy($id)
    {
        Planner::findOrFail($id)->delete();
        return response()->json(['message' => 'Planner berhasil dihapus']);
    }
}
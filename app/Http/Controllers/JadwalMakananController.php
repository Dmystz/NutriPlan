<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwalmakanan;

class JadwalMakananController extends Controller
{
    public function index()
    {
        $mealplans = Jadwalmakanan::with('recipe')->get();

        return view(
            'layout.meal_plan',
            compact('mealplans')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'katalog_resep_id' => 'required',
            'tanggal' => 'required|date',
            'meal_type' => 'required'
        ]);

        Jadwalmakanan::create([
            'katalog_resep_id' => $request->katalog_resep_id,
            'tanggal' => $request->tanggal,
            'meal_type' => $request->meal_type,
            'user_id' => session('user_id')
        ]);

        return redirect('/meal_plan')
            ->with('success', 'Meal plan added');
    }

    public function destroy($id)
    {
        Jadwalmakanan::findOrFail($id)->delete();

        return redirect('/meal_plan')
            ->with('success', 'Meal plan deleted');
    }
}
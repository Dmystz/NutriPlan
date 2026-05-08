<?php

namespace App\Http\Controllers;

use App\Models\JadwalMakanan;
use Illuminate\Http\Request;

class JadwalMakananController extends Controller
{
    public function index()
    {
        return response()->json(JadwalMakanan::with(['planner', 'katalogResep'])->get());
    }

    public function show($id)
    {
        $jadwal = JadwalMakanan::with(['planner.user', 'katalogResep'])->findOrFail($id);
        return response()->json($jadwal);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'planner_id'       => 'required|exists:planners,id',
            'katalog_resep_id' => 'required|exists:katalog_resep,id',
            'tanggal_kalender' => 'required|date',
            'goals'            => 'nullable|string',
        ]);

        $jadwal = JadwalMakanan::create($validated);
        return response()->json($jadwal, 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalMakanan::findOrFail($id);

        $validated = $request->validate([
            'katalog_resep_id' => 'sometimes|exists:katalog_resep,id',
            'tanggal_kalender' => 'sometimes|date',
            'goals'            => 'nullable|string',
        ]);

        $jadwal->update($validated);
        return response()->json($jadwal);
    }

    public function destroy($id)
    {
        JadwalMakanan::findOrFail($id)->delete();
        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }
}
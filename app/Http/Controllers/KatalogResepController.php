<?php

namespace App\Http\Controllers;

use App\Models\KatalogResep;
use Illuminate\Http\Request;

class KatalogResepController extends Controller
{
    public function index()
    {
        return response()->json(KatalogResep::all());
    }

    public function show($id)
    {
        $resep = KatalogResep::with('jadwalMakanan')->findOrFail($id);
        return response()->json($resep);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_makanan'  => 'required|string',
            'ingredients'   => 'nullable|string',
            'total_nutrisi' => 'nullable|numeric',
        ]);

        $resep = KatalogResep::create($validated);
        return response()->json($resep, 201);
    }

    public function update(Request $request, $id)
    {
        $resep = KatalogResep::findOrFail($id);

        $validated = $request->validate([
            'nama_makanan'  => 'sometimes|string',
            'ingredients'   => 'nullable|string',
            'total_nutrisi' => 'nullable|numeric',
        ]);

        $resep->update($validated);
        return response()->json($resep);
    }

    public function destroy($id)
    {
        KatalogResep::findOrFail($id)->delete();
        return response()->json(['message' => 'Resep berhasil dihapus']);
    }
}
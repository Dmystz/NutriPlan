<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * GET /api/foods?category=meal&search=ayam
     * Dipakai modal untuk live search & filter kategori.
     */
    public function index(Request $request)
    {
        $query = Food::active();

        if ($request->filled('category')) {
            $query->category($request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $foods = $query->orderBy('name')->limit(30)->get()->map(fn($f) => [
            'id'          => $f->id,
            'name'        => $f->name,
            'emoji'       => $f->emoji,
            'image_url'   => $f->image_url,   // dari accessor
            'category'    => $f->category,
            'calories'    => $f->calories,
            'protein'     => $f->protein,
            'carbs'       => $f->carbs,
            'fat'         => $f->fat,
            'description' => $f->description,
        ]);

        return response()->json($foods);
    }

    /**
     * POST /admin/foods
     * Tambah makanan baru + upload gambar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:120',
            'emoji'       => 'nullable|string|max:10',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'    => 'required|in:meal,drink,snack',
            'calories'    => 'required|integer|min:0',
            'protein'     => 'required|numeric|min:0',
            'carbs'       => 'required|numeric|min:0',
            'fat'         => 'required|numeric|min:0',
            'description' => 'nullable|string|max:60',
        ]);

        // ── Simpan gambar ke storage/app/public/foods/ ──
        if ($request->hasFile('image')) {
            // Simpan → storage/app/public/foods/namafile.jpg
            // URL publik  → /storage/foods/namafile.jpg
            $validated['image_path'] = $request->file('image')
                ->store('foods', 'public');
        }

        $food = Food::create($validated);

        return response()->json($food, 201);
    }

    /**
     * PUT /admin/foods/{food}
     * Update termasuk ganti gambar.
     */
    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:120',
            'emoji'       => 'nullable|string|max:10',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'    => 'sometimes|in:meal,drink,snack',
            'calories'    => 'sometimes|integer|min:0',
            'protein'     => 'sometimes|numeric|min:0',
            'carbs'       => 'sometimes|numeric|min:0',
            'fat'         => 'sometimes|numeric|min:0',
            'description' => 'nullable|string|max:60',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($food->image_path) {
                Storage::disk('public')->delete($food->image_path);
            }
            $validated['image_path'] = $request->file('image')
                ->store('foods', 'public');
        }

        $food->update($validated);

        return response()->json($food);
    }

    /**
     * DELETE /admin/foods/{food}
     */
    public function destroy(Food $food)
    {
        if ($food->image_path) {
            Storage::disk('public')->delete($food->image_path);
        }
        $food->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
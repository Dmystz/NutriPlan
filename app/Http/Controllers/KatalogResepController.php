<?php

namespace App\Http\Controllers;

use App\Models\KatalogResep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogResepController extends Controller
{
    // ══════════════════════════════
    //  INDEX — Halaman Recipes
    // ══════════════════════════════

    public function index(Request $request)
    {
        $query = KatalogResep::public();

        // Filter & Search
        if ($request->filled('meal_type')) {
            $query->mealType($request->meal_type);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('max_calories')) {
            $query->maxCalories((int) $request->max_calories);
        }

        if ($request->filled('tag')) {
            $tag = $request->tag;
            $query->whereJsonContains('tags', $tag);
        }

        $resep = $query->orderBy('nama_makanan')->paginate(12);

        // Untuk JSON API (dipakai JS fetch)
        if ($request->expectsJson()) {
            return response()->json($resep);
        }

        return view('layout.recipes', compact('resep'));
    }

    // ══════════════════════════════
    //  SHOW — Detail resep
    // ══════════════════════════════

    public function show(int $id, Request $request)
    {
        $resep = KatalogResep::with('jadwalMakanan')->findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json($resep->append('image_url'));
        }

        return view('layout.nutrition', compact('resep'));
    }

    // ══════════════════════════════
    //  STORE — Tambah resep baru
    // ══════════════════════════════

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_makanan' => 'required|string|max:200',
            'ingredients'  => 'nullable|string',
            'cara_masak'   => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snack',
            'difficulty'   => 'nullable|in:easy,medium,hard',
            'cook_time'    => 'nullable|integer|min:0',
            'servings'     => 'nullable|integer|min:1',
            'description'  => 'nullable|string|max:500',
            'tags'         => 'nullable|array',
            'is_public'    => 'nullable|boolean',
            'calories'     => 'nullable|integer|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'fiber'        => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('resep', 'public');
        }

        $validated['user_id']  = session('user_id');
        $validated['is_public'] = $validated['is_public'] ?? true;

        // Konversi tags ke JSON kalau dari form
        if ($request->has('tags') && is_array($request->tags)) {
            $validated['tags'] = $request->tags;
        }

        $resep = KatalogResep::create($validated);

        if ($request->expectsJson()) {
            return response()->json($resep->append('image_url'), 201);
        }

        return redirect('/recipes')->with('success', 'Resep berhasil dipublish! 🎉');
    }

    // ══════════════════════════════
    //  UPDATE — Edit resep
    // ══════════════════════════════

    public function update(Request $request, int $id)
    {
        $resep = KatalogResep::findOrFail($id);

        // Hanya pemilik yang bisa edit
        if ($resep->user_id && $resep->user_id !== session('user_id')) {
            abort(403, 'Tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama_makanan' => 'sometimes|string|max:200',
            'ingredients'  => 'nullable|string',
            'cara_masak'   => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snack',
            'calories'     => 'nullable|integer|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if ($resep->image_path) {
                Storage::disk('public')->delete($resep->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('resep', 'public');
        }

        $resep->update($validated);

        if ($request->expectsJson()) {
            return response()->json($resep->append('image_url'));
        }

        return back()->with('success', 'Resep diperbarui.');
    }

    // ══════════════════════════════
    //  DESTROY — Hapus resep
    // ══════════════════════════════

    public function destroy(int $id)
    {
        $resep = KatalogResep::findOrFail($id);

        if ($resep->user_id && $resep->user_id !== session('user_id')) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($resep->image_path) {
            Storage::disk('public')->delete($resep->image_path);
        }

        $resep->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Resep dihapus.']);
        }

        return redirect('/recipes')->with('success', 'Resep dihapus.');
    }
}
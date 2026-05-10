<?php

namespace App\Http\Controllers;

use App\Models\KatalogResep;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KatalogResepController extends Controller
{
    /* ══════════════════════════════════════════════════
       WEB — view blade (GET /recipes sudah ada di web.php,
       tinggal ganti closure ke controller ini jika perlu)
       ══════════════════════════════════════════════════ */

    /**
     * Halaman utama Recipes (opsional — bisa tetap pakai closure di web.php).
     * Jika ingin data langsung dikirim ke blade, aktifkan route ini.
     */
    public function index(Request $request)
    {
        $userId = session('user_id');

        $recommended = KatalogResep::visible($userId)
            ->latest()
            ->take(8)
            ->get();

        $popular = KatalogResep::visible($userId)
            ->orderByDesc('calories')   // ganti dengan kolom "views/likes" jika ada
            ->take(8)
            ->get();

        return view('layout.recipes', compact('recommended', 'popular'));
    }

    /* ══════════════════════════════════════════════════
       API — dipakai oleh fetch() di JavaScript
       ══════════════════════════════════════════════════ */

    /**
     * GET /api/recipes
     * Query params: search, meal_type, tags (comma-separated), per_page
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $userId  = session('user_id');
        $query   = KatalogResep::visible($userId)->with('user:id,name');

        // Filter pencarian teks
        if ($search = $request->query('search')) {
            $query->search($search);
        }

        // Filter meal type
        if ($mealType = $request->query('meal_type')) {
            $query->byMealType($mealType);
        }

        // Filter tag (contoh: ?tags=Vegan,Keto)
        if ($tags = $request->query('tags')) {
            $tagList = array_map('trim', explode(',', $tags));
            foreach ($tagList as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        $perPage = min((int) $request->query('per_page', 12), 50);
        $recipes = $query->latest()->paginate($perPage);

        // Tambahkan accessor ke setiap item
        $recipes->getCollection()->transform(function (KatalogResep $r) {
            $r->append(['image_url', 'meal_type_color']);
            return $r;
        });

        return response()->json($recipes);
    }

    /**
     * GET /api/recipes/recommended
     * 4–8 resep terbaru untuk section "Recommended".
     */
    public function recommended(Request $request): JsonResponse
    {
        $userId  = session('user_id');
        $recipes = KatalogResep::visible($userId)
            ->latest()
            ->take((int) $request->query('limit', 4))
            ->get()
            ->each->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipes]);
    }

    /**
     * GET /api/recipes/popular
     * 4–8 resep untuk section "Popular".
     */
    public function popular(Request $request): JsonResponse
    {
        $userId  = session('user_id');
        $recipes = KatalogResep::visible($userId)
            ->orderByDesc('calories')
            ->take((int) $request->query('limit', 4))
            ->get()
            ->each->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipes]);
    }

    /**
     * GET /api/recipes/{id}
     * Detail satu resep.
     */
    public function show(int $id): JsonResponse
    {
        $userId = session('user_id');
        $recipe = KatalogResep::visible($userId)->findOrFail($id);
        $recipe->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipe]);
    }

    /**
     * POST /api/recipes
     * Simpan resep baru (milik user yang sedang login).
     */
    public function store(Request $request): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'nama_makanan' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snacks,desserts,drinks',
            'difficulty'   => 'nullable|in:easy,medium,hard',
            'cook_time'    => 'nullable|integer|min:1',
            'servings'     => 'nullable|integer|min:1',
            'ingredients'  => 'nullable|array',
            'cara_masak'   => 'nullable|array',
            'tags'         => 'nullable|array',
            'is_public'    => 'boolean',
            'calories'     => 'nullable|integer|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'fiber'        => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|max:2048',  // file upload opsional
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data            = $validator->validated();
        $data['user_id'] = $userId;

        // Hitung total_nutrisi sederhana
        $data['total_nutrisi'] = ($data['protein'] ?? 0) * 4
            + ($data['carbs'] ?? 0) * 4
            + ($data['fat'] ?? 0) * 9;

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('recipes', 'public');
        }

        unset($data['image']); // hapus key file sebelum insert

        $recipe = KatalogResep::create($data);
        $recipe->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipe, 'message' => 'Resep berhasil disimpan.'], 201);
    }

    /**
     * PUT /api/recipes/{id}
     * Update resep milik user sendiri.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $recipe = KatalogResep::where('user_id', $userId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_makanan' => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snacks,desserts,drinks',
            'difficulty'   => 'nullable|in:easy,medium,hard',
            'cook_time'    => 'nullable|integer|min:1',
            'servings'     => 'nullable|integer|min:1',
            'ingredients'  => 'nullable|array',
            'cara_masak'   => 'nullable|array',
            'tags'         => 'nullable|array',
            'is_public'    => 'boolean',
            'calories'     => 'nullable|integer|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'fiber'        => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Recalculate total_nutrisi jika ada perubahan makro
        if (isset($data['protein'], $data['carbs'], $data['fat'])) {
            $data['total_nutrisi'] = $data['protein'] * 4
                + $data['carbs'] * 4
                + $data['fat'] * 9;
        }

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            $data['image_path'] = $request->file('image')
                ->store('recipes', 'public');
        }

        unset($data['image']);

        $recipe->update($data);
        $recipe->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipe, 'message' => 'Resep berhasil diperbarui.']);
    }

    /**
     * DELETE /api/recipes/{id}
     * Hapus resep milik user sendiri.
     */
    public function destroy(int $id): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $recipe = KatalogResep::where('user_id', $userId)->findOrFail($id);

        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }

        $recipe->delete();

        return response()->json(['message' => 'Resep berhasil dihapus.']);
    }

    /**
     * GET /api/recipes/mine
     * Semua resep milik user yang sedang login ("Your Recipes").
     */
    public function mine(Request $request): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $recipes = KatalogResep::where('user_id', $userId)
            ->latest()
            ->paginate(12);

        $recipes->getCollection()->transform(function (KatalogResep $r) {
            return $r->append(['image_url', 'meal_type_color']);
        });

        return response()->json($recipes);
    }
}
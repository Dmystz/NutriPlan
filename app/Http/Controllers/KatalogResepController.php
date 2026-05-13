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
       HELPER — decode array field yang mungkin datang
       sebagai JSON string (dari FormData) atau sudah array
       (dari JSON body / application/json).
       ══════════════════════════════════════════════════ */
    private function decodeArrayField(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    private function normalizeTextArray(mixed $value): string
    {
        if (is_array($value)) {
            return implode("\n", $value);
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return implode("\n", $decoded);
            }
        }
        return (string) ($value ?? '');
    }

    /* ══════════════════════════════════════════════════
       WEB — view blade
       ══════════════════════════════════════════════════ */
    public function index(Request $request)
    {
        $userId = session('user_id');

        $recommended = KatalogResep::visible($userId)
            ->latest()
            ->take(8)
            ->get();

        $popular = KatalogResep::visible($userId)
            ->orderByDesc('calories')
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
        $userId = session('user_id');
        $query  = KatalogResep::visible($userId)->with('user:id,name');

        if ($search = $request->query('search')) {
            $query->search($search);
        }

        if ($mealType = $request->query('meal_type')) {
            $query->byMealType($mealType);
        }

        if ($tags = $request->query('tags')) {
            $tagList = array_map('trim', explode(',', $tags));
            foreach ($tagList as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        $perPage = min((int) $request->query('per_page', 12), 50);
        $recipes = $query->latest()->paginate($perPage);

        $recipes->getCollection()->transform(function (KatalogResep $r) {
            $r->append(['image_url', 'meal_type_color']);
            return $r;
        });

        return response()->json($recipes);
    }

    /**
     * GET /api/recipes/recommended
     */
    public function recommended(Request $request): JsonResponse
    {
        $userId  = session('user_id');
        $recipes = KatalogResep::visible($userId)
            ->latest()
            ->take((int) $request->query('limit', 4))
            ->get()
            ->each->append(['image_url', 'meal_type_color']);

        $data = $recipes->map(function($r) {
            $arr = $r->toArray();
            $arr['ingredients'] = $r->ingredients_list;
            $arr['cara_masak']  = $r->cara_masak_list;
            return $arr;
        });

        return response()->json(['data' => $data]);
    }

    public function popular(Request $request): JsonResponse
    {
        $userId  = session('user_id');
        $recipes = KatalogResep::visible($userId)
            ->orderByDesc('calories')
            ->take((int) $request->query('limit', 4))
            ->get()
            ->each->append(['image_url', 'meal_type_color']);

        $data = $recipes->map(function($r) {
            $arr = $r->toArray();
            $arr['ingredients'] = $r->ingredients_list;
            $arr['cara_masak']  = $r->cara_masak_list;
            return $arr;
        });

        return response()->json(['data' => $data]);
    }

    /**
     * GET /api/recipes/{id}
     */
    public function show(int $id): JsonResponse
    {
        $userId = session('user_id');
        $recipe = KatalogResep::visible($userId)->findOrFail($id);
        $recipe->append(['image_url', 'meal_type_color']);

        // Konversi ingredients & cara_masak ke array sebelum return
        $data = $recipe->toArray();
        $data['ingredients'] = $recipe->ingredients_list;
        $data['cara_masak']  = $recipe->cara_masak_list;

        return response()->json(['data' => $data]);
    }

    /**
     * POST /api/recipes
     *
     * Menerima dua format request:
     *  1. multipart/form-data  → ada file image; ingredients/cara_masak/tags dikirim sebagai JSON string
     *  2. application/json     → tidak ada file; ingredients/cara_masak/tags sudah array
     *
     * Keduanya ditangani oleh decodeArrayField().
     */
    public function store(Request $request): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        /*
         * Normalisasi: jika ingredients / cara_masak / tags datang sebagai
         * JSON string (FormData), decode dulu agar validasi 'array' lolos.
         */
        $request->merge([
            'ingredients' => $this->normalizeTextArray($request->input('ingredients')),
            'cara_masak'  => $this->normalizeTextArray($request->input('cara_masak')),
            'tags'        => $this->decodeArrayField($request->input('tags')),
        ]);

        $validator = Validator::make($request->all(), [
            'nama_makanan' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snacks,desserts,drinks',
            'difficulty'   => 'nullable|in:easy,medium,hard',
            'cook_time'    => 'nullable|integer|min:1',
            'servings'     => 'nullable|integer|min:1',

            'ingredients'  => 'nullable|string',
            'cara_masak'   => 'nullable|string',

            'tags'         => 'nullable|array',
            'tags.*'       => 'string',

            'is_public'    => 'nullable|boolean',

            'calories'     => 'nullable|numeric|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'fiber'        => 'nullable|numeric|min:0',

            'image'        => 'nullable|image|max:5120',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data            = $validator->validated();
        $data['user_id'] = $userId;

        // Pastikan is_public ter-cast ke boolean
        $data['is_public'] = filter_var($request->input('is_public', true), FILTER_VALIDATE_BOOLEAN);

        // Hitung total_nutrisi
        $data['total_nutrisi'] = (float)($data['protein'] ?? 0) * 4
            + (float)($data['carbs'] ?? 0) * 4
            + (float)($data['fat'] ?? 0) * 9;

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('recipes', 'public');
        }

        unset($data['image']);

        $recipe = KatalogResep::create($data);
        $recipe->append(['image_url', 'meal_type_color']);

        return response()->json(['data' => $recipe, 'message' => 'Resep berhasil disimpan.'], 201);
    }

    /**
     * PUT /api/recipes/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $recipe = KatalogResep::where('user_id', $userId)->findOrFail($id);

        // Normalisasi array fields
        $request->merge([

        'ingredients' => (function() use ($request) {
            $val = $request->input('ingredients');
            if (is_array($val)) return implode("\n", $val);
            $decoded = json_decode($val, true);
            if (is_array($decoded)) return implode("\n", $decoded);
            return $val; // sudah string biasa
        })(),

        'cara_masak' => (function() use ($request) {
            $val = $request->input('cara_masak');
            if (is_array($val)) return implode("\n", $val);
            $decoded = json_decode($val, true);
            if (is_array($decoded)) return implode("\n", $decoded);
            return $val;
        })(),
        ]);

        $validator = Validator::make($request->all(), [
            'nama_makanan' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'meal_type'    => 'nullable|in:breakfast,lunch,dinner,snacks,desserts,drinks',
            'difficulty'   => 'nullable|in:easy,medium,hard',
            'cook_time'    => 'nullable|integer|min:1',
            'servings'     => 'nullable|integer|min:1',

            'ingredients'  => 'nullable|string',
            'cara_masak'   => 'nullable|string',

            'tags'         => 'nullable|array',
            'tags.*'       => 'string',

            'is_public'    => 'nullable|boolean',

            'calories'     => 'nullable|numeric|min:0',
            'protein'      => 'nullable|numeric|min:0',
            'carbs'        => 'nullable|numeric|min:0',
            'fat'          => 'nullable|numeric|min:0',
            'fiber'        => 'nullable|numeric|min:0',

            'image'        => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (isset($data['protein'], $data['carbs'], $data['fat'])) {
            $data['total_nutrisi'] = (float)$data['protein'] * 4
                + (float)$data['carbs'] * 4
                + (float)$data['fat'] * 9;
        }

        if ($request->hasFile('image')) {
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
<?php

namespace Database\Seeders;

use App\Models\KatalogResep;
use Illuminate\Database\Seeder;

class KatalogResepSeeder extends Seeder
{
    public function run(): void
    {
        $resep = [
            // ── BREAKFAST ──────────────────────────────────────────────
            [
                'nama_makanan' => 'Avocado Toast & Poached Eggs',
                'description'  => 'Roti panggang dengan alpukat dan telur rebus. Kaya lemak sehat dan protein.',
                'meal_type'    => 'breakfast',
                'difficulty'   => 'easy',
                'cook_time'    => 15,
                'servings'     => 1,
                'calories'     => 420,
                'protein'      => 22,
                'carbs'        => 38,
                'fat'          => 20,
                'fiber'        => 7,
                'tags'         => ['Quick Meal', 'Balanced', 'High-Protein'],
                'ingredients'  => json_encode([
                    ['name' => 'Whole grain bread', 'qty' => '2 slices'],
                    ['name' => 'Avocado', 'qty' => '1 medium'],
                    ['name' => 'Egg', 'qty' => '2 butir'],
                    ['name' => 'Lemon juice', 'qty' => '1 tsp'],
                    ['name' => 'Salt & pepper', 'qty' => 'secukupnya'],
                ]),
                'cara_masak'   => json_encode([
                    'Panaskan air hingga mendidih, tambahkan sedikit cuka.',
                    'Pecahkan telur satu per satu ke dalam air mendidih, masak 3-4 menit.',
                    'Panggang roti hingga keemasan.',
                    'Haluskan alpukat, beri perasan lemon, garam, dan merica.',
                    'Oleskan alpukat ke roti, letakkan telur di atasnya. Sajikan.',
                ]),
                'is_public'    => true,
            ],
            [
                'nama_makanan' => 'Overnight Oats with Berries',
                'description'  => 'Oat yang direndam semalam dengan susu dan buah-buahan segar.',
                'meal_type'    => 'breakfast',
                'difficulty'   => 'easy',
                'cook_time'    => 5,
                'servings'     => 1,
                'calories'     => 350,
                'protein'      => 14,
                'carbs'        => 58,
                'fat'          => 8,
                'fiber'        => 8,
                'tags'         => ['Quick Meal', 'High-Protein', 'Low-Carb'],
                'ingredients'  => json_encode([
                    ['name' => 'Rolled oats', 'qty' => '80g'],
                    ['name' => 'Susu almond', 'qty' => '200ml'],
                    ['name' => 'Greek yogurt', 'qty' => '100g'],
                    ['name' => 'Mixed berries', 'qty' => '100g'],
                    ['name' => 'Madu', 'qty' => '1 tsp'],
                ]),
                'cara_masak'   => json_encode([
                    'Campur oat, susu, dan yogurt dalam wadah kedap udara.',
                    'Simpan di kulkas semalaman minimal 6 jam.',
                    'Saat disajikan, tambahkan berries dan madu di atasnya.',
                ]),
                'is_public'    => true,
            ],

            // ── LUNCH ─────────────────────────────────────────────────
            [
                'nama_makanan' => 'Grilled Chicken Quinoa Bowl',
                'description'  => 'Ayam panggang dengan quinoa, sayuran, dan saus lemon. Tinggi protein.',
                'meal_type'    => 'lunch',
                'difficulty'   => 'medium',
                'cook_time'    => 30,
                'servings'     => 1,
                'calories'     => 560,
                'protein'      => 38,
                'carbs'        => 62,
                'fat'          => 14,
                'fiber'        => 6,
                'tags'         => ['High-Protein', 'Balanced', 'Gluten-Free'],
                'ingredients'  => json_encode([
                    ['name' => 'Chicken breast', 'qty' => '200g'],
                    ['name' => 'Quinoa', 'qty' => '100g'],
                    ['name' => 'Baby spinach', 'qty' => '50g'],
                    ['name' => 'Cherry tomato', 'qty' => '100g'],
                    ['name' => 'Olive oil', 'qty' => '2 tbsp'],
                    ['name' => 'Lemon', 'qty' => '1 buah'],
                    ['name' => 'Garlic', 'qty' => '2 siung'],
                ]),
                'cara_masak'   => json_encode([
                    'Marinasi ayam dengan olive oil, bawang putih, lemon, garam.',
                    'Panggang ayam 20 menit atau hingga matang (internal 74°C).',
                    'Masak quinoa sesuai petunjuk kemasan (~15 menit).',
                    'Susun quinoa, ayam irisan, sayuran di mangkuk.',
                    'Siram dengan saus lemon-olive oil. Sajikan hangat.',
                ]),
                'is_public'    => true,
            ],
            [
                'nama_makanan' => 'Nasi Ayam Bakar Kecap',
                'description'  => 'Ayam bakar bumbu kecap khas Indonesia dengan nasi putih dan lalapan.',
                'meal_type'    => 'lunch',
                'difficulty'   => 'medium',
                'cook_time'    => 45,
                'servings'     => 1,
                'calories'     => 580,
                'protein'      => 42,
                'carbs'        => 65,
                'fat'          => 16,
                'fiber'        => 2,
                'tags'         => ['High-Protein'],
                'ingredients'  => json_encode([
                    ['name' => 'Ayam potong', 'qty' => '250g'],
                    ['name' => 'Kecap manis', 'qty' => '3 tbsp'],
                    ['name' => 'Bawang putih', 'qty' => '4 siung'],
                    ['name' => 'Bawang merah', 'qty' => '5 siung'],
                    ['name' => 'Kemiri', 'qty' => '3 butir'],
                    ['name' => 'Nasi putih', 'qty' => '200g'],
                    ['name' => 'Lalapan (timun, kemangi)', 'qty' => 'secukupnya'],
                ]),
                'cara_masak'   => json_encode([
                    'Blender bawang putih, bawang merah, dan kemiri hingga halus.',
                    'Tumis bumbu halus hingga harum, masukkan kecap manis.',
                    'Lumuri ayam dengan bumbu, diamkan 30 menit.',
                    'Panggang ayam di atas bara api atau oven 200°C, sambil dioles bumbu.',
                    'Sajikan dengan nasi dan lalapan segar.',
                ]),
                'is_public'    => true,
            ],

            // ── DINNER ─────────────────────────────────────────────────
            [
                'nama_makanan' => 'Salmon with Roasted Vegetables',
                'description'  => 'Salmon panggang dengan sayuran roasted. Kaya omega-3 dan antioksidan.',
                'meal_type'    => 'dinner',
                'difficulty'   => 'medium',
                'cook_time'    => 25,
                'servings'     => 1,
                'calories'     => 480,
                'protein'      => 42,
                'carbs'        => 22,
                'fat'          => 24,
                'fiber'        => 5,
                'tags'         => ['High-Protein', 'Keto', 'Gluten-Free'],
                'ingredients'  => json_encode([
                    ['name' => 'Salmon fillet', 'qty' => '200g'],
                    ['name' => 'Brokoli', 'qty' => '150g'],
                    ['name' => 'Wortel', 'qty' => '100g'],
                    ['name' => 'Paprika', 'qty' => '100g'],
                    ['name' => 'Olive oil', 'qty' => '2 tbsp'],
                    ['name' => 'Dill (opsional)', 'qty' => 'secukupnya'],
                    ['name' => 'Lemon', 'qty' => '1 buah'],
                ]),
                'cara_masak'   => json_encode([
                    'Potong sayuran, lumuri olive oil, garam, merica.',
                    'Panggang sayuran di oven 200°C selama 15 menit.',
                    'Beri lemon dan bumbu pada salmon.',
                    'Panggang salmon 10-12 menit hingga matang.',
                    'Sajikan salmon di atas sayuran roasted.',
                ]),
                'is_public'    => true,
            ],

            // ── SNACK ──────────────────────────────────────────────────
            [
                'nama_makanan' => 'Greek Yogurt with Berries',
                'description'  => 'Yogurt Greek creamy dengan topping buah-buahan segar dan granola.',
                'meal_type'    => 'snack',
                'difficulty'   => 'easy',
                'cook_time'    => 5,
                'servings'     => 1,
                'calories'     => 180,
                'protein'      => 14,
                'carbs'        => 20,
                'fat'          => 4,
                'fiber'        => 2,
                'tags'         => ['Light', 'High-Protein', 'Quick Meal'],
                'ingredients'  => json_encode([
                    ['name' => 'Greek yogurt', 'qty' => '200g'],
                    ['name' => 'Mixed berries', 'qty' => '80g'],
                    ['name' => 'Granola', 'qty' => '30g'],
                    ['name' => 'Madu', 'qty' => '1 tsp'],
                ]),
                'cara_masak'   => json_encode([
                    'Tuang Greek yogurt ke dalam mangkuk.',
                    'Tambahkan mixed berries di atasnya.',
                    'Taburi granola dan siram madu. Sajikan dingin.',
                ]),
                'is_public'    => true,
            ],
            [
                'nama_makanan' => 'Mixed Nuts & Apple',
                'description'  => 'Kacang campuran dan apel segar. Snack tinggi serat dan energi.',
                'meal_type'    => 'snack',
                'difficulty'   => 'easy',
                'cook_time'    => 0,
                'servings'     => 1,
                'calories'     => 220,
                'protein'      => 7,
                'carbs'        => 18,
                'fat'          => 14,
                'fiber'        => 4,
                'tags'         => ['Quick Meal', 'Vegan', 'Gluten-Free'],
                'ingredients'  => json_encode([
                    ['name' => 'Kacang almond', 'qty' => '20g'],
                    ['name' => 'Kacang walnut', 'qty' => '15g'],
                    ['name' => 'Apel hijau', 'qty' => '1 medium'],
                ]),
                'cara_masak'   => json_encode([
                    'Cuci apel dan potong menjadi beberapa bagian.',
                    'Sajikan bersama kacang-kacangan dalam mangkuk kecil.',
                ]),
                'is_public'    => true,
            ],
        ];

        foreach ($resep as $data) {
            KatalogResep::firstOrCreate(
                ['nama_makanan' => $data['nama_makanan']],
                $data
            );
        }
    }
}
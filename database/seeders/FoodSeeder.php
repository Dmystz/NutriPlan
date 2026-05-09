<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // ── MEAL ──────────────────────────────────────────────
            [
                'name'        => 'Grilled Chicken Quinoa Bowl',
                'emoji'       => '🥗',
                'image_path'  => null,   // isi path setelah upload, misal: 'foods/chicken-quinoa.jpg'
                'category'    => 'meal',
                'calories'    => 560,
                'protein'     => 38,
                'carbs'       => 62,
                'fat'         => 14,
                'description' => 'Balanced',
            ],
            [
                'name'        => 'Ayam Bakar Kecap',
                'emoji'       => '🍗',
                'image_path'  => null,
                'category'    => 'meal',
                'calories'    => 480,
                'protein'     => 42,
                'carbs'       => 30,
                'fat'         => 18,
                'description' => 'High Protein',
            ],
            [
                'name'        => 'Nasi Putih + Tempe',
                'emoji'       => '🍚',
                'image_path'  => null,
                'category'    => 'meal',
                'calories'    => 390,
                'protein'     => 18,
                'carbs'       => 72,
                'fat'         => 6,
                'description' => 'Local Favorite',
            ],

            // ── DRINK ─────────────────────────────────────────────
            [
                'name'        => 'Jus Jeruk Segar',
                'emoji'       => '🥤',
                'image_path'  => null,
                'category'    => 'drink',
                'calories'    => 90,
                'protein'     => 0,
                'carbs'       => 22,
                'fat'         => 0,
                'description' => 'Vitamin C',
            ],
            [
                'name'        => 'Susu Full Cream',
                'emoji'       => '🥛',
                'image_path'  => null,
                'category'    => 'drink',
                'calories'    => 150,
                'protein'     => 8,
                'carbs'       => 12,
                'fat'         => 8,
                'description' => 'Calcium Rich',
            ],
            [
                'name'        => 'Air Kelapa Muda',
                'emoji'       => '🌴',
                'image_path'  => null,
                'category'    => 'drink',
                'calories'    => 60,
                'protein'     => 0,
                'carbs'       => 15,
                'fat'         => 0,
                'description' => 'Electrolytes',
            ],

            // ── SNACK ─────────────────────────────────────────────
            [
                'name'        => 'Greek Yogurt with Berries',
                'emoji'       => '🥛',
                'image_path'  => null,
                'category'    => 'snack',
                'calories'    => 180,
                'protein'     => 14,
                'carbs'       => 20,
                'fat'         => 4,
                'description' => 'Light',
            ],
            [
                'name'        => 'Mixed Nuts & Apple',
                'emoji'       => '🥜',
                'image_path'  => null,
                'category'    => 'snack',
                'calories'    => 220,
                'protein'     => 7,
                'carbs'       => 18,
                'fat'         => 14,
                'description' => 'Energy Boost',
            ],
            [
                'name'        => 'Pisang Ambon',
                'emoji'       => '🍌',
                'image_path'  => null,
                'category'    => 'snack',
                'calories'    => 105,
                'protein'     => 1,
                'carbs'       => 27,
                'fat'         => 0,
                'description' => 'Natural Sugar',
            ],
        ];

        foreach ($items as $item) {
            Food::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}
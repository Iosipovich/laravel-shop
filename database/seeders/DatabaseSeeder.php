<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    // Категории
    \App\Models\Category::create(['name' => 'Телефоны']);
    \App\Models\Category::create(['name' => 'Ноутбуки']);
    \App\Models\Category::create(['name' => 'Планшеты']);

    // Товары
    \App\Models\Product::create([
        'name' => 'iPhone 14',
        'description' => 'Новый смартфон от Apple',
        'price' => 999,
        'discount_price' => 899,
        'brand' => 'Apple',
        'specs' => json_encode(['screen' => '6.1"', 'storage' => '128GB']),
        'image' => 'https://via.placeholder.com/300x200?text=iPhone+14',
        'category_id' => 1,
    ]);
    \App\Models\Product::create([
        'name' => 'Samsung Galaxy S23',
        'description' => 'Флагман от Samsung',
        'price' => 899,
        'discount_price' => 799,
        'brand' => 'Samsung',
        'specs' => json_encode(['screen' => '6.2"', 'storage' => '256GB']),
        'image' => 'https://via.placeholder.com/300x200?text=Galaxy+S23',
        'category_id' => 1,
    ]);
    \App\Models\Product::create([
        'name' => 'MacBook Air M2',
        'description' => 'Лёгкий и мощный ноутбук',
        'price' => 1299,
        'discount_price' => 1199,
        'brand' => 'Apple',
        'specs' => json_encode(['screen' => '13.6"', 'ram' => '8GB']),
        'image' => 'https://via.placeholder.com/300x200?text=MacBook+Air',
        'category_id' => 2,
    ]);
}
}

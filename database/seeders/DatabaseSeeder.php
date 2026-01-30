<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@nairobifashion.co.ke',
            'password' => Hash::make('password'),
            'is_admin' => true
        ]);

        // Create Categories
        $categories = [
            ['name' => 'T-Shirts', 'description' => 'Casual and comfortable t-shirts'],
            ['name' => 'Jeans', 'description' => 'Premium denim jeans'],
            ['name' => 'Dresses', 'description' => 'Elegant dresses for all occasions'],
            ['name' => 'Shirts', 'description' => 'Formal and casual shirts'],
            ['name' => 'Hoodies', 'description' => 'Warm and stylish hoodies']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Sample Products
        Product::create([
            'category_id' => 1,
            'name' => 'Classic White T-Shirt',
            'description' => 'Premium cotton t-shirt perfect for everyday wear',
            'price' => 1200,
            'cost_price' => 600,
            'stock_quantity' => 50,
            'images' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400'],
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['White', 'Black', 'Navy'],
            'is_featured' => true,
            'is_active' => true
        ]);
    }
}

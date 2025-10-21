<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create categories first
        $categories = [
            ['name' => 'Makanan Utama', 'description' => 'Menu makanan utama'],
            ['name' => 'Minuman', 'description' => 'Berbagai jenis minuman'],
            ['name' => 'Dessert', 'description' => 'Menu pencuci mulut'],
            ['name' => 'Snack', 'description' => 'Camilan ringan'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
        }

        $makananUtama = Category::where('name', 'Makanan Utama')->first();
        $minuman = Category::where('name', 'Minuman')->first();
        $dessert = Category::where('name', 'Dessert')->first();
        $snack = Category::where('name', 'Snack')->first();

        // Create sample menus
        $menus = [
            // Makanan Utama
            [
                'category_id' => $makananUtama->id,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
                'price' => 25000,
                'stock' => 50,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Ayam Bakar Madu',
                'description' => 'Ayam bakar dengan bumbu madu yang lezat',
                'price' => 35000,
                'stock' => 30,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Sate Kambing',
                'description' => 'Sate kambing dengan bumbu kacang yang nikmat',
                'price' => 40000,
                'stock' => 25,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Gado-gado',
                'description' => 'Sayuran segar dengan bumbu kacang khas Indonesia',
                'price' => 20000,
                'stock' => 40,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Rendang Daging',
                'description' => 'Rendang daging sapi dengan bumbu rempah pilihan',
                'price' => 45000,
                'stock' => 20,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Mie Ayam',
                'description' => 'Mie ayam dengan topping lengkap dan kuah kaldu',
                'price' => 18000,
                'stock' => 60,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Soto Ayam',
                'description' => 'Soto ayam dengan kuah bening dan bumbu rempah',
                'price' => 22000,
                'stock' => 35,
                'is_active' => true
            ],
            [
                'category_id' => $makananUtama->id,
                'name' => 'Bakso Urat',
                'description' => 'Bakso urat dengan kuah kaldu sapi yang gurih',
                'price' => 15000,
                'stock' => 45,
                'is_active' => true
            ],

            // Minuman
            [
                'category_id' => $minuman->id,
                'name' => 'Es Teh Manis',
                'description' => 'Es teh manis segar',
                'price' => 5000,
                'stock' => 100,
                'is_active' => true
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Jus Jeruk',
                'description' => 'Jus jeruk segar tanpa pengawet',
                'price' => 12000,
                'stock' => 50,
                'is_active' => true
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Kopi Tubruk',
                'description' => 'Kopi tubruk khas Indonesia',
                'price' => 8000,
                'stock' => 40,
                'is_active' => true
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Campur',
                'description' => 'Es campur dengan berbagai topping',
                'price' => 15000,
                'stock' => 30,
                'is_active' => true
            ],

            // Dessert
            [
                'category_id' => $dessert->id,
                'name' => 'Pudding Coklat',
                'description' => 'Pudding coklat dengan saus vanilla',
                'price' => 10000,
                'stock' => 25,
                'is_active' => true
            ],
            [
                'category_id' => $dessert->id,
                'name' => 'Klepon',
                'description' => 'Klepon dengan gula merah dan kelapa parut',
                'price' => 8000,
                'stock' => 30,
                'is_active' => true
            ],

            // Snack
            [
                'category_id' => $snack->id,
                'name' => 'Keripik Singkong',
                'description' => 'Keripik singkong renyah dengan bumbu balado',
                'price' => 12000,
                'stock' => 40,
                'is_active' => true
            ],
            [
                'category_id' => $snack->id,
                'name' => 'Tahu Crispy',
                'description' => 'Tahu crispy dengan saus sambal',
                'price' => 10000,
                'stock' => 35,
                'is_active' => true
            ]
        ];

        foreach ($menus as $menuData) {
            Menu::create($menuData);
        }

        $this->command->info('Menu seeder completed successfully!');
    }
}
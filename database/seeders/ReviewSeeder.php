<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Menu;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users and menus for seeding
        $users = User::whereHas('role', function($query) {
            $query->where('name', 'user');
        })->take(5)->get();
        
        $menus = Menu::where('is_active', true)->take(10)->get();

        if ($users->isEmpty() || $menus->isEmpty()) {
            $this->command->warn('No users or menus found. Please run UserSeeder and MenuSeeder first.');
            return;
        }

        // Create sample reviews
        $reviews = [
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 5,
                'comment' => 'Sangat enak! Rasa autentik dan porsi yang cukup. Pasti akan pesan lagi.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 4,
                'comment' => 'Enak banget, tapi agak pedas. Cocok untuk yang suka pedas.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 3,
                'comment' => 'Rasa biasa saja, tapi harga terjangkau.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 5,
                'comment' => 'Mantap! Pelayanan cepat dan makanan masih hangat.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 2,
                'comment' => 'Kurang sesuai ekspektasi. Makanan agak dingin saat sampai.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 4,
                'comment' => 'Overall bagus, tapi bisa lebih pedas lagi.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 5,
                'comment' => 'Perfect! Rasa dan tekstur pas banget. Recommended!'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 1,
                'comment' => 'Sangat mengecewakan. Makanan tidak fresh dan rasanya aneh.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 4,
                'comment' => 'Enak dan bergizi. Porsi cukup untuk 2 orang.'
            ],
            [
                'user_id' => $users->random()->id,
                'menu_id' => $menus->random()->id,
                'rating' => 3,
                'comment' => 'Lumayan, tapi harganya agak mahal untuk porsi segitu.'
            ]
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        $this->command->info('Review seeder completed successfully!');
    }
}
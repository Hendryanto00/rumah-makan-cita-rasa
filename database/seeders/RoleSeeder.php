<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Pelanggan']
        );

        Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Admin Pengelola']
        );

        Role::firstOrCreate(
            ['name' => 'owner'],
            ['description' => 'Pemilik/Owner']
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(ServiceSeeder::class);

        $user = User::factory()->create([
            'name' => 'ibrahim',
            'email' => 'a@a.a',
            'password' =>Hash::make('a'),
        ]);
        $user->assignRole('admin');
    }
}

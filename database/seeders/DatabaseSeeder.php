<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient\Patient;
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

        User::factory()->count(50)->create()->each(function ($user) {
            $user->assignRole('patient');
            Patient::create([
                'user_id' => $user->id,
                'phone' => '01000000000',
                'address' => '123 Street Egypt',
            ]);
        });
    }
}

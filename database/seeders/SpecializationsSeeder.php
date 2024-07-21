<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;
use Faker\Factory as Faker;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed specializations
        $specializations = [
            ['name' => 'Cardiology'],
            ['name' => 'Neurology'],
            ['name' => 'Orthopedics'],
            ['name' => 'Pediatrics'],
            ['name' => 'Oncology'],
            ['name' => 'Dermatology'],
            ['name' => 'Gastroenterology'],
            ['name' => 'Psychiatry'],
            ['name' => 'Nephrology'],
            ['name' => 'Pulmonology'],
            ['name' => 'Ophthalmology'],
            ['name' => 'Allergy & Immunology'],
            ['name' => 'Emergency Medicine'],
        ];

        DB::table('specializations')->insert($specializations);


        $clinics = [
            ['name' => 'Cardiology Clinic', 'description' => 'Specializes in heart-related issues.'],
            ['name' => 'Neurology Clinic', 'description' => 'Deals with disorders of the nervous system.'],
            ['name' => 'Orthopedics Clinic', 'description' => 'Focuses on musculoskeletal system problems.'],
            ['name' => 'Pediatrics Clinic', 'description' => 'Specializes in medical care for children.'],
            ['name' => 'Oncology Clinic', 'description' => 'Concerned with cancer diagnosis and treatment.'],
            ['name' => 'Dermatology Clinic', 'description' => 'Deals with skin diseases and disorders.'],
            ['name' => 'Gastroenterology Clinic', 'description' => 'Focuses on digestive system disorders.'],
            ['name' => 'Psychiatry Clinic', 'description' => 'Deals with mental health disorders and treatment.'],
            ['name' => 'Nephrology Clinic', 'description' => 'Deals with kidney diseases and disorders.'],
            ['name' => 'Pulmonology Clinic', 'description' => 'Specializes in respiratory system diseases.'],
            ['name' => 'Ophthalmology Clinic', 'description' => 'Focuses on eye diseases and vision care.'],
            ['name' => 'Allergy & Immunology Clinic', 'description' => 'Deals with allergies and immune system disorders.'],
            ['name' => 'Emergency Medicine Clinic', 'description' => 'Specializes in urgent medical care and emergencies.'],
        ];

        DB::table('clinics')->insert($clinics);


        $clinicSpecializationMap = [
            ['clinic_id' => 1, 'specialization_id' => 1],
            ['clinic_id' => 2, 'specialization_id' => 2],
            ['clinic_id' => 3, 'specialization_id' => 3],
            ['clinic_id' => 4, 'specialization_id' => 4],
            ['clinic_id' => 5, 'specialization_id' => 5],
            ['clinic_id' => 6, 'specialization_id' => 6],
            ['clinic_id' => 7, 'specialization_id' => 7],
            ['clinic_id' => 8, 'specialization_id' => 8],
            ['clinic_id' => 9, 'specialization_id' => 9],
            ['clinic_id' => 10, 'specialization_id' => 10],
            ['clinic_id' => 11, 'specialization_id' => 11],
            ['clinic_id' => 12, 'specialization_id' => 12],
            ['clinic_id' => 13, 'specialization_id' => 13],
        ];

        $faker = Faker::create();

        foreach ($clinicSpecializationMap as $map) {
            for ($i = 0; $i < 2; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password'),
                ]);

                $user->assignRole('doctor');

                DB::table('doctors')->insert([
                    'user_id' => $user->id,
                    'clinic_id' => $map['clinic_id'],
                    'specialization_id' => $map['specialization_id'],
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'price' => $faker->randomFloat(2, 100, 500),
                    'status' => 'active',
                ]);
            }
        }
    }

}

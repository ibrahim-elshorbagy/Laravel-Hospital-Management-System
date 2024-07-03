<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'Cardiology'],
            ['name' => 'Neurology'],
            ['name' => 'Orthopedics'],
            ['name' => 'Pediatrics'],
            ['name' => 'Oncology'],
            ['name' => 'Dermatology'],
            ['name' => 'Gastroenterology'],
            ['name' => 'Endocrinology'],
            ['name' => 'Urology'],
            ['name' => 'Psychiatry'],
            ['name' => 'Rheumatology'],
            ['name' => 'Nephrology'],
            ['name' => 'Pulmonology'],
            ['name' => 'Ophthalmology'],
            ['name' => 'Radiology'],
            ['name' => 'Hematology'],
            ['name' => 'Allergy & Immunology'],
            ['name' => 'Infectious Disease'],
            ['name' => 'Emergency Medicine'],
            ['name' => 'Family Medicine'],
            ['name' => 'Geriatrics'],
            ['name' => 'Anesthesiology'],
            ['name' => 'Pathology'],
            ['name' => 'Physical Medicine & Rehabilitation'],
            ['name' => 'Otolaryngology'],
        ];

        DB::table('specializations')->insert($specializations);

    }
}

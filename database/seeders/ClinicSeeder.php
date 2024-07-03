<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            ['name' => 'Cardiology Clinic', 'description' => 'Specializes in heart-related issues.'],
            ['name' => 'Neurology Clinic', 'description' => 'Deals with disorders of the nervous system.'],
            ['name' => 'Orthopedics Clinic', 'description' => 'Focuses on musculoskeletal system problems.'],
            ['name' => 'Pediatrics Clinic', 'description' => 'Specializes in medical care for children.'],
            ['name' => 'Oncology Clinic', 'description' => 'Concerned with cancer diagnosis and treatment.'],
            ['name' => 'Dermatology Clinic', 'description' => 'Deals with skin diseases and disorders.'],
            ['name' => 'Gastroenterology Clinic', 'description' => 'Focuses on digestive system disorders.'],
            ['name' => 'Endocrinology Clinic', 'description' => 'Deals with hormone-related disorders.'],
            ['name' => 'Urology Clinic', 'description' => 'Specializes in urinary tract and male reproductive system issues.'],
            ['name' => 'Psychiatry Clinic', 'description' => 'Deals with mental health disorders and treatment.'],
            ['name' => 'Rheumatology Clinic', 'description' => 'Focuses on autoimmune and musculoskeletal disorders.'],
            ['name' => 'Nephrology Clinic', 'description' => 'Deals with kidney diseases and disorders.'],
            ['name' => 'Pulmonology Clinic', 'description' => 'Specializes in respiratory system diseases.'],
            ['name' => 'Ophthalmology Clinic', 'description' => 'Focuses on eye diseases and vision care.'],
            ['name' => 'Radiology Clinic', 'description' => 'Deals with medical imaging and radiation therapy.'],
            ['name' => 'Hematology Clinic', 'description' => 'Specializes in blood disorders and diseases.'],
            ['name' => 'Allergy & Immunology Clinic', 'description' => 'Deals with allergies and immune system disorders.'],
            ['name' => 'Infectious Disease Clinic', 'description' => 'Focuses on infections caused by viruses, bacteria, fungi, etc.'],
            ['name' => 'Emergency Medicine Clinic', 'description' => 'Specializes in urgent medical care and emergencies.'],
            ['name' => 'Family Medicine Clinic', 'description' => 'Provides comprehensive medical care for individuals and families.'],
            ['name' => 'Geriatrics Clinic', 'description' => 'Deals with health care for elderly patients.'],
            ['name' => 'Anesthesiology Clinic', 'description' => 'Focuses on pain management and anesthesia during surgeries.'],
            ['name' => 'Pathology Clinic', 'description' => 'Deals with the study of disease and its causes.'],
            ['name' => 'Physical Medicine & Rehabilitation Clinic', 'description' => 'Specializes in improving function and quality of life for patients with physical disabilities.'],
            ['name' => 'Otolaryngology Clinic', 'description' => 'Focuses on ear, nose, and throat disorders.'],
        ];

        DB::table('clinics')->insert($clinics);
    }

}


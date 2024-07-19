<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Heart Checkup', 'description' => 'Comprehensive heart health checkup.', 'price' => 100, 'status' => 'active'],
            ['name' => 'Brain MRI', 'description' => 'Magnetic resonance imaging of the brain.', 'price' => 300, 'status' => 'active'],
            ['name' => 'Bone Density Test', 'description' => 'Test to measure bone density.', 'price' => 150, 'status' => 'active'],
            ['name' => 'Child Health Consultation', 'description' => 'Health consultation for children.', 'price' => 80, 'status' => 'active'],
            ['name' => 'Cancer Screening', 'description' => 'Screening for various types of cancer.', 'price' => 200, 'status' => 'active'],
            ['name' => 'Skin Allergy Test', 'description' => 'Testing for skin allergies.', 'price' => 120, 'status' => 'active'],
            ['name' => 'Digestive Health Checkup', 'description' => 'Comprehensive digestive system checkup.', 'price' => 130, 'status' => 'active'],
            ['name' => 'Hormone Level Test', 'description' => 'Testing for hormone levels.', 'price' => 110, 'status' => 'active'],
            ['name' => 'Urinary Tract Infection Test', 'description' => 'Test for urinary tract infections.', 'price' => 90, 'status' => 'active'],
            ['name' => 'Mental Health Counseling', 'description' => 'Counseling for mental health issues.', 'price' => 100, 'status' => 'active'],
            ['name' => 'Arthritis Consultation', 'description' => 'Consultation for arthritis and related issues.', 'price' => 120, 'status' => 'active'],
            ['name' => 'Kidney Function Test', 'description' => 'Testing for kidney function.', 'price' => 140, 'status' => 'active'],
            ['name' => 'Lung Function Test', 'description' => 'Testing for lung function.', 'price' => 160, 'status' => 'active'],
            ['name' => 'Vision Test', 'description' => 'Comprehensive eye and vision test.', 'price' => 70, 'status' => 'active'],
            ['name' => 'X-ray Imaging', 'description' => 'X-ray imaging for various conditions.', 'price' => 50, 'status' => 'active'],
            ['name' => 'Blood Test', 'description' => 'Comprehensive blood testing.', 'price' => 100, 'status' => 'active'],
            ['name' => 'Allergy Shots', 'description' => 'Allergy shots for immunotherapy.', 'price' => 80, 'status' => 'inactive'],
            ['name' => 'Infection Control Consultation', 'description' => 'Consultation for infection control.', 'price' => 90, 'status' => 'active'],
            ['name' => 'Emergency First Aid', 'description' => 'First aid for emergency situations.', 'price' => 120, 'status' => 'active'],
            ['name' => 'Family Health Checkup', 'description' => 'Health checkup for the whole family.', 'price' => 180, 'status' => 'active'],
            ['name' => 'Elderly Care Consultation', 'description' => 'Consultation for elderly care.', 'price' => 150, 'status' => 'inactive'],
            ['name' => 'Anesthesia Consultation', 'description' => 'Consultation for anesthesia during surgeries.', 'price' => 200, 'status' => 'active'],
            ['name' => 'Disease Diagnosis', 'description' => 'Diagnosis of various diseases.', 'price' => 100, 'status' => 'active'],
            ['name' => 'Physical Therapy', 'description' => 'Physical therapy for rehabilitation.', 'price' => 110, 'status' => 'active'],
            ['name' => 'Ear, Nose, and Throat Checkup', 'description' => 'Checkup for ear, nose, and throat.', 'price' => 100, 'status' => 'active'],
            // Dental services
            ['name' => 'Teeth Cleaning', 'description' => 'Professional teeth cleaning service.', 'price' => 60, 'status' => 'active'],
            ['name' => 'Dental Checkup', 'description' => 'Regular dental examination.', 'price' => 50, 'status' => 'active'],
            ['name' => 'Tooth Extraction', 'description' => 'Removal of a tooth.', 'price' => 80, 'status' => 'active'],
            ['name' => 'Root Canal Treatment', 'description' => 'Treatment for infected tooth pulp.', 'price' => 200, 'status' => 'active'],
            ['name' => 'Teeth Whitening', 'description' => 'Professional teeth whitening service.', 'price' => 150, 'status' => 'active'],
            ['name' => 'Dental Filling', 'description' => 'Repairing cavities with dental fillings.', 'price' => 100, 'status' => 'active'],
            ['name' => 'Braces Consultation', 'description' => 'Consultation for braces and orthodontics.', 'price' => 120, 'status' => 'inactive'],
        ];

        DB::table('services')->insert($services);
    }
}

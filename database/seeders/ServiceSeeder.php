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
     public function run()
    {
        // Services
        $services = [
            ['id' => 1, 'name' => 'Bone X-ray', 'description' => 'Standard X-ray imaging of bones.', 'price' => 75, 'status' => 'active'],
            ['id' => 2, 'name' => 'Joint MRI', 'description' => 'Magnetic resonance imaging of joints.', 'price' => 250, 'status' => 'active'],
            ['id' => 3, 'name' => 'Spine CT Scan', 'description' => 'Computed tomography scan of the spine.', 'price' => 300, 'status' => 'active'],
            ['id' => 4, 'name' => 'Fracture Assessment', 'description' => 'Assessment and imaging of bone fractures.', 'price' => 120, 'status' => 'active'],
            ['id' => 5, 'name' => 'Bone Scintigraphy', 'description' => 'Nuclear imaging technique to evaluate bone diseases.', 'price' => 350, 'status' => 'active'],

            ['id' => 6, 'name' => 'Brain MRI', 'description' => 'Magnetic resonance imaging of the brain.', 'price' => 300, 'status' => 'active'],
            ['id' => 7, 'name' => 'X-ray Imaging', 'description' => 'X-ray imaging for various conditions.', 'price' => 50, 'status' => 'active'],
            ['id' => 8, 'name' => 'Blood Test', 'description' => 'Comprehensive blood testing.', 'price' => 100, 'status' => 'active'],
            ['id' => 9, 'name' => 'Urinary Tract Infection Test', 'description' => 'Test for urinary tract infections.', 'price' => 90, 'status' => 'active'],
            ['id' => 10, 'name' => 'Kidney Function Test', 'description' => 'Testing for kidney function.', 'price' => 140, 'status' => 'active'],
            ['id' => 11, 'name' => 'Lung Function Test', 'description' => 'Testing for lung function.', 'price' => 160, 'status' => 'active'],
            ['id' => 12, 'name' => 'Vision Test', 'description' => 'Comprehensive eye and vision test.', 'price' => 70, 'status' => 'active'],
            ['id' => 13, 'name' => 'Hormone Level Test', 'description' => 'Testing for hormone levels.', 'price' => 110, 'status' => 'active'],
            ['id' => 14, 'name' => 'Digestive Health Checkup', 'description' => 'Comprehensive digestive system checkup.', 'price' => 130, 'status' => 'active'],
            ['id' => 15, 'name' => 'Cancer Screening', 'description' => 'Screening for various types of cancer.', 'price' => 200, 'status' => 'active'],
            ['id' => 16, 'name' => 'Heart Checkup', 'description' => 'Comprehensive heart health checkup.', 'price' => 100, 'status' => 'active'],

            // Dental services
            ['id' => 17, 'name' => 'Teeth Cleaning', 'description' => 'Professional teeth cleaning service.', 'price' => 60, 'status' => 'active'],
            ['id' => 18, 'name' => 'Dental Checkup', 'description' => 'Regular dental examination.', 'price' => 50, 'status' => 'active'],
            ['id' => 19, 'name' => 'Tooth Extraction', 'description' => 'Removal of a tooth.', 'price' => 80, 'status' => 'active'],
            ['id' => 20, 'name' => 'Root Canal Treatment', 'description' => 'Treatment for infected tooth pulp.', 'price' => 200, 'status' => 'active'],
            ['id' => 21, 'name' => 'Teeth Whitening', 'description' => 'Professional teeth whitening service.', 'price' => 150, 'status' => 'active'],
            ['id' => 22, 'name' => 'Dental Filling', 'description' => 'Repairing cavities with dental fillings.', 'price' => 100, 'status' => 'active'],
            ['id' => 23, 'name' => 'Braces Consultation', 'description' => 'Consultation for braces and orthodontics.', 'price' => 120, 'status' => 'inactive'],
        ];

        DB::table('services')->insert($services);

        // Packages
        $packages = [
            [
                'id' => 1,
                'name' => 'Complete Health Package',
                'description' => 'Includes all essential health checkups.',
                'Total_before_discount' => 1000,
                'discount_value' => 100,
                'Total_after_discount' => 900,
                'tax_rate' => '5',
                'Total_with_tax' => 945,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Basic Health Package',
                'description' => 'Includes basic health checkups.',
                'Total_before_discount' => 500,
                'discount_value' => 50,
                'Total_after_discount' => 450,
                'tax_rate' => '5',
                'Total_with_tax' => 472.50,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'name' => 'Family Health Package',
                'description' => 'Comprehensive health checkups for families.',
                'Total_before_discount' => 1200,
                'discount_value' => 150,
                'Total_after_discount' => 1050,
                'tax_rate' => '5',
                'Total_with_tax' => 1102.50,
                'status' => 'active'
            ],
            [
                'id' => 4,
                'name' => 'Elderly Care Package',
                'description' => 'Health package tailored for elderly care.',
                'Total_before_discount' => 800,
                'discount_value' => 80,
                'Total_after_discount' => 720,
                'tax_rate' => '5',
                'Total_with_tax' => 756,
                'status' => 'active'
            ],
            [
                'id' => 5,
                'name' => 'Dental Health Package',
                'description' => 'Comprehensive dental health package.',
                'Total_before_discount' => 700,
                'discount_value' => 70,
                'Total_after_discount' => 630,
                'tax_rate' => '5',
                'Total_with_tax' => 661.50,
                'status' => 'active'
            ],
            [
                'id' => 6,
                'name' => 'Cancer Screening Package',
                'description' => 'Detailed screening for various types of cancer.',
                'Total_before_discount' => 900,
                'discount_value' => 90,
                'Total_after_discount' => 810,
                'tax_rate' => '5',
                'Total_with_tax' => 850.50,
                'status' => 'active'
            ],
        ];

        DB::table('packages')->insert($packages);

        // Package Service
        $packageServices = [
            // Complete Health Package
            ['package_id' => 1, 'service_id' => 1],
            ['package_id' => 1, 'service_id' => 6],
            ['package_id' => 1, 'service_id' => 8],
            ['package_id' => 1, 'service_id' => 10],
            ['package_id' => 1, 'service_id' => 12],

            // Basic Health Package
            ['package_id' => 2, 'service_id' => 7],
            ['package_id' => 2, 'service_id' => 14],
            ['package_id' => 2, 'service_id' => 16],
            ['package_id' => 2, 'service_id' => 8],

            // Family Health Package
            ['package_id' => 3, 'service_id' => 9],
            ['package_id' => 3, 'service_id' => 11],
            ['package_id' => 3, 'service_id' => 13],
            ['package_id' => 3, 'service_id' => 15],
            ['package_id' => 3, 'service_id' => 8],

            // Elderly Care Package
            ['package_id' => 4, 'service_id' => 2],
            ['package_id' => 4, 'service_id' => 4],
            ['package_id' => 4, 'service_id' => 8],
            ['package_id' => 4, 'service_id' => 5],

            // Dental Health Package
            ['package_id' => 5, 'service_id' => 17],
            ['package_id' => 5, 'service_id' => 18],
            ['package_id' => 5, 'service_id' => 19],
            ['package_id' => 5, 'service_id' => 20],
            ['package_id' => 5, 'service_id' => 21],
            ['package_id' => 5, 'service_id' => 22],

        ];

        DB::table('package_service')->insert($packageServices);
    }
}

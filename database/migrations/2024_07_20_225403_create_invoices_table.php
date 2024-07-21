<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->references('id')->on('patients')->onDelete('cascade');
            $table->text('patient_name')->nullable();
            $table->foreignId('clinic_id')->nullable()->references('id')->on('clinics')->onDelete('cascade');
            $table->text('doctor')->nullable();
            $table->text('services')->nullable();
            $table->text('packages')->nullable();
            $table->decimal('total_before_discount',8,2);
            $table->decimal('discount_value',8,2);
            $table->decimal('total_after_discount',8,2);
            $table->string('tax_rate');
            $table->decimal('total_with_tax',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Hospital\ClinicController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Hospital\PackageController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Hospital\ServiceController;
use App\Http\Controllers\Invoice\InvoiceCreateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// })->name('/');

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::resource('clinic',ClinicController::class);
    Route::resource('doctor',DoctorController::class);
    Route::resource('service',ServiceController::class);
    Route::resource('package',PackageController::class);
    Route::resource('patient',PatientController::class);

    Route::resource('invoice',InvoiceController::class);

    Route::get('/invoice-get/clinics', [InvoiceController::class, 'getAllClinics']);
    Route::get('/clinics/{clinic}/doctors', [InvoiceController::class, 'getDoctorsByClinic']);

    Route::get('/invoice-get/services', [InvoiceController::class, 'getAllServices']);
    Route::get('/invoice-get/packages', [InvoiceController::class, 'getAllPackages']);
    Route::get('/invoice-get/patients', [InvoiceController::class, 'getPatient']);

    Route::get('/invoices/{id}/show', [InvoiceController::class, 'ShowInvoice'])->name('invoices.show');

    Route::post('/invoice-create', [InvoiceCreateController::class, 'store'])->name('invoice-create.store');



});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

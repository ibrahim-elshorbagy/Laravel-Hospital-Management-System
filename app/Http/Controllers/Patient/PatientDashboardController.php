<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyInvoiceREsource;
use App\Models\Invoice\Invoice;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{

    public function MyInvoice(){

        $query = Invoice::query()
            ->select('invoices.id','invoices.invoice_type','invoices.created_at')->with([
                // 'details' => function ($q) {$q->select('invoice_id', 'total_with_tax');},
                // 'doctors'=> function ($q) {$q->select('doctors.id');},//to just get the id
                // 'doctors.user'=> function ($q) {$q->select('users.id','name');}, // to get his name   //mybe we will need users.id
                // 'doctors.clinic'=> function ($q) {$q->select('clinics.id','name');}, //to get his clinic name                //clinics.id
                // 'doctors.invoices'=> function ($q) {$q->select('daily_patient_index');},
                // 'services'=> function ($q) {$q->select('services.id', 'name', 'price');}
                'details:invoice_id,total_with_tax',
                'doctors:id,user_id,price,clinic_id',
                'doctors.user:id,name',
                'doctors.clinic:id,name',
                'doctors.invoices:invoices.id',
                'services:id,name,price'

            ]);
        $invoices = $query->paginate(10)->onEachSide(1);
        return inertia('Patient/MyInvoices/Index', [
            'invoices' => MyInvoiceResource::collection($invoices),
        ]);



    }
}

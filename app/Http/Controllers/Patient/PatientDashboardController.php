<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyInvoiceREsource;
use App\Models\Invoice\Invoice;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{

    public function MyInvoice(){
         $userid = Auth::id();
        $patient = Patient::where('user_id',$userid)->first();
        $query = Invoice::query()->Where('patient_id',$patient->id)
            ->select('invoices.id','invoices.invoice_type','invoices.created_at')->with([
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

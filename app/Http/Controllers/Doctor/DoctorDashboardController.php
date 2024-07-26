<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyPatientResource;
use App\Models\Doctor\Doctor;
use App\Models\Invoice\DoctorInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function  MyPatient(){
        $userid = Auth::id();
        $today = Carbon::today();
        $doctor = Doctor::where('user_id', $userid)->select('id')->first();
        $invoices = $doctor->invoices()->select('invoices.id', 'invoices.name')->whereDate('invoices.created_at', $today)->paginate(10)->onEachSide(1);
        return inertia('Doctor/Dashboard/MyPatient', [
            'patients' => MyPatientResource::collection($invoices),
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'id' => 'required',
            "pivot_id" => ['required', 'exists:doctor_invoices,id'],
        ]);

        $invoice = DoctorInvoice::find($data['pivot_id']);
        $invoice->update(['status' => $data['status']]);
        return to_route('doc.my-patient');

    }
}

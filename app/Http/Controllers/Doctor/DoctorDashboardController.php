<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyPatientResource;
use App\Models\Doctor\Diagnostic;
use App\Models\Doctor\Doctor;
use App\Models\Invoice\DoctorInvoice;
use App\Models\Patient\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function  MyPatient(){
        $userid = Auth::id();
        $today = Carbon::today();
        $doctor = Doctor::where('user_id', $userid)->select('id')->first();
        $invoices = $doctor->invoices()->select('invoices.id', 'invoices.name','patient_id')->whereDate('invoices.created_at', $today)->paginate(10)->onEachSide(1);
        return inertia('Doctor/Dashboard/MyPatient', [
            'patients' => MyPatientResource::collection($invoices),
            'success'=>session('success')
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

    public function ShowPatient ($id,$invoice_id)
    {
    $patient = Patient::where('id', $id)->select('id', 'user_id')->with(['user:id,name'])->first();
    $diagnostics=$patient->diagnostics()->select('id','doctor_id','diagnosis','medicine','created_at')->with('doctor:id,user_id,clinic_id','doctor.user:id,name','doctor.clinic:id,name')->orderBy('created_at', 'desc')->get();
        return inertia('Doctor/Dashboard/ShowPatient', [
            'patient' => $patient,
            'diagnostics' => $diagnostics,
            'invoice_id' => $invoice_id,
        ]);
    }

    public function StoreDiagnosis(Request $request)
    {
        $data = $request->validate([
            'diagnosis' => 'required|string',
            'medicine' => 'required|string',
            'invoice_id' => 'required|integer',
            'patient_id' => 'required|integer',
        ]);
        $userid = Auth::id();
        $doctorID = Doctor::where('user_id', $userid)->select('id')->first();
        $data['doctor_id'] = $doctorID->id;
        Diagnostic::create($data);
        return to_route('doc.my-patient')->with('success','Diagnosis Added successfully');;
    }
}

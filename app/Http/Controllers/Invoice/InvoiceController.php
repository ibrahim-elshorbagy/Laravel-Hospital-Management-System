<?php

namespace App\Http\Controllers\Invoice;
use App\Http\Controllers\Controller;


use App\Models\Invoice\Invoice;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\IndexInvoiceResource;
use App\Http\Resources\PatientResource;
use App\Models\Clinic\Clinic;
use App\Models\Doctor\Doctor;
use App\Models\Clinic\Package;
use App\Models\Patient\Patient;
use App\Models\Clinic\Service;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Invoice::query();
        $sortFileds = request('sort_field','id') ;
        $sortDirection = request('sort_direction','asc');

        if(request('name')){
            $query->where('name', 'like', '%' . request('name') . '%');
        }


        $invoices = $query->orderBy($sortFileds,$sortDirection)->with(['patient'=>function($q){$q->select('id','user_id');},'details'=>function($q){$q->select('id','invoice_id','total_with_tax');}])->paginate(10)->onEachSide(1);
        return inertia('Invoice/Index', [
            'invoices' => IndexInvoiceResource::collection($invoices),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success'),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $patients = Patient::query()
            ->select(['id','user_id'])
            ->with(['user' => function($q) {$q->select('id','name');}])
            ->get();
        return inertia('Invoice/Create', [
            'patients' => $patients,
        ]);

    }

    public function getPatient(){
        $patients = Patient::query()
            ->select(['id','user_id'])
            ->with(['user' => function($q) {
                $q->select('id', 'name');
            }])
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->paginate(10);
        return response(PatientResource::collection($patients));


    }
    public function getAllClinics()
    {
        $clinics = Clinic::select('id', 'name')->get();
        return response()->json($clinics);
    }

    public function getDoctorsByClinic($clinicId)
    {
        $doctors = Doctor::where('clinic_id', $clinicId)
        ->select('id', 'user_id', 'price')
        ->with(['user:id,name'])
        ->get();
        return response()->json($doctors);
    }

    public function getAllServices()
    {
        $services = Service::select('id', 'name', 'price')->get();
        return response()->json($services);
    }

    public function getAllPackages()
    {
        $packages = Package::select('id', 'name','Total_with_tax')->with(['services'])->get();
        return response()->json($packages);
    }



        public function ShowInvoice($id)
    {

    $invoice = Invoice::find($id);
    $invoice->load([
        'details' => function ($q) {
            $q->select('invoice_id', 'total_before_discount', 'discount_value', 'total_after_discount', 'tax_rate', 'total_with_tax');
        },
        'doctors' => function ($q) {
            $q->select('doctors.id', 'user_id', 'price');
        },
        'doctors.user' => function ($q) {
            $q->select('users.id', 'users.name');
        },
        'services' => function ($q) {
            $q->select('services.id', 'services.name', 'services.price');
        }
    ]);


            // dd($invoice->toJson());

        return inertia('Invoice/PrintInvoice', [
            'invoice' => $invoice,
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return to_route('invoice.index')->with('success','Invoice deleted successfully');

    }
}

<?php

namespace App\Http\Controllers\Invoice;
use App\Http\Controllers\Controller;


use App\Models\Invoice\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ServiceResource;
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

        if(request('patient_name')){
            $query->where('patient_name', 'like', '%' . request('patient_name') . '%');
        }


        $invoices = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);
        return inertia('Accounting/Invoice/Index', [
            'invoices' => InvoiceResource::collection($invoices),
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
        return inertia('Accounting/Invoice/Create', [
            'patients' => $patients,
        ]);

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
        $packages = Package::select('id', 'name','Total_with_tax')->get();
        return response()->json($packages);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        // Get validated data
        $validated = $request->validated();
        // Process services and packages data
        $services = $validated['selectedServices'] ?? [];
        $packages = $validated['selectedPackages'] ?? [];
        $doctors = $validated['selectedDoctors'] ?? [];

        // Convert services and packages to JSON
        $servicesJson = json_encode($services);
        $packagesJson = json_encode($packages);
        $doctorsJson = json_encode($doctors);

        // Create new invoice
        $invoice = new Invoice();
        $invoice->patient_id = $validated['patient']['id'] ?? null;
        $invoice->patient_name = $validated['patient']['name'] ?? null;
        $invoice->clinic_id = $validated['clinic'] ?? null;
        $invoice->doctor = $validated['selectedDoctors'][0]['id'] ?? null;
        $invoice->services = $servicesJson;
        $invoice->packages = $packagesJson;
        $invoice->doctor = $doctorsJson;

        $invoice->total_before_discount = $validated['total_before_discount'];
        $invoice->discount_value = $validated['discount_value'];
        $invoice->total_after_discount = $validated['total_after_discount'];
        $invoice->tax_rate = $validated['tax_rate'];
        $invoice->total_with_tax = $validated['total_with_tax'];

        $invoice->save();

        return $this->printInvoice($invoice);

    }

    public function printInvoice($invoice)
    {

        return inertia('Accounting/Invoice/PrintInvoice', [
            'invoice' => $invoice,
            'clinic_name' => $invoice->clinic->name ?? 'N/A'
            ]
        );
    }
        public function ShowInvoice($id)
    {
        $invoice = Invoice::find($id)->with(['clinic'=>function($q){$q->select('id','name');}])->first();
        return inertia('Accounting/Invoice/PrintInvoice', [
            'invoice' => $invoice,
            'clinic_name' => $invoice->clinic->name ?? 'N/A'
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
        //
    }
}

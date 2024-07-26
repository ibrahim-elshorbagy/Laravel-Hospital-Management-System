<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Clinic\Package;
use App\Models\Invoice\DoctorInvoice;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Invoice\ServiceInvoice;
use App\Models\Patient\Patient;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class InvoiceCreateController extends Controller
{
        /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {

        //Zero have account ?

        if($data['account_type'] && isset($data['patient']['email'])){ //new acccount
            $userData = [
                'name' => $data['patient']['name'],
                'email' => $data['patient']['email'],
                'password' => bcrypt('password'),
            ];
            $user = User::create($userData);

            $patientData = [
                'user_id' => $user->id,
            ];
            $patient = Patient::create($patientData);
            $user->assignRole('patient');
            $email = $data['patient']['email'];
            $password = " 'password' - Plase Change it";
        }
        elseif($data['account_type']){ //just name
            //No thting
        }
        else{
            $patient = Patient::find($data['patient']['id']);
            $email = $patient->user->email;
            $password= null;
        }
        $patientId = null;
        if (isset($data['patient']['id']) && $data['patient']['id']) {
            $patientId = $data['patient']['id'];
        } elseif (isset($patient) && $patient->id) {
            $patientId = $patient->id;
        }

        //First Table Make Ivoice
        $invoiceData = [
            'patient_id' => $patientId,
            'name' => $data['patient']['name'],
            'invoice_type'=>$data['invoice_type'],
        ];
        $invoice = Invoice::create($invoiceData);

        //Second Table Make Invoice Details
        $invoiceDetailsData = [
            'invoice_id' => $invoice->id,
            'total_before_discount' => $data['total_before_discount'],
            'discount_value' => $data['discount_value'],
            'total_after_discount' => $data['total_after_discount'],
            'tax_rate' => $data['tax_rate'],
            'total_with_tax' => $data['total_with_tax'],
        ];

        $invoiceDetails = InvoiceDetail::create($invoiceDetailsData);

        //Third Invoice Type
        switch ($data['invoice_type']) {

            case 'clinic':
                $data =[
                    'invoice_id' => $invoice->id,
                    'doctor_id' => $data['selectedDoctors'][0]['id'],
                    'clinic_id'=>$data['clinic']
                ];
                $this->doctorInvoice($data);
                break;

            case 'service':
                $data =[
                    'invoice_id' => $invoice->id,
                    'services' => $data['selectedServices'],
                ];
                $this->serviceInvoice($data);
                break;

            case 'package':
                $data =[
                    'invoice_id' => $invoice->id,
                    'packages' => $data['selectedPackages'],
                ];
                $this->packageInvoice($data);

                break;
        }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }



        return $this->printInvoice($email ,$password ,$invoice,$request['invoice_type']);

    }

    //Storing Doctor Invoice
    public function doctorInvoice($data)
    {

        $doctorId = $data['doctor_id'];
        $clinicId = $data['clinic_id'];
        $invoiceId = $data['invoice_id'];
        $today = Carbon::today();

        $count = DoctorInvoice::where('doctor_id', $doctorId)
                    ->whereDate('created_at', $today)
                    ->count();

        DoctorInvoice::create([
            'doctor_id' => $doctorId,
            'invoice_id' => $invoiceId,
            'clinic_id' => $clinicId,
            'daily_patient_index' => $count + 1,
        ]);

    }

    //Storing Service Invoice
    public function serviceInvoice($data)
    {
        $selectedServices = $data['services'];
        $invoiceId = $data['invoice_id'];
        $today = Carbon::today();

        foreach ($selectedServices as $serviceData) {
            $serviceId = $serviceData['id'];

            $count = ServiceInvoice::where('service_id', $serviceId)
                    ->whereDate('created_at', $today)
                    ->count();

            ServiceInvoice::create([
                'service_id' => $serviceId,
                'invoice_id' => $invoiceId,
                'daily_patient_index' => $count + 1,
            ]);
        }

    }

    //Storing Package Invoice
    public function packageInvoice($data)
    {
        $invoiceId = $data['invoice_id'];
        $today = Carbon::today();

        $selectedPackages = $data['packages'];

        foreach ($selectedPackages as $packageData) {
            $packageId = $packageData['id'];
            $package = Package::with('services')->find($packageId);

            $services = $package->services->pluck('id')->toArray();

            foreach ($services as $serviceId) {
                $count = ServiceInvoice::where('service_id', $serviceId)
                        ->whereDate('created_at', $today)
                        ->count();

                ServiceInvoice::create([
                    'service_id' => $serviceId,
                    'invoice_id' => $invoiceId,
                    'daily_patient_index' => $count + 1,
                ]);
            }
        }
    }

    //Print the Inovice
    public function printInvoice($email=null,$password=null,$invoice,$invoice_type)
    {
    $invoice = Invoice::with(['details', 'doctors.user', 'services'])->findOrFail($invoice->id);


        return inertia('Invoice/PrintInvoice', [
        'invoice_type' => $invoice_type,
        'invoice' => $invoice,
        'email'=>$email,
        'password'=>$password,
        'site' => env('APP_URL'),
        ]
        );
    }
}

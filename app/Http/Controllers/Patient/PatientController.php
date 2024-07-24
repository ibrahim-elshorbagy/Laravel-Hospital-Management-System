<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
    $query = Patient::query()
        ->select('id','address','phone', 'updated_at','user_id')->with(['user' => function($q) {$q->select('id', 'name', 'email');}]);

        $sortFileds = request('sort_field','id');
        $sortDirection = request('sort_direction','desc');

        if (request("name")) {
        $query->whereHas('user', function ($q) {
            $q->where("name", "like", "%" . request("name") . "%");
        });
        }
        if (request("email")) {
            $query->whereHas('user', function ($q) {
                $q->where("email", "like", "%" . request("email") . "%");
            });
        }

        $patients = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);

        return inertia('Patient/Index', [
            'patients' => PatientResource::collection($patients),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success')
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return inertia('Patient/Create', [
            ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $data = $request->validated();
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
        $user = User::create($userData);

        $patientData = [
            'user_id' => $user->id,
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];
        $patient = Patient::create($patientData);
        $user->assignRole('patient');


            return to_route('patient.index')
        ->with('success',"Patient created successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
            $patient = $patient->load(['user']);
            return inertia('Patient/Edit', [
                'patient' => new PatientResource($patient),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
            $data = $request->validated();
            $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $user = $patient->user;
        $user->update($userData);

        $patientData = [
            'user_id' => $user->id,
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];
        $patient->update($patientData);


            return to_route('patient.index')
        ->with('success',"Patient Updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return to_route('patient.index')->with('success','Patient deleted successfully');

    }
}

<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor\Doctor;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\SpecializationResource;
use App\Models\Clinic\Clinic;
use App\Models\Doctor\Specialization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $query = Doctor::query()
        ->select('id', 'updated_at','user_id','specialization_id','status')
        ->with(['user' => function($q) {$q->select('id', 'name', 'email');}, 'specialization']);

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

        $doctors = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);

        return inertia('Doctor/Index', [
            'doctors' => DoctorResource::collection($doctors),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success')
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::get(['id', 'name']);;
        $clinics = Clinic::get(['id', 'name']);;
            return inertia('Doctor/Create', [
                'specializations' => SpecializationResource::collection($specializations),
                'clinics' => ClinicResource::collection($clinics),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
        $user = User::create($userData);

        $doctorData = [
            'user_id' => $user->id,
            'specialization_id' => $data['specialization_id'],
            'clinic_id' => $data['clinic_id'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'price' => $data['price'],
            'status' => $data['status'],
        ];
        $doctor = Doctor::create($doctorData);
        $user->assignRole('doctor');

        if (isset($data['days'])) {
        foreach ($data['days'] as $day) {
            $doctor->appointments()->create(['day' => $day]);
        }
    }
            return to_route('doctor.index')
        ->with('success',"Doctor created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctor = $doctor->load(['user','specialization','clinic','appointments']);

        $specializations = Specialization::get(['id', 'name']);;
        $clinics = Clinic::get(['id', 'name']);;
            return inertia('Doctor/Edit', [
                'specializations' => SpecializationResource::collection($specializations),
                'clinics' => ClinicResource::collection($clinics),
                'doctor' => new DoctorResource($doctor),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();
                $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $user = $doctor->user;
        $user->update($userData);

        $doctorData = [
            'user_id' => $user->id,
            'specialization_id' => $data['specialization_id'],
            'clinic_id' => $data['clinic_id'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'price' => $data['price'],
            'status' => $data['status'],
        ];
        $doctor->update($doctorData);

        if (isset($data['days'])) {

        $doctor->appointments()->delete();

        foreach ($data['days'] as $day) {
            $doctor->appointments()->create(['day' => $day]);
        }
        }

            return to_route('doctor.index')
        ->with('success',"Doctor Updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return to_route('doctor.index')->with('success','Doctor deleted successfully');

    }
}

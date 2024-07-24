<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Http\Resources\ClinicResource;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Clinic::query();
        $sortFileds = request('sort_field','id') ;
        $sortDirection = request('sort_direction','asc');

        if(request('name')){
            $query->where('name', 'like', '%' . request('name') . '%');
        }


        $clinics = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);
        return inertia('Clinic/Index', [
            'clinics' => ClinicResource::collection($clinics),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success'),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Clinic/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClinicRequest $request)
    {
        $data = $request->validated();
        Clinic::create($data);
        return to_route('clinic.index')
        ->with('success',"Clinic created successfully");    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {

        return inertia('Clinic/Edit', [
            'clinic' => new ClinicResource($clinic),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $data = $request->validated();
        $clinic->update($data);
        return to_route('clinic.index')
        ->with('success',"Clinic updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic)
    {
        $clinic->delete();
        return to_route('clinic.index')->with('success','Clinic deleted successfully');

    }
}

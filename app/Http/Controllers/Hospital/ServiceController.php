<?php

namespace App\Http\Controllers\Hospital;
use App\Http\Controllers\Controller;

use App\Models\Clinic\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Service::query();
        $sortFileds = request('sort_field','id') ;
        $sortDirection = request('sort_direction','asc');

        if(request('name')){
            $query->where('name', 'like', '%' . request('name') . '%');
        }


        $services = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);
        return inertia('Service/Index', [
            'services' => ServiceResource::collection($services),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success'),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Service/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        Service::create($data);
        return to_route('service.index')
        ->with('success',"Service created successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return inertia('Service/Edit', [
            'service' => new ServiceResource($service),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        $service->update($data);
        return to_route('service.index')
        ->with('success',"Service updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return to_route('service.index')->with('success','Service deleted successfully');

    }
}

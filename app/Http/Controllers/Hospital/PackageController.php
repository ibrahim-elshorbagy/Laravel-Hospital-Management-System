<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;

use App\Models\Clinic\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ServiceResource;
use App\Models\Clinic\Service;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Package::query();
        $sortFileds = request('sort_field','id') ;
        $sortDirection = request('sort_direction','asc');

        if(request('name')){
            $query->where('name', 'like', '%' . request('name') . '%');
        }


        $packages = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);
        return inertia('Package/Index', [
            'apackages' => PackageResource::collection($packages),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success'),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::query()->get(['id', 'name','price']);
        return inertia('Package/Create', [
            'services' => ServiceResource::collection($services),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {

        $data = $request->validated();
        $services = $data['selectedServices'];
        unset($data['selectedServices']);

        $package = Package::create($data);
        $package->services()->attach($services);

        return to_route('package.index')
        ->with('success',"Package created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $services = Service::query()->get(['id', 'name', 'price']);
        $package->load('services');

        return inertia('Package/Edit', [
            'packageData' => new PackageResource($package),
            'services' => ServiceResource::collection($services),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StorePackageRequest $request, Package $package)
    {
        $data = $request->validated();

        $services = $data['selectedServices'];
        unset($data['selectedServices']);

        $package->update($data);

        $package->services()->sync($services);

        return to_route('package.index')
            ->with('success', "Package updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return to_route('package.index')->with('success','Package deleted successfully');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Resources\SectionResource;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Section::query();
        $sortFileds = request('sort_field','id') ;
        $sortDirection = request('sort_direction','asc');

        if(request('name')){
            $query->where('name', 'like', '%' . request('name') . '%');
        }


        $sections = $query->orderBy($sortFileds,$sortDirection)->paginate(10)->onEachSide(1);
        return inertia('Section/Index', [
            'sections' => SectionResource::collection($sections),
            'queryParams' => request()->query() ?: null,
            'success'=>session('success'),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Section/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();
        Section::create($data);
        return to_route('section.index')
        ->with('success',"Section created successfully");    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {

        return inertia('Section/Edit', [
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return to_route('section.index')->with('success','Section deleted successfully');

    }
}

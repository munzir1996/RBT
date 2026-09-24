<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\Sims\SimStoreRequest;
use App\Http\Requests\Sims\SimUpdateRequest;

class SimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sims = Sim::all();

        return Inertia::render('sims/Index', [
            'sims' => $sims
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('sims/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SimStoreRequest $simStoreRequest)
    {
        $validated = $simStoreRequest->validated();

        // Create a new sim using the validated data
        Sim::create($validated);

        // Redirect to the sims index page with a success message
        return redirect()->route('sims.index')->with('success', 'Sim created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sim $sim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sim $sim)
    {
        return Inertia::render('sims/Edit', [
            'sim' => $sim
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SimUpdateRequest $request, Sim $sim)
    {
        $validated = $request->validated();
        $sim->update($validated);
        return redirect()->route('sims.index')->with('success', 'Sim updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sim $sim)
    {
        $sim->delete();
        return redirect()->route('sims.index')->with('success', 'Sim deleted successfully.');
    }
}

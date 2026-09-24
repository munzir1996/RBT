<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\Artists\ArtistStoreRequest;
use App\Http\Requests\Artists\ArtistUpdateRequest;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::all();

        return Inertia::render('artists/Index', [
            'artists' => $artists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('artists/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArtistStoreRequest $artistStoreRequest)
    {
        $validated = $artistStoreRequest->validated();

        // Create a new artist using the validated data
        Artist::create($validated);

        // Redirect to the artists index page with a success message
        return redirect()->route('artists.index')->with('success', 'Artist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        return Inertia::render('artists/Edit', [
            'artist' => $artist
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArtistUpdateRequest $request, Artist $artist)
    {
        $validated = $request->validated();

        $artist->update($validated);

        return redirect()->route('artists.index')->with('success', 'Artist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();

        return redirect()->route('artists.index')->with('success', 'Artist deleted successfully.');
    }
}

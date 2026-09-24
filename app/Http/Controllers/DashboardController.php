<?php

namespace App\Http\Controllers;

use App\Http\Requests\Songs\SongStoreRequest;
use App\Http\Requests\Songs\SongUpdateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Sim;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::all();


        return Inertia::render('Dashboard', [
            'songs' => $songs,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $artists = Artist::all();
        $sims = Sim::all();

        return Inertia::render('Create', [
            'artists' => $artists,
            'sims' => $sims
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SongStoreRequest $songStoreRequest)
    {
        $validated = $songStoreRequest->validated();
        // Create a new song using the validated data
        Song::create($validated);

        // Redirect to the dashboard index page with a success message
        return redirect()->route('dashboard.index')->with('success', 'Song created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        return Inertia::render('Edit', [
            'song' => $song
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SongUpdateRequest $songUpdateRequest, Song $song)
    {
        $validated = $songUpdateRequest->validated();

        // Update the song using the validated data
        $song->update($validated);

        // Redirect to the dashboard index page with a success message
        return redirect()->route('dashboard.index')->with('success', 'Song updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        $song->delete();

        // Redirect to the dashboard index page with a success message
        return redirect()->route('dashboard.index')->with('success', 'Song deleted successfully.');
    }
}

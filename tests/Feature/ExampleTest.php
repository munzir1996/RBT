<?php

use App\Models\Artist;
use App\Models\Sim;
use App\Models\Song;
use Inertia\Testing\AssertableInertia as Assert;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('welcome page shows every song with artist and service details', function () {
    $artist = Artist::create(['name' => 'Artist One']);
    $sim = Sim::create(['name' => 'Zain']);

    Song::create([
        'title' => 'Available song',
        'song_no' => '1001',
        'link' => 'https://example.com/song.mp3',
        'subscription_detail' => 'Send 1001 to 1717',
        'fast_subscription' => '1001',
        'is_active' => true,
        'artist_id' => $artist->id,
        'sim_id' => $sim->id,
    ]);
    Song::create([
        'title' => 'Unavailable song',
        'song_no' => '1002',
        'link' => null,
        'subscription_detail' => 'Currently unavailable',
        'fast_subscription' => '1002',
        'is_active' => false,
        'artist_id' => $artist->id,
        'sim_id' => $sim->id,
    ]);

    $this->get(route('home'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('songs', 2)
            ->where('songs.0.title', 'Available song')
            ->where('songs.0.artist.name', 'Artist One')
            ->where('songs.0.sim.name', 'Zain')
            ->where('songs.0.link', 'https://example.com/song.mp3')
            ->where('songs.1.title', 'Unavailable song')
            ->where('songs.1.is_active', false),
        );
});

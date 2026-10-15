<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'song_no', 'link', 'subscription_detail', 'fast_subscription', 'artist_id', 'sim_id', 'is_active',
    ];

    /**
     * The relationships that should be lazy loaded.
     */
    protected $with = ['artist', 'sim'];

    /**
     * Get the model's attribute casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the artist that owns the song.
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the sim that owns the song.
     */
    public function sim()
    {
        return $this->belongsTo(Sim::class);
    }
}

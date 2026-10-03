<?php

namespace App\Http\Requests\Songs;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SongUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'song_no' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'subscription_detail' => ['required', 'string', 'max:255'],
            'fast_subscription' => ['required', 'string', 'max:255'],
            'artist_id' => ['required', 'exists:artists,id'],
            'sim_id' => ['required', 'exists:sims,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }

}

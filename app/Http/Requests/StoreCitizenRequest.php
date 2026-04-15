<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitizenRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les agents ou admin peuvent créer un citoyen
        return auth()->user()->role === 'agent' || auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'birth_date'   => 'required|date',
            'birth_place'  => 'required|string|max:255',
            'gender'       => 'required|in:M,F',
            'address'      => 'required|string|max:255',
            'province'     => 'required|string|max:255',
            'territory'    => 'required|string|max:255',
            'sector'       => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'father_name'  => 'required|string|max:255',
            'mother_name'  => 'required|string|max:255',
            'photo'        => 'nullable|string|max:255',
        ];
    }
}

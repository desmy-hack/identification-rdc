<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitizenRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les agents peuvent mettre à jour leurs citoyens
        return auth()->user()->role === 'agent' || auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        // On ne valide pas le national_id car il est immuable
        return [
            'first_name'   => 'sometimes|required|string|max:255',
            'last_name'    => 'sometimes|required|string|max:255',
            'middle_name'  => 'sometimes|nullable|string|max:255',
            'birth_date'   => 'sometimes|required|date',
            'birth_place'  => 'sometimes|required|string|max:255',
            'gender'       => 'sometimes|required|in:M,F',
            'address'      => 'sometimes|required|string|max:255',
            'province'     => 'sometimes|required|string|max:255',
            'territory'    => 'sometimes|required|string|max:255',
            'sector'       => 'sometimes|required|string|max:255',
            'phone'        => 'sometimes|nullable|string|max:20',
            'father_name'  => 'sometimes|required|string|max:255',
            'mother_name'  => 'sometimes|required|string|max:255',
            'photo'        => 'sometimes|nullable|string|max:255',
        ];
    }
}

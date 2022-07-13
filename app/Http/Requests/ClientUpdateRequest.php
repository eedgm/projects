<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logo' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'owner' => ['required', 'max:255', 'string'],
            'phone' => ['nullable', 'max:255', 'string'],
            'website' => ['nullable', 'max:250', 'string'],
            'cost_hour' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
            'direction' => ['nullable', 'max:255', 'string'],
        ];
    }
}

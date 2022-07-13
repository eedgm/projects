<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkStoreRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
            'product_id' => ['required', 'exists:products,id'],
            'date_start' => ['nullable', 'date'],
            'date_end' => ['nullable', 'date'],
            'hours' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric'],
            'statu_id' => ['required', 'exists:status,id'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:155',
            'client_email' => ['required',Rule::unique('clients','client_email')], //unique email in clients table
            'client_phone' => 'required|string|min:10|max:15',
            'client_address' => 'required|string|max:55',
            'client_city' => 'required|string|max:55',
            'client_zipcode' => 'required|string|min:5|max:10',
        ];
    }
}

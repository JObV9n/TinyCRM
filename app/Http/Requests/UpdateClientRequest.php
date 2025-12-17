<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'client_name' => ['','string','max:155'],
            'client_email' => ['','string','email','max:255',Rule::unique('clients')->ignore($this->client)],
            'client_phone' => 'string|min:10|max:15',
            'client_address' => 'string|max:55',
            'client_city' => 'string|max:55',
            'client_zipcode' => 'string|min:5|max:10',
        ];
    }
}

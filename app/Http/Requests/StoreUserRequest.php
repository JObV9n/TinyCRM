<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //making this true for all the users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //custom rules 
            'first_name' => 'required|string|max:55',
            'last_name' => 'required|string|max:55',
            'email' => ['required',Rule::unique('users','email')], //unique email in users table
            'password' => 'required|string|min:8',
        ];
    }
}

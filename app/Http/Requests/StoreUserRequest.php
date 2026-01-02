<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'tenant' => ['required', 'integer', 'exists:tenants,id'],

            'nip_nis' => ['required', 'string', 'max:30', 'unique:profiles,nip_nis'],
            'phone' => ['required', 'string', 'max:20'],
            'birthdate' => ['required', 'date'],
            'religion' => ['required', Rule::in(['Islam', 'Kristen', 'Katholik', 'Hindu', 'Buddha', 'Konghucu'])],
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'address' => ['required', 'string'],

            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string', 'exists:roles,name'],
        ];
    }
    public function messages(): array
    {
        return [
            'roles.required' => 'Please select at least one role.',
            'roles.*.exists' => 'One or more selected roles are invalid.',
            'nip_nis.unique' => 'This NIP / NIS is already in use.',
            'email.unique' => 'This email address is already in use.',
        ];
    }
}

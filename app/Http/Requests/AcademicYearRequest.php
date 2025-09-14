<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AcademicYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('SuperAdmin|Wali Kelas|Guru');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'term' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Active,Inactive'
        ];
    }

    public function messages()
    {
        return [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be a date after the start date.',
            'term.required' => 'The term is required.',
            'term.in' => 'The term must be either Ganjil or Genap.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.'
        ];
    }
}

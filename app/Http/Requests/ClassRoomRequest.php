<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ClassRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('SuperAdmin|Kepala Sekolah|Wali Kelas|Guru');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'teacher_id' => 'required|exists:profiles,id',
        ];
    }
}

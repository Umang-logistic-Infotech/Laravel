<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            //
            'studentName' => 'required|string|max:255',
            'studentUserId' => 'required|integer|max:255',
            'studentAge' => 'required|integer|min:10|max:50',
            'studentDateOfBirth' => 'required|date',
            'studentGender' => 'required|in:male,female',
            'studentPercentage' => 'required|integer|min:0|max:100',
            'studentImage' => 'nullable|image|mimes:png,jpg,jpeg,svg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'studentName.required' => 'Student name is required',
            'studentAge.max' => 'Age must be under 50',
            'studentDateOfBirth.required' => 'Date of birth is required',
            'studentGender.required' => 'Gender is required',
            'studentPercentage.required' => 'Percentage is required',
            'studentUserId.required' => 'User id is required',
            'studentImage.image' => 'only images are allowed',
            'studentImage.max' => 'only images under 2 mb is allowed'
        ];
    }
}

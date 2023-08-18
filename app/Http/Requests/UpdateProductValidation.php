<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|min:10|max:15',
            'unique_code' => 'unique:products',
            'quantity' => 'integer|nullable',
            'type' => 'string',
            'manufacture_date' => 'date',
            'expiry_date' => 'string'
        ];
    }

    public function messages(): array
    {
        return [
            'min' => ':attribute უნდა შედგებოდეს მინიმუმ 10 სიმბოლოსგან',
            'max' => ':attribute უნდა შედგებოდეს მაქსიმუმ 15 სიმბოლოსგან',
            'unique' => ':attribute ასეთი კოდით პროდუქტი უკვე არსებობს!',
            'integer' => ':attribute უნდა შეიცავდეს ციფრებს',
            'manufacture_date.date' => 'გამოშვების თარიღი უნდა შეიცავდეს თარიღს',
        ];
    }
}

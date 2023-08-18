<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductValidation extends FormRequest
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
            'name' => 'required|string|min:10|max:15',
            'unique_code' => 'required|unique:products',
            'quantity' => 'integer|nullable',
            'type' => 'required|string',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'required|string'
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute სავალდებულოა!',
            'min' => ':attribute უნდა შედგებოდეს მინიმუმ 10 სიმბოლოსგან',
            'max' => ':attribute უნდა შედგებოდეს მაქსიმუმ 15 სიმბოლოსგან',
            'unique' => ':attribute ასეთი კოდით პროდუქტი უკვე არსებობს!',
            'integer' => ':attribute უნდა შეიცავდეს ციფრებს',
            'manufacture_date.date' => 'გამოშვების თარიღი უნდა იყოს თარიღის ფორმატის 0000/00/00',
        ];
    }

}

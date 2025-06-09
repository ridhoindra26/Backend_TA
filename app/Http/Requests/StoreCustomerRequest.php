<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreCustomerRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:customers',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'photo' => [
                        'nullable',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^data:image\/(png|jpg|jpeg|gif);base64,/', $value)) {
                                $fail('The ' . $attribute . ' must be a valid base64 encoded image.');
                            }
                        }
                    ],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}

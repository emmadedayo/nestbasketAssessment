<?php

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class CreateUserRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        //display first error message
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
            'code' => 442,
            'status' => true,
        ], 422));
    }
}

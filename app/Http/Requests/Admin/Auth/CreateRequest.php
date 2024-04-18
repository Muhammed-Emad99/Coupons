<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
            'name' => ['required', 'string','min:3','max:255'],
            'email' => ['required','email', Rule::unique('users','email')],
            'role' => ['required','in:Admin,User'],
            'password' => ['required','min:8','max:128','confirmed']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->fail('Validation Error', $validator->errors(),Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}

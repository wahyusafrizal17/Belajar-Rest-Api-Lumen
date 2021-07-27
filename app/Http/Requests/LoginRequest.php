<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email'    => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'         => 'Email tidak boleh kosong',
            'password.required'      => 'Password tidak boleh kosong',
        ];
    }
}

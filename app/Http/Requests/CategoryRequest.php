<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'    => 'required',
            'images'  => 'required',
            'type'    => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Name tidak boleh kosong',
            'images.required'       => 'Gambar tidak boleh kosong',
            'type.required'         => 'Type tidak boleh kosong',
        ];
    }
}

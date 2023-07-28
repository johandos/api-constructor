<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ruc' => 'required|string|max:11|unique:companies,ruc',
            'razon_social' => 'required|string|max:75',
            'direccion' => 'required|string|max:75',
            'contacto' => 'required|string|max:50',
            'correo' => 'required|string|email|max:50|unique:companies,correo',
            'telefono' => 'required|string|max:9',
        ];
    }
}

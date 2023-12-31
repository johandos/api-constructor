<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstructionsRequest extends FormRequest
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
            'codigo_obra' => '',
            'nombre_obra' => 'required|max:50',
            'direccion' => 'required|max:75',
            'ubicacion' => 'required|max:50',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre_obra.required' => 'El nombre de la obra es requerido.',
            'direccion.required' => 'La dirección es requerida.',
            'ubicacion.required' => 'La ubicación es requerida.',
        ];
    }
}

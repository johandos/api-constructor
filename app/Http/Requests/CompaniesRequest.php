<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

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
        return match ($this->method()) {
            'POST' => [
                'ruc' => 'required|string|max:11|unique:companies,ruc',
                'razon_social' => 'required|string|max:75',
                'direccion' => 'required|string|max:75',
                'contacto' => 'required|string|max:50',
                'correo' => 'required|string|email|max:50|unique:companies,correo',
                'telefono' => 'required|string|max:9',
            ],
            'PUT', 'PATCH' => [
                'ruc' => 'string|max:11|unique:companies,ruc',
                'razon_social' => 'string|max:75',
                'direccion' => 'string|max:75',
                'contacto' => 'string|max:50',
                'correo' => 'string|email|max:50|unique:companies,correo',
                'telefono' => 'string|max:9',
            ],
            default => [],
        };
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $validator->errors()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}

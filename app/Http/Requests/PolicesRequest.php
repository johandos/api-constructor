<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PolicesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => [
                'numero_poliza' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'aseguradora' => 'required|string|max:255',
                'telefono_aseguradora' => 'required|string|max:20',
                'telefono_broker' => 'required|string|max:20',
                'cronograma_pago' => 'required|string|max:255',
                'poliza_adjunta' => 'required|mimes:pdf', // si quieres validar tipos de archivo específicos puedes usar 'mimes:pdf,docx'
                'tipo_poliza' => 'required|in:SOAT,VEHICULAR,SAT,TREC,RC',
                'estado_poliza' => 'required|in:activo,inactivo',
            ],
            'PUT', 'PATCH' => [
                'numero_poliza' => 'string|max:255',
                'fecha_inicio' => 'date',
                'fecha_fin' => 'date|after_or_equal:fecha_inicio',
                'aseguradora' => 'string|max:255',
                'telefono_aseguradora' => 'string|max:20',
                'telefono_broker' => 'string|max:20',
                'cronograma_pago' => 'string|max:255',
                'tipo_poliza' => 'in:SOAT,VEHICULAR,SAT,TREC,RC',
                'estado_poliza' => 'in:activo,inactivo',
            ],
            default => []
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

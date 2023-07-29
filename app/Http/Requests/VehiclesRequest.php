<?php

namespace App\Http\Requests;

use App\Rules\PhotographyVehicleRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VehiclesRequest extends FormRequest
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
                'placa' => 'required|max:6',
                'numero_bastidor' => 'required|max:15',
                'fotografia_vehiculo' => 'required|image|mimes:jpeg,png,webp|max:1024',
                'companies_id' => 'required|exists:companies,id',
            ],
            'PUT', 'PATCH' => [
                'placa' => 'max:6',
                'numero_bastidor' => 'max:15',
                'fotografia_vehiculo' => [
                    'sometimes', 'image', 'mimes:jpeg,png,webp', 'max:1024',
                ],
                'companies_id' => 'sometimes|exists:companies,id',
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

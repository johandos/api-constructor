<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesRequest;
use App\Models\Companies;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompaniesController extends Controller
{
    public function index()
    {
        $empresa = Companies::all();
        return response()->json($empresa, 200);
    }

    public function store(CompaniesRequest $request): JsonResponse
    {
        $empresa = new Companies($request->validated());
        $empresa->save();

        try {
            return response()->json([
                'message' => 'Companies creada con éxito',
                'empresa' => $empresa
            ], 201);

        }catch (\Exception $e){
            Log::error(json_encode($e));

            return response()->json([
                'message' => 'El archivo de la póliza es requerido'
            ], 400);
        }
    }

    public function show($ruc): JsonResponse
    {
        $empresa = Companies::query()->find($ruc);

        if ($empresa) {
            return response()->json($empresa, 200);
        } else {
            return response()->json(['error' => 'Companies no encontrada'], 404);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $vehiculos = Companies::query()
            ->where('ruc', 'like', "%$search%")
            ->first();

        if ($vehiculos){
            return response()->json($vehiculos);
        }else{
            return response()->json([
                'message' => 'Vehiculo no encontrado'
            ], 400);
        }
    }

    public function update(CompaniesRequest $request, $id): JsonResponse
    {
        $empresa = Companies::query()->find($id);

        if ($empresa) {
            $empresa->update($request->validated());

            $empresa = Companies::query()->find($id);

            return response()->json([
                'message' => 'Companies actualizada con éxito',
                'empresa' => $empresa
            ], 200);
        }

        return response()->json([
            'message' => 'Error inesperado al realizar la actualizacion'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $empresa = Companies::query()->find($id);

        if ($empresa) {
            $empresa->delete();

            return response()->json([
                'message' => 'Companies eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Companies no encontrada'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresa = Empresa::all();
        return response()->json($empresa, 200);
    }

    public function store(EmpresaRequest $request): JsonResponse
    {
        $empresa = new Empresa($request->validated());
        $empresa->save();

        try {
            return response()->json([
                'message' => 'Empresa creada con éxito',
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
        $empresa = Empresa::query()->find($ruc);

        if ($empresa) {
            return response()->json($empresa, 200);
        } else {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }
    }

    public function update(EmpresaRequest $request, $id): JsonResponse
    {
        $empresa = Empresa::query()->find($id);

        if ($empresa) {
            $empresa->update($request->validated());

            $empresa = Empresa::query()->find($request->get('id'));

            return response()->json([
                'message' => 'Empresa actualizada con éxito',
                'empresa' => $empresa
            ], 200);
        }

        return response()->json([
            'message' => 'Error inesperado al realizar la actualizacion'
        ], 400);
    }

    // TODO: revisar el eliminar empresa (si es posible hablarlo con el profesor)
    /*public function destroy($id): JsonResponse
    {
        $empresa = Empresa::query()->find($id);

        if ($empresa) {
            $empresa->delete();

            return response()->json([
                'message' => 'Empresa eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }
    }*/
}

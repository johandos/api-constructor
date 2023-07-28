<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConstructionsRequest;
use App\Models\Constructions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ConstructionsController extends Controller
{
    public function index()
    {
        $polizas = Constructions::all();
        return response()->json($polizas, 200);
    }

    public function store(ConstructionsRequest $request): JsonResponse
    {
        $obra = new Constructions($request->validated());
        $obra->save();

        try {
            return response()->json([
                'message' => 'Constructions creada con éxito',
                'Constructions' => $obra
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
        $obra = Constructions::query()->find($ruc);

        if ($obra) {
            return response()->json($obra, 200);
        } else {
            return response()->json(['error' => 'Constructions no encontrada'], 404);
        }
    }

    public function update(ConstructionsRequest $request, $id): JsonResponse
    {
        $obra = Constructions::query()->find($id);

        if ($obra) {
            $obra->update($request->validated());

            $obra = Constructions::query()->find($request->get('id'));

            return response()->json([
                'message' => 'Constructions actualizada con éxito',
                'Constructions' => $obra
            ], 200);
        }

        return response()->json([
            'message' => 'Error inesperado al realizar la actualizacion'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $obra = Constructions::query()->find($id);

        if ($obra) {
            $obra->delete();

            return response()->json([
                'message' => 'Constructions eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Constructions no encontrada'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObraRequest;
use App\Models\Obra;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ObraController extends Controller
{
    public function index()
    {
        $polizas = Obra::all();
        return response()->json($polizas, 200);
    }

    public function store(ObraRequest $request): JsonResponse
    {
        $obra = new Obra($request->validated());
        $obra->save();

        try {
            return response()->json([
                'message' => 'Obra creada con éxito',
                'Obra' => $obra
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
        $obra = Obra::query()->find($ruc);

        if ($obra) {
            return response()->json($obra, 200);
        } else {
            return response()->json(['error' => 'Obra no encontrada'], 404);
        }
    }

    public function update(ObraRequest $request, $id): JsonResponse
    {
        $obra = Obra::query()->find($id);

        if ($obra) {
            $obra->update($request->validated());

            $obra = Obra::query()->find($request->get('id'));

            return response()->json([
                'message' => 'Obra actualizada con éxito',
                'Obra' => $obra
            ], 200);
        }

        return response()->json([
            'message' => 'Error inesperado al realizar la actualizacion'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $obra = Obra::query()->find($id);

        if ($obra) {
            $obra->delete();

            return response()->json([
                'message' => 'Obra eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Obra no encontrada'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PolizaRequest;
use App\Models\Polizas;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PolizasController extends Controller
{
    public function index()
    {
        $polizas = Polizas::all();
        return response()->json($polizas, 200);
    }

    public function store(PolizaRequest $request): JsonResponse
    {
        $poliza = new Polizas($request->validated());

        if ($request->hasFile('poliza_adjunta')) {
            $file = $request->file('poliza_adjunta');
            $disk = new PolizasStorageStrategy();
            $file->move($disk->getPath(), $file->hashName());
            $poliza->poliza_adjunta = $file->hashName();
            $poliza->save();

            return response()->json([
                'message' => 'Poliza creada con éxito',
                'polizas' => $poliza
            ], 201);
        }

        return response()->json([
            'message' => 'El archivo de la póliza es requerido'
        ], 400);
    }

    public function show($id)
    {
        $poliza = Polizas::find($id);

        if ($poliza) {
            return response()->json($poliza, 200);
        } else {
            return response()->json(['error' => 'Póliza no encontrada'], 404);
        }
    }

    public function update(PolizaRequest $request, $id): JsonResponse
    {
        $poliza = Polizas::query()->find($id);

        if ($poliza && $request->hasFile('poliza_adjunta')) {
            $file = $request->file('poliza_adjunta');
            $disk = new PolizasStorageStrategy();
            $file->move($disk->getPath(), $file->hashName());
            $poliza->poliza_adjunta = $file->hashName();
            $poliza->save();

            dump($poliza);

            return response()->json([
                'message' => 'Poliza creada con éxito',
                'polizas' => $poliza
            ], 200);
        }

        return response()->json([
            'message' => 'El archivo de la póliza es requerido'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $poliza = Polizas::query()->find($id);

        if ($poliza) {
            $poliza->delete();

            return response()->json([
                'message' => 'Póliza eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Póliza no encontrada'], 404);
        }
    }
}

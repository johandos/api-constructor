<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolicesRequest;
use App\Models\Companies;
use App\Models\Polices;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolicesController extends Controller
{
    public function index()
    {
        $polizas = Polices::all();
        return response()->json($polizas, 200);
    }

    public function store(PolicesRequest $request): JsonResponse
    {
        $poliza = new Polices($request->validated());

        if ($request->hasFile('poliza_adjunta')) {
            $file = $request->file('poliza_adjunta');
            $disk = new PolizasStorageStrategy();
            $poliza->poliza_adjunta = $file->move($disk->getPath(), $file->hashName())->getFilename();
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
        $poliza = Polices::find($id);

        if ($poliza) {
            return response()->json($poliza, 200);
        } else {
            return response()->json(['error' => 'Póliza no encontrada'], 404);
        }
    }
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $vehiculos = Polices::query()
            ->where('numero_poliza', 'like', "%$search%")
            ->first();

        if ($vehiculos){
            return response()->json($vehiculos);
        }else{
            return response()->json([
                'message' => 'poliza no encontrado'
            ], 400);
        }
    }

    public function update(PolicesRequest $request, $id): JsonResponse
    {
        $poliza = Polices::query()->find($id);

        if ($poliza) {
            $poliza->update($request->validated());

            if ($request->hasFile('poliza_adjunta')) {
                $file = $request->file('poliza_adjunta');
                $disk = new PolizasStorageStrategy();
                $poliza->poliza_adjunta = $file->move($disk->getPath(), $file->hashName())->getFilename();
                $poliza->save();
            }

            $poliza = Polices::query()->find($id);

            return response()->json([
                'message' => 'Poliza actualizada con éxito',
                'polizas' => $poliza
            ], 200);
        }

        return response()->json([
            'message' => 'Poliza no encontrada'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $poliza = Polices::query()->find($id);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VehiculosRequest;
use App\Models\Vehiculo;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use App\Services\FileStorageStrategies\VehiculoStorageStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VehiculoController extends Controller
{
    public function index()
    {
        $polizas = Vehiculo::all();
        return response()->json($polizas, 200);
    }

    public function store(VehiculosRequest $request): JsonResponse
    {
        $vehiculo = new Vehiculo($request->validated());
        $vehiculo->save();

        if ($request->hasFile('fotografia_vehiculo')) {
            $file = $request->file('fotografia_vehiculo');
            $disk = new VehiculoStorageStrategy();
            $file->move($disk->getPath(), $file->hashName());
            $vehiculo->fotografia_vehiculo = $file->hashName();
            $vehiculo->save();

            return response()->json([
                'message' => 'Vehiculo creada con éxito',
                'polizas' => $vehiculo
            ], 201);
        }

        return response()->json([
            'message' => 'La imagen del vehiculo es requerido'
        ], 400);
    }

    public function show($placa): JsonResponse
    {
        $vehiculo = Vehiculo::query()->find($placa);

        if ($vehiculo) {
            return response()->json($vehiculo, 200);
        } else {
            return response()->json(['error' => 'Vehiculo no encontrada'], 404);
        }
    }

    public function update(VehiculosRequest $request, $id): JsonResponse
    {
        $vehiculo = Vehiculo::query()->find($id);

        if ($vehiculo) {
            $vehiculo->update($request->validated());

            if ($request->hasFile('fotografia_vehiculo')) {
                $file = $request->file('fotografia_vehiculo');
                $disk = new VehiculoStorageStrategy();
                $file->move($disk->getPath(), $file->hashName());
                $vehiculo->fotografia_vehiculo = $file->hashName();
                $vehiculo->save();
            }

            $vehiculo = Vehiculo::query()->find($request->get('fotografia_vehiculo'));

            return response()->json([
                'message' => 'Vehiculo actualizada con éxito',
                'vehiculo' => $vehiculo
            ], 200);
        }

        return response()->json([
            'message' => 'La imagen del vehiculo es requerido'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $vehiculo = Vehiculo::query()->find($id);

        if ($vehiculo) {
            $vehiculo->delete();

            return response()->json([
                'message' => 'Vehiculo eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Vehiculo no encontrada'], 404);
        }
    }
}

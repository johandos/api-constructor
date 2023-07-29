<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehiclesRequest;
use App\Models\Vehicles;
use App\Services\FileStorageStrategies\VehiculoStorageStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        $polizas = Vehicles::all();
        return response()->json($polizas, 200);
    }

    public function store(VehiclesRequest $request): JsonResponse
    {
        $vehiculo = new Vehicles($request->validated());
        $vehiculo->save();

        if ($request->hasFile('fotografia_vehiculo')) {
            $file = $request->file('fotografia_vehiculo');
            $disk = new VehiculoStorageStrategy();
            $vehiculo->fotografia_vehiculo = $file->move($disk->getPath(), $file->hashName())->getFilename();
            $vehiculo->save();

            return response()->json([
                'message' => 'Vehicles creada con éxito',
                'Vehicle' => $vehiculo
            ], 201);
        }

        return response()->json([
            'message' => 'La imagen del vehiculo es requerido'
        ], 400);
    }

    public function show($placa): JsonResponse
    {
        $vehiculo = Vehicles::query()->find($placa);

        if ($vehiculo) {
            return response()->json($vehiculo, 200);
        } else {
            return response()->json(['error' => 'Vehicles no encontrada'], 404);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $vehiculos = Vehicles::query()
            ->where('placa', 'like', "%$search%")
            ->first();

        if ($vehiculos){
            return response()->json($vehiculos);
        }else{
            return response()->json([
                'message' => 'Vehiculo no encontrado'
            ], 400);
        }
    }

    public function update(VehiclesRequest $request, $id): JsonResponse
    {
        $vehiculo = Vehicles::query()->find($id);

        if ($vehiculo) {
            $vehiculo->update($request->validated());

            if ($request->hasFile('fotografia_vehiculo')) {
                $file = $request->file('fotografia_vehiculo');
                $disk = new VehiculoStorageStrategy();
                $vehiculo->fotografia_vehiculo = $file->move($disk->getPath(), $file->hashName())->getFilename();
                $vehiculo->save();
            }


            $vehiculo = Vehicles::query()->find($id);

            return response()->json([
                'message' => 'Vehicles actualizada con éxito',
                'vehiculo' => $vehiculo
            ], 200);
        }

        return response()->json([
            'message' => 'Vehiculo no encontrado'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $vehiculo = Vehicles::query()->find($id);

        if ($vehiculo) {
            $vehiculo->delete();

            return response()->json([
                'message' => 'Vehicles eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Vehicles no encontrada'], 404);
        }
    }
}

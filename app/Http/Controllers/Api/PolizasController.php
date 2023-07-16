<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PolizaRequest;
use App\Models\Polizas;
use App\Services\FileStorageFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $filename = $file->getClientOriginalName();

            $path = FileStorageFactory::create('poliza');
            $file->move($path, $filename);

            $poliza->save();

            return response()->json([
                'message' => 'Poliza creada con éxito',
                'poliza' => $poliza
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

    public function update(PolizaRequest $request, $id)
    {
        $poliza = Polizas::query()->find($id);


        if ($poliza) {
            $poliza->numero_poliza = $request->get('numero_poliza');
            $poliza->fecha_inicio = $request->get('fecha_inicio');
            $poliza->fecha_fin = $request->get('fecha_fin');
            $poliza->aseguradora = $request->get('aseguradora');
            $poliza->telefono_aseguradora = $request->get('telefono_aseguradora');
            $poliza->telefono_broker = $request->get('telefono_broker');
            $poliza->cronograma_pago = $request->get('cronograma_pago');
            $poliza->poliza_adjunta = $request->get('poliza_adjunta');
            $poliza->tipo_poliza = $request->get('tipo_poliza');
            $poliza->estado_poliza = $request->get('estado_poliza');
            $poliza->save();

            return response()->json([
                'message' => 'Póliza actualizada con éxito',
                'poliza' => $poliza
            ], 200);
        } else {
            return response()->json(['error' => 'Póliza no encontrada'], 404);
        }
    }

    public function destroy($id)
    {
        $poliza = Polizas::find($id);

        if ($poliza) {
            $poliza->delete();

            return response()->json([
                'message' => 'Póliza eliminada con éxito'
            ], 200);
        } else {
            return response()->json(['error' => 'Póliza no encontrada'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ObraRequest;
use App\Http\Requests\UsuariosRequest;
use App\Models\Obra;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UsuariosController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    public function store(UsuariosRequest $request): JsonResponse
    {
        $user = new User($request->validated());
        $user->save();

        try {
            return response()->json([
                'message' => 'Usuario creada con éxito',
                'usuario' => $user
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
        $user = User::query()->find($ruc);

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'Usuario no encontrada'], 404);
        }
    }

    public function update(UsuariosRequest $request, $id): JsonResponse
    {
        $user = User::query()->find($id);

        if ($user) {
            $user->update($request->validated());

            $user = User::query()->find($request->get('id'));

            return response()->json([
                'message' => 'Usuario actualizada con éxito',
                'usuario' => $user
            ], 200);
        }

        return response()->json([
            'message' => 'Error inesperado al realizar la actualizacion'
        ], 400);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::query()->find($id);

        if ($user) {
            $user->delete();

            return response()->json([
                'message' => 'Usuario eliminada con éxito'
            ], 204);
        } else {
            return response()->json(['error' => 'Usuario no encontrada'], 404);
        }
    }
}

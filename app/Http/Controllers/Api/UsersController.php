<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    public function store(UsersRequest $request): JsonResponse
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
                'message' => 'Erros al guardar el usuario'
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
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $vehiculos = User::query()
            ->where('dni', 'like', "%$search%")
            ->first();

        if ($vehiculos){
            return response()->json($vehiculos);
        }else{
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 400);
        }
    }

    public function update(UsersRequest $request, $id): JsonResponse
    {
        $user = User::query()->find($id);

        if ($user) {
            $user->update($request->validated());

            $user = User::query()->find($id);

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

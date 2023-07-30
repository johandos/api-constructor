<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = new User($request->validated());
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Usuario registrado con éxito',
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        }catch (\Exception $e){
            Log::error(json_encode($e));

            return response()->json([
                'message' => 'Erros al registart el usuario'
            ], 400);
        }
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))){
            Log::error(json_encode($request->all()));

            return response()->json([
                'message' => 'Erros de autenticacion'
            ], 400);
        }

        $user = User::query()->where('email', $request->get('email'))->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    public function logout(){
        \auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Se ha cerrado la sesion del usuario',
        ], 201);
    }
}

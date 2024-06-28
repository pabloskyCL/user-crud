<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        if ($data) {
            $user = new User($data);
            $user->assignRole('User');
            $user->save();

            return response()->json(['success' => true, 'message' => 'usuario creado con exito'], JsonResponse::HTTP_CREATED);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        // dd($credentials);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'usuario o contraseña invalidos', ['error' => 'usuario o contraseña invalidos'],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $request->user();

        $token = $user->createToken('loginToken')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->roles 
            ],
            'accessToken' => $token,
        ]);
    }
}

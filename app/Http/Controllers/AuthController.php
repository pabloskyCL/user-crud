<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        if ($data) {
            $user = new User($data);
            $user->save();

            return new JsonResponse(['success' => true, 'message' => 'usuario creado con exito'],JsonResponse::HTTP_CREATED);
        }
    }
}

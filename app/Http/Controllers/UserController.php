<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $users = User::where('id', '!=', $user->id)->get();

        return UserResource::collection($users);
    }

    public function show(int $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new UserResource($user);
    }

    public function create(AdminCreateUserRequest $request)
    {
        $user = $request->validated();

        $createdUser = new User([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);

        $createdUser->assignRole($user['role']);
        if (!$createdUser->save()) {
            return response()->json(['message' => 'ops! ha ocurrido un error', JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return response()->json(new UserResource($createdUser), JsonResponse::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $user = User::where(['email' => $data['email']])->first();

        if (!$user) {
            return response()->json(['message' => 'ops! ha ocurrido un error usuario no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->assignRole($data['role']);
        $user->save();

        return response()->json([
            'message' => 'se actualizo la información de usuario '.$user->name,
        ]);
    }

    // public function updatePassword(int $id)
    // {
    // }

    public function delete(Request $request)
    {
        $userId = $request->id;

        if (User::destroy($userId)) {
            return response()->json([
                'message' => 'usuario  eliminado',
            ]);
        }

        return response()->json([
            'message' => 'ops! ha ocurrido un error',
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('role:Admin', only: ['index', 'create', 'delete']),
        ];
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $users = User::where('id', '!=', $user->id)->get();

        return UserResource::collection($users);
    }

    public function show(int $id)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Admin') && $id != $authUser->id) {
            return response()->json(['message' => 'no tienes privilegios para ver información de otros usuarios'], JsonResponse::HTTP_UNAUTHORIZED);
        }

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

        $createdUser->syncRoles($user['role']);
        if (!$createdUser->save()) {
            return response()->json(['message' => 'ops! ha ocurrido un error', JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return response()->json(new UserResource($createdUser), JsonResponse::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();

        $user = User::where(['email' => $data['email']])->first();

        $authUser = auth()->user();

        if (!$authUser->hasRole('Admin') && $user->id != $authUser->id) {
            return response()->json(['message' => 'no tienes privilegios para editar información de otros usuarios'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!$user) {
            return response()->json(['message' => 'ops! ha ocurrido un error usuario no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        $authUser->hasRole('Admin') ? $user->syncRoles($data['role']) : $user->syncRoles('User');
        $user->save();

        return response()->json([
            'message' => 'se actualizo la información de usuario '.$user->name,
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = json_decode($request->getContent());

        $user = User::where('id', $data->userId)->first();

        $authUser = auth()->user();

        if (!$authUser->hasRole('Admin') && $data->userId != $authUser->id) {
            return response()->json(['message' => 'no tienes privilegios para cambiar la contraseña de otros usuarios'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $isUpdated = $user->update(['password' => Hash::make($data->password)]);
        if ($isUpdated) {
            return response()->json(['message' => 'contraseña actualizada con exito']);
        }

        return response()->json(['message' => 'ops! ha ocurrido un error'], JsonResponse::HTTP_NOT_FOUND);
    }

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

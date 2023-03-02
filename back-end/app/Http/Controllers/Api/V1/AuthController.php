<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user=(new User())->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        $token = $user->createToken('auth_token');

        return response()->json([
            'message' => "Successfully registered as $user->name.",
            'token' => $token->plainTextToken,
            'user_name' => $user->name,
            'user_id' => $user->id,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()->where('email', $request->email)->first();
        if (!isset($user) || !Hash::check(request()->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong password or email!',
            ]);
        }
        $token = $user->createToken('auth_token');

        return response()->json([
            'message' => "Successfully logged in as $user->name.",
            'token' => $token->plainTextToken,
            'user_name' => $user->name,
            'user_id' => $user->id,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out.',
            'api' => $request,
        ]);
    }
}

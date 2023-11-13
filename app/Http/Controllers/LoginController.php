<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->route()->getName() !== 'logout') {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required',
            ], [
                'email'    => [
                    'required' => 'Vui lòng nhập email',
                    'email'    => 'Vui lòng nhập email',
                ],
                'password' => [
                    'required' => 'Vui lòng nhập mật khẩu',
                ],
            ]);

            if ($validator->fails()) {
                return $validator->errors()->first();
            }

            if (Auth::attempt($request->all())) {
                $user = $request->user();
                $user->access_token = $user->createToken($user->name)->plainTextToken;
                return $user;
            }
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        // For Sanctum token revocation
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }
}

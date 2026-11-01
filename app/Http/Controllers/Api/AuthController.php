<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        $parts = preg_split('/\s+/', trim($data['name'])) ?? [];
        Client::firstOrCreate(
            ['email' => $data['email']],
            [
                'first_name' => $parts[0] ?? '',
                'middle_name' => '',
                'last_name' => count($parts) > 1 ? $parts[count($parts) - 1] : '',
                'phone' => '',
                'passport' => '',
                'data_country_code' => 'ID',
            ]
        );

        return response()->json(['success' => true, 'data' => [
            'token' => $user->createToken('airlane-mobile')->plainTextToken,
            'user' => $this->userPayload($user),
        ]]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        return response()->json(['success' => true, 'data' => [
            'token' => $user->createToken('airlane-mobile')->plainTextToken,
            'user' => $this->userPayload($user),
        ]]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['success' => true]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $this->userPayload($request->user())]);
    }

    private function userPayload(User $user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'user',
        ];
    }
}
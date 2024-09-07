<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::guard('user')->attempt($credentials)) {
          throw new AuthenticationException('ログインに失敗しました。');
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'ログインしました。'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $existsEmail = User::where('email', $request->email)->exists();

        if ($existsEmail) {
            return response()->json([
                'message' => 'メールアドレスがすでに登録されています。'
            ]);
        }

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'ユーザ登録が完了しました。',
        ]);
    }
}

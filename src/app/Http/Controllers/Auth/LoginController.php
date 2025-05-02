<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login(\App\Http\Requests\LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'auth' => 'ログイン情報が登録されていません。',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}


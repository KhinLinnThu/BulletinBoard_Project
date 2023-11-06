<?php

namespace App\Http\Controllers\Auth;

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showlogin()
    {
        return view('auth/login');
    }
    public function login(Request $request)
    {
        $validationRules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
        $validateMessage = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が間違っています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは少なくとも8つ必要です。',
        ];
        Validator::make($request->all(), $validationRules, $validateMessage)->validate();

        if (Auth::attempt(request()->except('_token'))) {
            return redirect()->route('home');
        } else {
            return back()->withInput()->withErrors(
                [
                    'password' => 'パスワードが違っています。',
                ]
            );
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

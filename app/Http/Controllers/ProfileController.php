<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
    /**
     * Display the password change form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('auth/password-change');
    }

    /**
     * Store the data with password changes.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $this->ValidationCheck($request);
        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect('/')->with('success', 'パスワードは正常に変更されました。');
        } else {
            return back()->with('error', '現在のパスワードは間違っています。');
        }
    }
    private function ValidationCheck($request)
    {
        $validationRules = [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
            'new_password_confirmation' => 'required|min:8'
        ];
        $validateMessage = [
            'current_password.required' => '現在のパスワードを入力してください。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.min' => 'パスワードは8文字である必要があります',
            'new_password_confirmation.required' => '新しいパスワードの確認を入力してください。',
            'new_password_confirmation.min' => 'パスワードは8文字である必要があります',
            'new_password.confirmed' => 'パスワードは一致しません。',
        ];
        Validator::make($request->all(), $validationRules, $validateMessage)->validate();
    }

}

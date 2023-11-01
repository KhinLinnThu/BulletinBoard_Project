<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
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
            $userCount = User::count();
            $postCount = Post::count();
            $userPostCount = Auth::user()->posts->count();
            return view('home', compact('userCount', 'postCount', 'userPostCount'));
        } else {
            return back()->withInput()->withErrors(
                [
                    'password' => 'パスワードが違っています。',
                ]
            );
            ;
        }
    }
    public function homeCount()
    {
        $userCount = User::count();
        if (Auth::user()->role === 1) {
            $postCount = Post::count();
        } else {
            $postCount = Auth::user()->posts->count();
        }
        $userPostCount = Auth::user()->posts->count();
        return view('home', compact('userCount', 'postCount', 'userPostCount'));
    }

    public function userManagement()
    {
        $user_datas = User::leftJoin('users as user', 'user.id', '=', 'users.created_user_id')
            ->select('users.*', 'user.name as created_user_name')
            ->orderBy('users.id', 'desc')
            ->paginate(10);

        return view('user/usermanagement', compact('user_datas'));
    }
    public function userCreate()
    {
        return view('user/usercreate');
    }
    public function userConfirm(Request $request)
    {
        $this->userValidationCheck($request);
        $user_datas = $request->all();
        if ($request->hasFile('profile')) {
            $fileName = uniqid() . $request->file('profile')->getClientOriginalName();
            $path = $request->file('profile')->storeAs('images', $fileName, 'public');
            $profile = '/storage/' . $path;
            $user_datas['profile'] = $profile;
        }
        return view('user/userconfirm', compact('user_datas', 'fileName'));
    }
    public function userCreateComplete(Request $request)
    {
        $data = $request->all();
        $data['created_user_id'] = Auth::user()->id;
        $data['updated_user_id'] = Auth::user()->id;
        $data['deleted_user_id'] = Auth::user()->id;
        User::Create($data);
        return redirect()->route('user#management');
    }
    public function userEdit($id)
    {
        $user = User::where('id', $id)->first()->toArray();
        return view('user/useredit', compact('user'));
    }
    public function userUpdate(Request $request)
    {

        // $this->userValidationCheck($request);
        $updateData = request()->except(['_token', 'user_id']);
        $updateData['updated_user_id'] = Auth::user()->id;
        $updateData['deleted_user_id'] = Auth::user()->id;
        $id = $request->user_id;
        if ($request->hasFile('profile')) {
            $oldImg = User::select('profile')->where('id', $id)->first()->toArray();
            $oldImg = $oldImg['profile'];
            Storage::delete('public/images/' . $oldImg);

            $fileName = uniqid() . $request->file('profile')->getClientOriginalName();
            $path = $request->file('profile')->storeAs('images', $fileName, 'public');
            $profile = '/storage/' . $path;
            $updateData['profile'] = $profile;
        }
        User::where('id', $id)->update($updateData);
        return redirect()->route('user#management');
    }
    public function userDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return redirect()->back()->with('error', '削除する項目を選択してください。');
        } else {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('user#management');
        }
    }

    public function userSearch(Request $request)
    {
        $user_datas = User::where('name', 'like', '%' . $request->name . '%')
            ->where('email', 'like', '%' . $request->email . '%')
            ->whereDate('created_at', $request->create_date)
            ->paginate(10);
        ;
        return view('user/usermanagement', compact('user_datas'));
    }
    private function userValidationCheck($request)
    {
        $validationRules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password|min:8',
            'role' => 'required',
            'profile' => 'required|mimes:jpg,jpeg,png',
        ];
        $validateMessage = [
            'name.required' => '氏名を入力してください。',
            'name.min' => '氏名は5文字である必要があります',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が間違っています。',
            'email.unique' => 'メールアドレスが既に使用されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字である必要があります',
            'confirm-password.required' => 'ベリファイパスワードを入力してください。',
            'confirm-password.min' => 'ベリファイパスワードは8文字である必要があります',
            'confirm-password.same' => 'パスワードは一致しません。',
            'role.required' => '権限種別を入力してください。',
            'profile.required' => 'プロフィールを入力してください。',
            'profile.mimes' => 'プロフィールはjpg,png,jpegになる必要があります。',
        ];
        Validator::make($request->all(), $validationRules, $validateMessage)->validate();
    }
}

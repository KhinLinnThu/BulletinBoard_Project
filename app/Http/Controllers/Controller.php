<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userManagement()
    {
        $user_datas = User::leftJoin('users as user', 'user.id', '=', 'users.created_user_id')
            ->select('users.*', 'user.name as created_user_name')
            ->orderBy('users.id', 'desc')
            ->paginate(10);
        return view('user/user_management', compact('user_datas'));
    }
    /**
     * Display the user create form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userCreate()
    {
        return view('user/user_create');
    }

    /**
     * Display the user confirm form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
        return view('user/user_confirm', compact('user_datas'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userCreateComplete(Request $request)
    {
        $data = $request->all();
        $data['created_user_id'] = Auth::user()->id;
        $data['updated_user_id'] = Auth::user()->id;
        User::Create($data);
        return redirect()->route('user_management');
    }
    /**
     * Display the user edit form.
     * @param number $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userEdit($id)
    {
        $user = User::where('id', $id)->first()->toArray();
        return view('user/user_edit', compact('user'));
    }
    /**
     * Update resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userUpdate(Request $request)
    {
        $updateData = request()->except(['_token', 'user_id']);
        $updateData['updated_user_id'] = Auth::user()->id;
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
        return redirect()->route('user_management');
    }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return redirect()->back()->with('error', '削除する項目を選択してください。');
        } else {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('user_management');
        }
    }
    /**
     * Display a listing of the resource with search.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userSearch(Request $request)
    {
        $user_datas = DB::table('users as user')
            ->when(request('searchName'), function ($query) {
                $query->where('user.name', 'Like', '%' . request('searchName') . '%');
            })
            ->when(request('searchEmail'), function ($query) {
                $query->where('user.email', 'Like', '%' . request('searchEmail') . '%');
            })
            ->when(in_array(request('searchRole'), [1, 2]), function ($query) {
                $query->where('user.role', 'Like', '%' . request('searchRole') . '%');
            })

            ->when(request('from_date'), function ($query) {
                $searchFrom = date('Y/m/d', strtotime(request('from_date')));
                $query->whereDate('user.created_at', '>=', date('Y-m-d 00:00:00', strtotime($searchFrom)));
            })
            ->when(request('to_date'), function ($query) {
                $searchFrom = date('Y/m/d', strtotime(request('to_date')));
                $query->whereDate('user.created_at', '<=', date('Y-m-d 00:00:00', strtotime($searchFrom)));
            })
            ->join('users as created_user', 'user.created_user_id', '=', 'created_user.id')
            ->join('users as updated_user', 'user.updated_user_id', '=', 'updated_user.id')
            ->select('user.*', 'created_user.name as created_user_name', 'updated_user.name as updated_user_name')
            ->orderBy('created_at', 'desc')
            ->whereNull('user.deleted_at')
            ->paginate(10);
        return view('user/user_management', compact('user_datas'));
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

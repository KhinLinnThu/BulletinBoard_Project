<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function postManagement()
    {
        if (Auth::user()->role === 1) {
            $post_datas = DB::table('posts')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/postmanagement', compact('post_datas'));
        } else {
            $post_datas = DB::table('posts')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->where('posts.created_user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/postmanagement', compact('post_datas'));
        }
    }
    public function postCreate()
    {
        return view('post/postcreate');
    }
    public function postConfirm(Request $request)
    {
        $this->userValidationCheck($request);
        $confirm_data = $request->all();
        return view('post/postconfirm', compact('confirm_data'));
    }
    public function postCreateComplete(Request $request)
    {

        $status = (isset($request->status) == '1' ? '1' : '0');
        Post::Create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $status,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
                'deleted_user_id' => Auth::user()->id
            ]
        );
        return redirect()->route('post#management');
    }

    public function postEdit($id)
    {
        $post = Post::where('id', $id)->first()->toArray();
        return view('post/postedit', compact('post'));
    }
    public function postUpdate(Request $request)
    {
        $this->userValidationCheck($request);
        $id = $request->post_id;
        $updateData = request()->except(['_token', 'post_id']);
        $updateData['updated_user_id'] = Auth::user()->id;
        $updateData['deleted_user_id'] = Auth::user()->id;
        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#management');
    }
    public function postDelete($id)
    {
        Post::find($id)->delete();
        return redirect()->route('post#management');
    }

    public function postSearch(Request $request)
    {
        $validationRules = [
            'search' => 'required',
            'status' => 'required',
        ];
        Validator::make($request->all(), $validationRules)->validate();
        $search = $request->search;
        $post_datas = Post::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->where('status', 'like', '%' . $request->status . '%')
            ->paginate(10);
        return view('post/postmanagement', compact('search', 'post_datas'));
    }

    private function userValidationCheck($request)
    {
        $validationRules = [
            'title' => 'required|max:255',
            'description' => 'required',
        ];
        $validateMessage = [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255内である必要です。',
            'description.required' => '投稿内容を入力してください。'
        ];
        Validator::make($request->all(), $validationRules, $validateMessage)->validate();
    }
}

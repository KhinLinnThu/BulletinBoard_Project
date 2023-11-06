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
    /**
     * Display the specified resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postManagement()
    {
        if (Auth::user()->role === 1) {
            $post_datas = DB::table('posts')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/post_management', compact('post_datas'));
        } else {
            $post_datas = DB::table('posts')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->where('posts.created_user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/post_management', compact('post_datas'));
        }
    }
    /**
     * Display the post create form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCreate()
    {
        return view('post/post_create');
    }
    /**
     * Display the post confirm form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postConfirm(Request $request)
    {
        $this->postValidationCheck($request);
        $confirm_data = $request->all();
        return view('post/post_confirm', compact('confirm_data'));
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            ]
        );
        return redirect()->route('post_management');
    }
    /**
     * Display the post edit form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postEdit($id)
    {
        $post = Post::where('id', $id)->first()->toArray();
        return view('post/post_edit', compact('post'));
    }
    /**
     * Update resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postUpdate(Request $request)
    {
        $this->postValidationCheck($request);
        $id = $request->post_id;
        $updateData = request()->except(['_token', 'post_id']);
        $updateData['updated_user_id'] = Auth::user()->id;
        Post::where('id', $id)->update($updateData);
        return redirect()->route('post_management');
    }
    /**
     * Remove the specified resource from storage.
     * @param number $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete($id)
    {
        Post::find($id)->delete();
        return redirect()->route('post_management');
    }
    /**
     * Display the search result from post.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postSearch(Request $request)
    {
        $search = $request->search;
        if (Auth::user()->role === 1) {
            $post_datas = Post::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
                ->where('status', 'like', '%' . $request->status . '%')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/post_management', compact('post_datas'));
        } else {
            $post_datas = Post::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
                ->where('status', 'like', '%' . $request->status . '%')
                ->join('users as create_user', 'posts.created_user_id', '=', 'create_user.id')
                ->join('users as updated_user', 'posts.updated_user_id', '=', 'updated_user.id')
                ->select('posts.*', 'create_user.name as created_user_name', 'updated_user.name as updated_user_name')
                ->where('posts.created_user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('post/post_management', compact('search', 'post_datas'));
        }
    }

    private function postValidationCheck($request)
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

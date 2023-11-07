<?php

namespace App\Http\Controllers;

use App\Exports\ExportPost;
use App\Imports\ImportPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    /**
     * Display the Excel Input Form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importView()
    {
        return view('post/import');
    }
    /**
    * Input data to Post.
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function import(Request $request)
    {
        $validationRules = [
            'file' => 'required'
        ];
        $validateMessage = [
            'file.required' => 'Excelファイルを入力してください。',
        ];
        Validator::make($request->file(), $validationRules, $validateMessage)->validate();
        try {
            Excel::import(new ImportPost, $request->file('file'));
            return redirect()->route('post-management')->with('success', 'データ入力が成功しました。');
        } catch (\Throwable $th) {
            return back()->with('error', '何かの問題が発生しています。');
        }

    }
     /**
    * Export data from Post.
    * @param  \Illuminate\Http\Request  $request
    */
    public function exportPosts(Request $request)
    {
        return Excel::download(new ExportPost, 'posts.xlsx');
    }
}

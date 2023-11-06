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
    public function importView()
    {
        return view('post/import');
    }

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
            return redirect()->route('post_management')->with('success', 'データ入力が成功しました。');
        } catch (\Throwable $th) {
            return back()->with('error', '何かの問題が発生しています。');
        }

    }

    public function exportPosts(Request $request)
    {
        return Excel::download(new ExportPost, 'posts.xlsx');
    }
}

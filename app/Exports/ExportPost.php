<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPost implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'status',
            'created_user_id',
            'updated_user_id',
            'deleted_user_id',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
    }
    public function collection()
    {
        if(Auth::user()->role === 1) {
            return Post::all();
        }else {
            return Post::where('created_user_id', auth()->id())->get();
        }
    }
}

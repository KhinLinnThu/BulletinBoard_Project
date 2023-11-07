@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <p class="content-ttl">投稿管理</p>
        <div class="search-sec">
            <form action="{{ route('post-search') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="search-gp">
                        <input type="text" name="search" placeholder="検索..." value="{{ isset($search) ? $search : '' }}" class="form-control">
                    </div>
                    <div class="search-gp">
                        <select name="status" class="form-control">
                            <option value="">ステータス</option>
                            <option value="1">公開</option>
                            <option value="0">非公開</option>
                        </select>
                    </div>
                    <a href="{{ route('post-management') }}" class="btn-clear">クリア</a>
                    <button type="submit" class="btn-search">検索</button>
                </div>
            </form>
        </div>
        <div class="sec-two">
            <div class="search-result">
                <p>検査結果 : {{ $post_datas->total() }} 件</p>
                <p>
                    <a href="{{ route('import-view') }}" class="upload"><i class="fa fa-arrow-up"></i>アップロード</a>
                    <a href="{{ route('export-post') }}" class="download"><i class="fa fa-arrow-down"></i>ダウンロード</a>
                </p>
                <a href="{{ route('post-create') }}" class="create"><i class="fa fa-circle-plus"></i>新規作成</a>
            </div>
            @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif
            <table class="post-tb">
                <thead>
                    <th>タイトル</th>
                    <th>投稿内容</th>
                    <th>投稿ユーザー<br>投稿日</th>
                    <th>更新ユーザー<br>更新日</th>
                    <th>ステータス</th>
                    <th></th>
                </thead>
                @if ($post_datas->total() === 0)
                    <tbody>
                        <td colspan="7" class="py-5">データが登録されていません。</td>
                    </tbody>
                @else
                    <tbody>
                        @foreach ($post_datas as $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td><span>{{ $data->created_user_name }}</span><br>{{ \Carbon\Carbon::create($data->created_at)->format('Y/m/d') }}
                                </td>
                                <td><span>{{ $data->updated_user_name }}</span><br>{{ \Carbon\Carbon::create($data->updated_at)->format('Y/m/d') }}
                                </td>
                                @if ($data->status === 1)
                                    <td>公開</td>
                                @else
                                    <td>非公開</td>
                                @endif
                                <td>
                                    <a href="{{ route('post-edit', $data->id) }}" class="edit">編集</a>
                                    <button type="button" class="delete" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $data->id }}" name="delete_id">
                                        削除
                                    </button>

                                    <!-- Modal -->
                                    <form action="{{ route('post-delete', $data->id) }}" method="post">
                                        @csrf
                                        @method('Delete')

                                        <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">投稿を削除します。</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="cmn-btn cancel"
                                                            data-bs-dismiss="modal">キャンセル</button>
                                                        <button type="submit" class="cmn-btn confirm-delete">削除</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif

            </table>
            <div>
                {{ $post_datas->links() }}
            </div>
        </div>
    </div>
@endsection

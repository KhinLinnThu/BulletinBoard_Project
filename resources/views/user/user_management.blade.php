@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <p class="content-ttl">投稿管理</p>
        <div class="search-sec">
            <form action="{{ route('user_search') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="search-gp">
                        <input type="text" name="searchName" value="{{ old('searchName') }}" placeholder="氏名"
                            class="form-control">
                    </div>
                    <div class="search-gp">
                        <input type="email" name="searchEmail" value="{{ old('searchEmail') }}" placeholder="メールアドレス"
                            class="form-control">
                    </div>
                    <div class="search-gp">
                        <select name="searchRole" value="{{ old('searchRole') }}" class="form-control">
                            <option value="">権限種別</option>
                            <option value="1">アドミン</option>
                            <option value="2">ユーザー</option>
                        </select>
                    </div>
                    <div class="search-gp">
                        <input type="date" name="from_date" value="{{ old('from_date') }}" placeholder="作成日"
                            class="form-control">~
                    </div>
                    <div class="search-gp">
                        <input type="date" name="to_date" value="{{ old('to_date') }}" placeholder="作成日"
                            class="form-control">
                    </div>
                    <a href="{{ route('user_management') }}" class="btn-clear">クリア</a>
                    <button type="submit" class="btn-search mt-5">検索</button>
                </div>
            </form>
        </div>
        <div class="sec-two">
            <div class="search-result">
                <p>検査結果 : {{ $user_datas->total() }} 件</p>
                <div class="user-result">
                    <button type="button" class="select-user" id="deleteallrecord" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" name="delete_id">
                        選択したユーザを削除
                    </button>
                    <a href="{{ route('user_create') }}" class="create"><i class="fa fa-circle-plus"></i>新規作成</a>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('user_delete') }}" method="post">
                @csrf
                @method('Delete')
                <table class="user-tb">
                    <thead>
                        <th><input type="checkbox" name="" id="select_all_id"></th>
                        <th>
                            <span>氏名</span>
                            <hr>
                            <span>メールアドレス</span>
                        </th>
                        <th>
                            <span>生年月日</span>
                            <hr>
                            <span>携帯電話</span>
                        </th>
                        <th>住所</th>
                        <th>
                            <span>権限種別</span>
                            <hr>
                            <span>作成者</span>
                        </th>
                        <th>
                            <span>作成日</span>
                            <hr>
                            <span>更新日</span>
                        </th>
                        <th></th>
                    </thead>
                    @if ($user_datas->total() === 0)
                        <tbody>
                            <td colspan="7" class="py-5">データが登録されていません。</td>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($user_datas as $data)
                                <tr id="sid{{ $data->id }}">
                                    <td>
                                        <input type="checkbox" name="ids[{{ $data->id }}]" class="checked_id"
                                            value="{{ $data->id }}">
                                    </td>
                                    <td>
                                        <span>{{ $data->name }}</span>
                                        <hr>
                                        <span>{{ $data->email }}</span>
                                    </td>
                                    <td>
                                        <span>{{ Carbon\Carbon::parse($data->birthday)->format('d/m/Y') }}</span>
                                        <hr>
                                        <span>{{ $data->phone }}</span>
                                    </td>
                                    <td>{{ $data->address }}</td>
                                    <td>

                                        @if ($data->role === 1)
                                            <span>アドミン</span>
                                        @else
                                            <span>ユーザー</span>
                                        @endif
                                        <hr>
                                        <span>{{ $data->created_user_name }}</span>
                                    </td>
                                    <td>
                                        <span>{{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</span>
                                        <hr>
                                        <span>{{ Carbon\Carbon::parse($data->updated_at)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user_edit', $data->id) }}" class="edit">編集</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif

                </table>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">選択したユーザを削除します。</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="cmn-btn cancel" data-bs-dismiss="modal">キャンセル</button>
                                <button type="submit" class="cmn-btn confirm-delete">削除</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                {{ $user_datas->links() }}
            </div>
        </div>
    </div>
@endsection

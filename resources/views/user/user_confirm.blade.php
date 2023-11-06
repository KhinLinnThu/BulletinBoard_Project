@extends('layouts.app')
@section('content')
<div class="sec-content confirm-page">
    <p class="content-ttl">ユーザー情報新規作成</p>

    <form action="{{ route('user_complete') }}" method="POST" enctype="multipart/form-data" class="form">
      @csrf
        <table class="create-tb">
            <tr>
                <td><label for="name">氏名</label></td>
                <td>
                    <input type="text" name="name" value="{{ $user_datas['name'] }}" readonly>
                </td>
            </tr>
            <tr>
                <td><label for="email">メールアドレス</label></td>
                <td>
                    <input type="email" name="email" value="{{ $user_datas['email'] }}" readonly>
                </td>
            </tr>
            <tr>
                <td><label for="role">権限種別</label></td>
                <td>
                    <input type="text" name="role" value="{{ $user_datas['role'] }}" readonly>
                </td>
            </tr>
            <tr>
                <td><label for="birthday">生年月日</label></td>
                <td><input type="text" name="birthday" value="{{ $user_datas['birthday'] }}" readonly></td>
            </tr>
            <tr>
                <td><label for="">携帯電話番号</label></td>
                <td><input type="text" name="phone" value="{{ $user_datas['phone'] }}" readonly></td>
            </tr>
            <tr>
                <td><label for="address">住所</label></td>
                <td><input type="text" name="address" value="{{ $user_datas['address'] }}" readonly></td>
            </tr>
            <tr>
                <td><label for="profile">プロフィール</label></td>
                <td>
                    <img src="{{ $user_datas['profile'] }}" alt="profile" class="img-thumbnail">
                    <input type="hidden" name="profile" value="{{$fileName}}" readonly>
                </td>
            </tr>
            <tr>
                <td><label for="password">パスワード</label></td>
                <td><input type="password" name="password" value="{{ $user_datas['password'] }}" readonly></td>
            </tr>
        </table>
        <a href="{{ url()->previous() }}" class="cmn-btn reset-btn">クリア</a>
        <button type="submit" class="cmn-btn confirm-btn">登録</button>
    </form>
</div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <p class="content-ttl">ユーザー情報新規更新</p>
        <form action="{{ route('user_update') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            <table class="create-tb">
                <tr>
                    <td><label for="name">氏名</label></td>
                    <td>
                        <input type="text" name="name" placeholder="山田金太郎" value="{{ old('name', $user['name']) }}">
                        @error('name')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="email">メールアドレス</label></td>
                    <td>
                        <input type="email" name="email" placeholder="yamada@gmail.com"
                            value="{{ old('email', $user['email']) }}">
                        @error('email')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="role">権限種別</label></td>
                    <td>
                        <select name="role">
                            <option value="{{ old('role', $user['role']) }}">
                                @if ($user['role'] === 1)
                                    アドミン
                                @else
                                    ユーザー
                                @endif
                            </option>
                            <option value="1">アドミン</option>
                            <option value="2">ユーザー</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="birthday">生年月日</label></td>
                    <td><input type="text" name="birthday" placeholder="1980/12/11"
                            value="{{ old('birthday', $user['birthday']) }}">
                        @error('birthday')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="">携帯電話番号</label></td>
                    <td><input type="text" name="phone" placeholder="09-1234-2121"
                            value="{{ old('phone', $user['phone']) }}"></td>
                </tr>
                <tr>
                    <td><label for="address">住所</label></td>
                    <td><input type="text" name="address" placeholder="xxxxxxxxxxx"
                            value="{{ old('address', $user['address']) }}"></td>
                </tr>
                <tr>
                    <td><label for="profile">プロフィール</label></td>
                    <td>
                        <img src="{{ $user['profile'] }}" alt="profile" class="img-thumbnail"><br>
                        {{-- <input type="hidden" name="old_profile" value="{{ $user['profile'] }}"> --}}
                        <input type="file" name="profile">
                        @error('profile')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
            </table>
            <button type="reset" class="cmn-btn reset-btn">クリア</button>
            <button type="submit" class="cmn-btn confirm-btn">更新</button>
        </form>
    </div>
@endsection

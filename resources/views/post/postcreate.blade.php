@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <p class="content-ttl">新規投稿</p>
        <form action={{ route('post#confirm') }} method="POST" enctype="multipart/form-data" class="form">
          @csrf
            <table class="create-tb">
                <tr>
                    <td><label for="name">投稿タイトル</label></td>
                    <td>
                        <input type="text" name="title" placeholder="日本について" value="{{ old('title')}}">
                        @error('title')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="description">投稿内容</label></td>
                    <td>
                        <textarea type="text" name="description" placeholder="xxxxxxxxxxxxxxx" rows="4" cols="50">{{ old('description')}}</textarea>
                        @error('description')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="authority">公開ステータス</label></td>
                    <td>
                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input" name="status" value="1" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                        </div>
                    </td>
                </tr>
            </table>
            <button type="reset" class="cmn-btn reset-btn">クリア</button>
            <button type="submit" class="cmn-btn confirm-btn">確認</button>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('content')
<div class="card w-50 center top">
    <p class="mt-5 jp-ttl">社内OJT</p>
    <p class="eng-ttl">Bulletin Board</p>
    <div class="mt-4">
        メールアドレス宛にパスワードを送信しました。
    </div>
    <a href="{{ route('login') }}"  class="btn btn-primary mail-complete">ログイン画面へ</a></button>
</div>
@endsection

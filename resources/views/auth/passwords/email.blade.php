@extends('layouts.app')
@section('content')
    <div class="container top">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card center">
                    <p class="mt-5 jp-ttl">社内OJT</p>
                    <p class="eng-ttl">Bulletin Board</p>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}" class="form">
                            @csrf
                            <div class="form-group mt-4">
                                <input type="email" class="form-control" placeholder="パスワードリセットするメールアドレスを入力してください。"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" value="パスワードリセット" class="btn btn-primary w-100 mt-4 login-btn">
                            <a href="{{ route('login') }}" class="forget-password">戻る</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

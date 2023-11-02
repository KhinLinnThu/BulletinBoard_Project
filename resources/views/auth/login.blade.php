@extends('layouts.app')
@section('content')
    <div class="container top">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <p class="mt-5 jp-ttl center">社内OJT</p>
                    <p class="eng-ttl center">Bulletin Board</p>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" class="form">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="メールアドレス" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="error-msg d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <input type="password" class="form-control" placeholder="パスワード" name="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class="error-msg d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" value="ログイン" class="btn btn-primary w-100 mt-4 login-btn">
                            <div class="row mt-3">
                                <div class="col-md-6 offset-md-4">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link forget-password" href="{{ route('password.request') }}">
                                            パスワードを忘れる方はこちらへ
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

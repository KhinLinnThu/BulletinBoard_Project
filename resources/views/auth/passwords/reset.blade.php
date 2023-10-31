@extends('layouts.app')

@section('content')
    <div class="container center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card top">
                    <p class="mt-5 jp-ttl">社内OJT</p>
                    <p class="eng-ttl">Bulletin Board</p>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}" class="form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row mb-3">
                                <input type="email" class="form-control" placeholder="メールアドレス" name="email"
                                    value="{{ $email ?? old('email') }}" autocomplete="email" required>
                                @error('email')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-3"><input type="password" name="password" id="new_password"
                                    class="form-control" value="{{ old('password') }}" placeholder="新しいパスワード"
                                    autocomplete="new-password" required>
                                @error('password')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" value="{{ old('password_confirmation') }}" placeholder="新しいパスワード確認"
                                    autocomplete="new-password" required>
                                @error('password_confirmation')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" value="パスワードリセット" class="btn btn-primary w-100 mt-4 login-btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

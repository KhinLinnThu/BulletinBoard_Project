@extends('layouts.app')

@section('content')
    <div class="container top">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card center">
                    <p class="mt-5 jp-ttl">社内OJT</p>
                    <p class="eng-ttl">Bulletin Board</p>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="form">
                            @csrf

                            {{-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                            <div class="form-group mt-4">
                                <input type="email" class="form-control" placeholder="パスワードリセットするメールアドレスを入力してください。"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    パスワードリセット
                                </button>
                            </div>
                        </div> --}}
                            <input type="submit" value="パスワードリセット" class="btn btn-primary w-100 mt-4 login-btn">
                            <a href="{{ route('login') }}" class="forget-password">戻る</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

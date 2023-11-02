@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <div class="card w-50 center top">
            <p class="mt-5 jp-ttl">パスワード変更</p>
            <p class="eng-ttl">Bulletin Board</p>
            <form method="POST" action="{{ route('password#change') }}" class="form">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="current_password" class="d-block text-start">現在のパスワード</label>
                    <input type="password" name="current_password" id="current_password" class="form-control"
                        value="{{ old('current_password') }}">
                    @error('current_password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password" class="d-block text-start">新しいパスワード</label>
                    <input type="password" name="new_password" id="new_password" class="form-control"
                        value="{{ old('new_password') }}">
                    @error('new_password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation" class="d-block text-start">新しいパスワード確認</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="form-control" value="{{ old('new_password_confirmation') }}">
                    @error('new_password_confirmation')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <input type="submit" class="btn btn-primary w-100 mt-4 login-btn" value="変更">
            </form>
        </div>
    </div>
@endsection

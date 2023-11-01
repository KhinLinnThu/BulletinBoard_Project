@extends('layouts.app')

@section('content')
    <div class="container top">
        <div class="row align-items-center h-75">
            <div class="col-5 mx-auto">
                <div class="card-body d-flex flex-column align-items-center">
                    <form action="" method="GET" class="d-flex flex-column justify-content-center gap-3 mb-3 w-100 text-center">
                        @csrf
                        <label class="d-block error-ttl"><span>404 (Not Found)</span></label>
                        <p class="error-txt">ページが見つかりません。<br>お手数ですが、再度やり直しください。</p>
                        <a href="{{ route('login') }}" type="submit" class="btn cmn-btn ">ログイン画面へ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container top">
        <div class="row align-items-center h-75">
            <div class="col-5 mx-auto">
                <div class="card-body d-flex flex-column align-items-center">
                    <form action="" method="GET" class="d-flex flex-column justify-content-center gap-3 mb-3 w-100 text-center">
                        @csrf
                        <label class="d-block error-ttl"><span>503 (メンテナンス中)</span></label>
                        <p class="error-txt">ご利用の皆様にはご迷惑をおかけし申し訳ございません。<br>メンテナンス終了までしばらくお待ちください。</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="sec-content">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-md-9 col-lg-7 col-xl-5">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex text-black">
                            <div class="flex-shrink-0">
                                @if ($user->profile)
                                <img src="{{ $user->profile }}" alt="profile" class="img-fluid profile-img">
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-5 user-profile">
                                <h2 class="mb-4">User Profile</h2>
                                <p class="mb-2 pb-1"> <b>Name :</b> {{ Auth::user()->name }}</p>
                                <p class="mb-2 pb-1"><b>Email :</b> {{ Auth::user()->email }}</p>
                                <p class="mb-2 pb-1"><b>Type :</b>
                                    @if (Auth::user()->role === 1)
                                        <span>アドミン</span>
                                    @else
                                        <span>ユーザー</span>
                                    @endif
                                </p>
                                <p class="mb-2 pb-1"><b>Phone :</b> {{ Auth::user()->phone }}</p>
                                <p class="mb-2 pb-1"><b>Address :</b> {{ Auth::user()->address }}
                                </p>
                                <a href="{{ route('user#edit', Auth::user()->id) }}" class="cmn-btn mt-3">編集</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="sec-content">
    <p class="content-ttl">ホームページ</p>
    <div class="post-card-list">
        <div class="post-card @if (auth()->user()->role === 2) d-none @endif">
            <p class="post-ttl">ユーザー数</p>
            <p class="post-count">{{ $userCount }}<span>件</span></p>
            <a href="{{ route('user_management') }}" class="management">ユーザー管理へ</a>
        </div>
        <div class="post-card">
            <p class="post-ttl">投稿数</p>
            <p class="post-count">{{ $postCount }}<span>件</span></p>
            <a href="{{ route('post_management') }}" class="management">投稿管理へ</a>
        </div>
        <div class="post-card">
            <p class="post-ttl">自分の投稿数</p>
            <p class="post-count">{{ $userPostCount }}<span>件</span></p>
            <a href="{{ route('post_create') }}" class="management">新規投稿</a>
        </div>
    </div>
</div>
@endsection

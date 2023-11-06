@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card center">
                    <p class="eng-ttl mt-5">Excel Import</p>
                    <div class="card-body py-5">
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data" class="form">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="file" class="form-control">
                                @error('file')
                                    <span class="error-msg d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" value="import" class="btn btn-primary w-100 mt-4 login-btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

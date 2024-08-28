@extends('auth.layout.main')

@section('auth-content')
    <div class="login-box">
        <div class="row text-center justify-content-center">
            <h1 class="font-weight-bold mb-4">{{ config('app.name') }}</h1>
        </div>
        <div class="card">
            <div class="card-body login-card-body rounded-lg">
                <p class="login-box-msg">Login to continue</p>
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="d-flex flex-row align-items-start">
                            <i class="fas fa-ban mr-2"></i>
                            <p class="m-0">{{ session('error') }}</p>
                        </div>
                    </div>
                @elseif(session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="d-flex flex-row align-items-start">
                            <i class="fas fa-check mr-2 mt-1"></i>
                            <p class="m-0">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                <form action="{{ route('auth.authenticate') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@example.com" name="email" id="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password" name="password" id="password" value="{{ old('password') }}">
                        @error('password')
                        <div class="invalid-feedback mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                    <div class="row d-flex flex-column justify-content-center align-items-center mt-2">
                        <p class="m-0">Don't have an account? <a href="{{ route("auth.register") }}">register here</a>
                        </p>
                    </div>
                    <div class="row d-flex flex-column justify-content-center align-items-center mt-2">
                        <p class="m-0"><a href="{{ route("home.index") }}">Back to home</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


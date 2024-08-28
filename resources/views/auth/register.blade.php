@extends('auth.layout.main')

@section('auth-content')
    <div class="login-box">
        <div class="row text-center justify-content-center">
            <h1 class="font-weight-bold mb-4">{{ config('app.name') }}</h1>
        </div>
        <div class="card">
            <div class="card-body login-card-body rounded-lg">
                <p class="login-box-msg">Login to continue</p>
                <form action="{{ route('auth.doRegister') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Email</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Your name" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
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
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                    <div class="row d-flex flex-column justify-content-center align-items-center mt-2">
                        <p class="m-0">Already have an account? <a href="{{ route("auth.login") }}">login here</a>
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


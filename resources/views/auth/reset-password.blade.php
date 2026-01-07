@extends('auth.layout')

@section('title', 'Reset Password')

@section('content')
    <h1>Reset Password</h1>
    <p class="text-muted">Enter your new password below</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $request->email) }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
            @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>

    <div class="auth-link">
        <p>Remember your password? <a href="{{ route('login') }}">Sign in here</a></p>
    </div>
@endsection

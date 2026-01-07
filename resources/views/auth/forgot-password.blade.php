@extends('auth.layout')

@section('title', 'Forgot Password')

@section('content')
    <h1>Forgot Password?</h1>
    <p class="text-muted">No problem. Just let us know your email address and we will email you a password reset link.</p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
    </form>

    <div class="auth-link">
        <p>Remembered your password? <a href="{{ route('login') }}">Sign in here</a></p>
    </div>
@endsection

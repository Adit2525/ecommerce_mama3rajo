@extends('auth.layout')

@section('title', 'Verify Email')

@section('content')
    <h1>Verify Your Email</h1>
    <p class="text-muted">We've sent a verification link to your email. Please check your inbox.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-secondary w-100">Log Out</button>
    </form>

    <div class="auth-link mt-3">
        <p><small>If you didn't receive the email, check your spam folder or <a href="#" onclick="document.querySelector('form').submit();">resend it</a></small></p>
    </div>
@endsection

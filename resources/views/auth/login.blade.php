@extends('layouts.store')

@section('content')
<div style="display: flex; min-height: calc(100vh - 80px);">
    
    <!-- Left Side - Image -->
    <div style="flex: 1; display: none; position: relative; background: #f8e1dc;" class="login-image">
        <img src="{{ asset('images/login-bg.png') }}" alt="MAMA3RAJO Fashion" style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
        <div style="position: absolute; bottom: 40px; left: 0; right: 0; text-align: center;">
            <p style="font-size: 18px; font-style: italic; color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Fashion for Every Woman</p>
        </div>
    </div>
    
    <!-- Right Side - Form -->
    <div style="flex: 1; display: flex; flex-direction: column; min-width: 400px; background: #fff;">
        
        <!-- Form Container -->
        <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px;">
            <div style="width: 100%; max-width: 400px;">
                
                <!-- Title -->
                <h1 style="font-size: 32px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 48px 0; color: #111;">
                    Selamat Datang kembali!
                </h1>
                
                <!-- Session Status -->
                @if (session('status'))
                    <div style="background: #d1fae5; color: #047857; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 14px;">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Alamat email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Password -->
                    <div style="margin-bottom: 32px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Kata sandi
                        </label>
                        <input type="password" name="password" required
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" style="background: #d4a5a5; color: #fff; border: none; padding: 16px 40px; font-size: 14px; font-weight: 600; letter-spacing: 1px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        MASUK
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
                
                <!-- Forgot Password -->
                <div style="margin-top: 32px;">
                    <a href="{{ route('password.request') }}" style="font-size: 14px; color: #111; text-decoration: underline; text-underline-offset: 4px;">
                        Lupa kata sandi Anda
                    </a>
                </div>
                
                <!-- Register Section -->
                <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid #eee;">
                    <h3 style="font-size: 20px; font-weight: 600; margin: 0 0 16px 0; color: #111;">
                        Belum punya akun?
                    </h3>
                    <a href="{{ route('register') }}" style="font-size: 14px; color: #111; text-decoration: underline; text-underline-offset: 4px;">
                        Buat akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 768px) {
        .login-image {
            display: block !important;
        }
    }
</style>
@endsection

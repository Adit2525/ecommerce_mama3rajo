@extends('layouts.store')

@section('content')
<div style="display: flex; min-height: calc(100vh - 80px);">
    
    <!-- Left Side - Image -->
    <div style="flex: 1; display: none; position: relative; background: #f5f5f5;" class="login-image">
        @if(file_exists(public_path('images/register-bg.jpg')))
            <img src="{{ asset('images/register-bg.jpg') }}" alt="Register" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #e8c4bc 0%, #f8e1dc 100%); display: flex; align-items: center; justify-content: center;">
                <div style="text-align: center; color: #8b6f66;">
                    <svg style="width: 80px; height: 80px; margin-bottom: 20px; opacity: 0.5;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                    <p style="font-size: 18px; font-style: italic;">Join Our Community</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Right Side - Form -->
    <div style="flex: 1; display: flex; flex-direction: column; min-width: 400px; background: #fff;">
        
        <!-- Form Container -->
        <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; overflow-y: auto;">
            <div style="width: 100%; max-width: 400px;">
                
                <!-- Title -->
                <h1 style="font-size: 32px; font-family: 'Playfair Display', serif; font-weight: 400; margin: 0 0 16px 0; color: #111;">
                    Buat Akun Baru
                </h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0 0 40px 0;">
                    Bergabunglah dengan kami dan nikmati pengalaman berbelanja terbaik
                </p>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0 0 4px 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Nama lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Email -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Alamat email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Password -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Kata sandi
                        </label>
                        <input type="password" name="password" required
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Confirm Password -->
                    <div style="margin-bottom: 32px;">
                        <label style="display: block; font-size: 14px; color: #111; margin-bottom: 8px; text-decoration: underline; text-underline-offset: 4px;">
                            Konfirmasi kata sandi
                        </label>
                        <input type="password" name="password_confirmation" required
                               style="width: 100%; border: none; border-bottom: 1px solid #ccc; padding: 12px 0; font-size: 16px; background: transparent; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderBottomColor='#000'" 
                               onblur="this.style.borderBottomColor='#ccc'">
                    </div>
                    
                    <!-- Terms -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                            <input type="checkbox" name="terms" required style="width: 18px; height: 18px; margin-top: 2px; accent-color: #d4a5a5;">
                            <span style="font-size: 13px; color: #6b7280; line-height: 1.5;">
                                Saya menyetujui <a href="#" style="color: #111; text-decoration: underline;">Syarat & Ketentuan</a> dan <a href="#" style="color: #111; text-decoration: underline;">Kebijakan Privasi</a>
                            </span>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" style="background: #d4a5a5; color: #fff; border: none; padding: 16px 40px; font-size: 14px; font-weight: 600; letter-spacing: 1px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        DAFTAR
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
                
                <!-- Login Section -->
                <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid #eee;">
                    <h3 style="font-size: 20px; font-weight: 600; margin: 0 0 16px 0; color: #111;">
                        Sudah punya akun?
                    </h3>
                    <a href="{{ route('login') }}" style="font-size: 14px; color: #111; text-decoration: underline; text-underline-offset: 4px;">
                        Masuk ke akun Anda
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

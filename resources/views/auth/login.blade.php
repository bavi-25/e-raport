@extends('layouts.auth')
@section('title', 'E-Raport | Login')
@section('content')
<div class="card card-outline">
    <div class="card-header text-center">
        <div class="login-logo-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <a href="/" class="h1"><b>E-</b>Report</a>
        <p style="color: rgba(255,255,255,0.9); margin-top: 10px; font-size: 0.9rem;">
            Digital Report Information System
        </p>
    </div>
    <div class="card-body">

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <form action="{{ route('login.authenticate') }}" method="post" id="loginForm">
            @csrf

            {{-- Email --}}
            <div class="input-group mb-3">
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" required
                    autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="input-group mb-3">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password"
                    required>
                <div class="input-group-append">
                    <div class="input-group-text" style="cursor: pointer;" id="togglePassword">
                        <span class="fas fa-eye" id="eyeIcon"></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="row align-items-center mb-3">
                <div class="col-7">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary btn-block">
                        Log In
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center mt-4">
            {{--
            <p class="mb-2">
                <a href="{{ route('password.request') }}" style="color: #667eea; text-decoration: none;">
            <i class="fas fa-key"></i> Lupa Password?
            </a>
            </p>
            <p class="mb-0">
                <a href="{{ route('register') }}" style="color: #667eea; text-decoration: none;">
                    <i class="fas fa-user-plus"></i> Daftar Akun Baru
                </a>
            </p>
            --}}
            <div
                style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; color: #999; font-size: 0.85rem;">
                <i class="fas fa-shield-alt"></i> Secure Login System
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        }
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
            });
        }
    });
</script>
@endsection
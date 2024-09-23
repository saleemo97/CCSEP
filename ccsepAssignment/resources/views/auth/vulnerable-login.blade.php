@extends('layouts.app')

@section('title', 'Vulnerable Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4 mt-5">
                <h3 class="text-center mb-4">{{ __('Vulnerable Login') }}</h3>
                <form method="POST" action="{{ url('/vulnerable-login') }}" id="vulnerableLoginForm">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger btn-block">
                            {{ __('Login (Vulnerable)') }}
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="mt-3 text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <span>Don't have an account?</span> 
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            {{ __('Register') }}
                        </a>
                    </div>

                    <!-- Add Secure Login Button -->
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            {{ __('Go to Secure Login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('vulnerableLoginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission for logging
        
        // Capture form data
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Log to console
        console.log("Email:", email);
        console.log("Password:", password);

        // Allow the form to submit after logging
        this.submit();
    });
</script>
@endsection

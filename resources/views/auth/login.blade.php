<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Taxila Academy</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('CSS/auth.css') }}">
</head>

<body>

    <div class="auth-container">
        <!-- Left Side - Image/Branding -->
        <div class="auth-left">
            <div class="auth-overlay"></div>
            <div class="auth-content">
                <a href="/" class="back-home">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
                <div class="branding">
                    <h1 class="brand-title">
                        <span class="brand-gradient">Taxila</span> Academy
                    </h1>
                    <p class="brand-subtitle">Welcome back! Continue your learning journey with us.</p>
                </div>
                <div class="auth-features">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Access 50+ Premium Courses</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Learn at Your Own Pace</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Get Certified on Completion</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <h2 class="form-title">Welcome Back!</h2>
                    <p class="form-subtitle">Sign in to continue to your account</p>
                </div>

                <!-- social login -->
                <a href="{{ route('socialRedirect', 'google') }}" class="btn-social btn-google mb-2">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M19.8 10.2273C19.8 9.51821 19.7364 8.83639 19.6182 8.18185H10V12.05H15.5818C15.3273 13.3 14.5636 14.3591 13.4182 15.0682V17.5773H16.7364C18.6091 15.8364 19.8 13.2727 19.8 10.2273Z"
                            fill="#4285F4" />
                        <path
                            d="M10 20C12.7 20 14.9636 19.1045 16.7364 17.5773L13.4182 15.0682C12.4727 15.6682 11.2909 16.0227 10 16.0227C7.39545 16.0227 5.19091 14.2636 4.35909 11.9H0.927273V14.4909C2.69091 18.0091 6.09091 20 10 20Z"
                            fill="#34A853" />
                        <path
                            d="M4.35909 11.9C4.14091 11.3 4.01818 10.6591 4.01818 10C4.01818 9.34091 4.14091 8.7 4.35909 8.1V5.50909H0.927273C0.263636 6.82727 -0.1 8.37273 -0.1 10C-0.1 11.6273 0.263636 13.1727 0.927273 14.4909L4.35909 11.9Z"
                            fill="#FBBC04" />
                        <path
                            d="M10 3.97727C11.4091 3.97727 12.6682 4.48182 13.6636 5.43182L16.5909 2.50455C14.9591 0.990909 12.6955 0 10 0C6.09091 0 2.69091 1.99091 0.927273 5.50909L4.35909 8.1C5.19091 5.73636 7.39545 3.97727 10 3.97727Z"
                            fill="#EA4335" />
                    </svg>
                    Continue with Google
                </a>

                <a href="{{ route('socialRedirect', 'github') }}" class="btn-social btn-github">
                    <i class="bi bi-github"></i>
                    Continue with GitHub
                </a>

                <div class="divider">
                    <span>OR</span>
                </div>

                <!-- Login Form -->
                <form action="" method="POST" class="auth-form" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="you@example.com" required value="{{ old('email') }}">
                        </div>

                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password" required>
                            <button type="button" class="toggle-password" data-target="password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        <a href="/forgot-password" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth">
                        Sign In
                        <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>


                <div class="auth-footer">
                    <p>Don't have an account? <a href="/register" class="auth-link">Create Account</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('JS/auth.js') }}"></script>
</body>

</html>

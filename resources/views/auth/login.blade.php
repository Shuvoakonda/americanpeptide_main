@extends('frontend.layouts.app')

@section('title', 'Login - MyShop')

@section('content')
  <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="cart-header-wrapper mb-4">
                    <div class="d-flex align-items-center position-relative">
                        <!-- Icon and Title with underline effect -->
                        <h2 class="mb-0 pe-4 d-flex align-items-center">
                            <span class="user-icon me-2">
                                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="">
                                    <path
                                        d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                        stroke="#00687a" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M20 21C20 18.8783 19.1571 16.8434 17.6569 15.3431C16.1566 13.8429 14.1217 13 12 13C9.87827 13 7.84344 13.8429 6.34315 15.3431C4.84285 16.8434 4 18.8783 4 21"
                                        stroke="#00687a" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="position-relative">
                                <span class="title-text">Welcome to American Peptides</span>
                                <span class="title-underline"></span>
                            </span>
                        </h2>

                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="login-email">Email</label>
                     <input 
                     type="email" 
                     class="form-control @error('email') is-invalid @enderror"               
                     id="login-email" 
                     name="email" 
                     value="{{ old('email') }}" 
                     placeholder="name@example.com"               
                     required autocomplete="email" 
                     autofocus>
                </div>

                <div class="form-group">
                    <label for="login-password">Password</label>
                    <div class="input-group password-toggle">
                        <input type="password" id="login-password" class="form-control"
                            placeholder="Enter your password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <a href="#forgot-password" class="forgot-link">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="auth-btn">Sign In</button>

                <div class="auth-divider">
                    <span>or</span>
                </div>

                <button type="button" class="social-btn google-btn">
                    <i class="bi bi-google"></i> Continue with Google
                </button>

                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('register') }}">Create one</a>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('.password-toggle').querySelector('input');
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('bi-eye-slash', 'bi-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('bi-eye', 'bi-eye-slash');
                    }
                });
            });
        });
    </script>
    @endpush

     <style>
        .cart-header-wrapper {
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(172, 118, 48, 0.2);
        }

        .cart-icon {
            transition: transform 0.3s ease;
        }

        .cart-icon:hover {
            transform: translateY(-3px);
        }

        h2 {
            font-weight: 700;
            font-size: 1.75rem;
            color: #333;
            position: relative;
        }

        .title-text {
            position: relative;
            z-index: 2;
        }

        .title-underline {
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(172, 118, 48, 0.2);
            z-index: 1;
            transition: all 0.7s ease;
        }

        h2:hover .title-underline {
            height: 40px;
            background: rgba(172, 118, 48, 0.3);
        }



        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }

            .cart-header-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }

            .ms-auto {
                margin-top: 10px;
                margin-left: 0 !important;
                width: 100%;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
@endsection

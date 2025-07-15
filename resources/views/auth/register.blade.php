@extends('frontend.layouts.app')

@section('title', 'Register - MyShop')

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
                                        stroke="#C4F6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M20 21C20 18.8783 19.1571 16.8434 17.6569 15.3431C16.1566 13.8429 14.1217 13 12 13C9.87827 13 7.84344 13.8429 6.34315 15.3431C4.84285 16.8434 4 18.8783 4 21"
                                        stroke="#C4F6FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="position-relative">
                                <span class="title-text">Create Account<br>Get started with American Peptides !</span>
                                <span class="title-underline"></span>
                            </span>
                        </h2>

                    </div>
                </div>
            </div>

            <form class="auth-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-fname">First Name</label>
                            <input type="text" id="register-fname" class="form-control" placeholder="John">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-lname">Last Name</label>
                            <input type="text" id="register-lname" class="form-control" placeholder="Doe">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" class="form-control" placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <div class="input-group password-toggle">
                        <input type="password" id="register-password" class="form-control" placeholder="Create password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <small class="form-text">Minimum 8 characters</small>
                </div>

                <div class="form-group">
                    <label for="register-confirm">Confirm Password</label>
                    <div class="input-group password-toggle">
                        <input type="password" id="register-confirm" class="form-control" placeholder="Confirm password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms-agree">
                    <label class="form-check-label" for="terms-agree">
                        I agree to the <a href="#terms">Terms of Service</a> and <a href="#privacy">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="auth-btn">Create Account</button>

                <div class="auth-footer">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.toggle-password').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.closest('.password-toggle').querySelector('input');
                        const icon = this.querySelector('i');

                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('bi-eye');
                            icon.classList.add('bi-eye-slash');
                        }
                    });
                });
            });
        </script>
    @endpush

    <style>
        .title-underline {
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(172, 118, 48, 0.2);
            z-index: 1;
            transition: all cubic-bezier(0.165, 0.84, 0.44, 1) ease;
        }

        h2:hover .title-underline {
            height: 40px;
            background: rgba(172, 118, 48, 0.3);
        }

        .password-toggle {
            position: relative;
        }

        .toggle-password {
            border-color: var(--border-color);
            background-color: white;
            border-left: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .toggle-password:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        .input-group>.form-control:not(:first-child),
        .input-group>.toggle-password:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group>.form-control:not(:last-child),
        .input-group>.toggle-password:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Fix border between input and button */
        .input-group>.form-control+.toggle-password {
            border-left: 1px solid var(--border-color);
            margin-left: -1px;
        }
    </style>
@endsection

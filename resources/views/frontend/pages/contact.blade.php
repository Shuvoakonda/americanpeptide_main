@extends('frontend.layouts.app')

<style>
    .contact-form {
        background-color: #1a1a1a;
    }

    .contact-info {
        background: linear-gradient(135deg, var(--primary-color), #c89656);
        color: var(--card-bg);
    }

    .contact-form input::placeholder,
    .contact-form textarea::placeholder {
        color: #bbb;
    }

    .contact-form .form-control:focus {
        background-color: transparent;
        color: var(--card-bg);
        border-color: var(--primary-color);
        box-shadow: none;
    }

    .contact-form a {
        color: var(--price-color);
    }

    .contact-form button:hover {
        background-color: var(--primary-color);
        color: var(--card-bg);
    }

    @media (max-width: 768px) {

        .contact-form,
        .contact-info {
            padding: 2rem 1.5rem;
        }
    }
</style>

@section('title', 'Contact Us - Eterna Reads')

@section('content')




<!-- edit section -->
<section class="contact-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left: Form Section -->
            <div class="col-md-6 contact-form px-5 py-5 text-white">
                <div class="container px-5">
                    <h4 class="fw-bold" style="color: var(--primary-color);">Get in touch with us.</h4>
                    <p>You can email us directly at <a href="mailto:support@americanpeptides.com"
                            class="text-info">support@americanpeptides.com</a> or fill out the form below.</p>

                    <form action="{{ route('contact.store') }}" method="post">
                        <div class="mb-3">
                            <input type="text"
                                class="form-control bg-transparent border border-secondary text-white"
                                placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror form-control bg-transparent border border-secondary text-white"
                                placeholder="Enter Email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text"
                                class="form-control bg-transparent border border-secondary text-white"
                                placeholder="Subject">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control bg-transparent border border-secondary text-white" rows="4"
                                placeholder="Message..."></textarea>
                        </div>

                        <!-- Simulated captcha -->
                        <div class="mb-3 border border-secondary p-3 text-white small">
                            Please prove you are human by selecting the <span class="text-warning">truck</span>.<br>
                            <div class="mt-2">
                                <i class="fas fa-car me-2"></i>
                                <i class="fas fa-star me-2"></i>
                                <i class="fas fa-truck me-2" style="color: var(--primary-color);"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 rounded-pill mt-2 fw-bold"
                            style="color: var(--card-bg); border: 1px solid var(--primary-color); background-color: transparent;">
                            SUBMIT MESSAGE
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Contact Info Section -->
            <div class="col-md-6 contact-info px-5 py-5 text-white d-flex align-items-center">
                <div>
                    <h4 class="fw-bold">Customer service is our priority!</h4>
                    <p class="mt-3">At Core Peptides, customer satisfaction is not taken lightly. We will do
                        everything in our power to ensure that our customers are satisfied, even after products are
                        delivered.</p>

                    <p class="mt-4">
                        <strong>support@corepeptides.com</strong><br>
                        805-429-8132<br>
                        5401 S Kirkman Rd suite 310, Orlando FL 32819
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
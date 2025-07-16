@extends('frontend.layouts.app')

@section('title', 'Wholesaler Register')
<style>
    .auth-container-wholesaler {
        display: flex;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .auth-card-wholesaler {
        max-width: 1000px;
        width: 100%;
        background: #fff;
        padding: 2rem 3rem;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: 0.2s ease-in-out;
    }

    .form-control:focus {
        border-color: #6a64bd;
        box-shadow: 0 0 0 0.2rem rgba(106, 100, 189, 0.2);
    }

    label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .auth-btn {
        background-color: #6a64bd;
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.2s;
    }

    .auth-btn:hover {
        background-color: #5b54a8;
    }
</style>
@section('content')
    <div class="auth-container-wholesaler">
        <div class="auth-card-wholesaler">
            <h2 class="mb-4">Register as a Wholesaler</h2>
            <form class="auth-form" action="{{ route('register.wholesaler.submit') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input name="first_name" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input name="last_name" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name (required)</label>
                            <input name="company_name" type="text" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Contact Number (required)</label>
                            <input name="contact_number" type="text" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Tax/VAT ID (required)</label>
                            <input name="tax_id" type="text" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Website (optional)</label>
                            <input name="website" type="url" class="form-control">
                        </div>

                    </div>

                </div>
                <button type="submit" class="auth-btn mt-3">Register as Wholesaler</button>
            </form>

        </div>
    </div>
@endsection

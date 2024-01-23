@extends('front.layout.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <h1 class="h3">Register</h1>
                        <span id="success">
                        </span>
                        <form action="" id="registrationForm" name="registrationForm">
                            <div class="mb-3">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Name">
                                <small class="" id="er-name"></small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter Email">
                                <small id="er-email"></small>

                            </div>
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Password">
                                <small id="er-password"></small>

                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="Enter Password">
                                <small id="er-cpassword"></small>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Register</button>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('comanJs')
<script>
    $(document).ready(function() {
        $('#registrationForm').submit(function(e) {
            e.preventDefault();
            // Reset previous error messages and styling
            $('.form-control').removeClass('is-invalid');
            $('small[id^="er-"]').html('');

            $.ajax({
                url: '{{ route('account.registrationProcess') }}',
                type: 'POST',
                data: $('#registrationForm').serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == false) {
                        var error = response.error;

                        // Display error messages and apply red border to input fields
                        if (error.hasOwnProperty('name')) {
                            $('#er-name').html(error.name);
                            $('#name').addClass('is-invalid');
                        }
                        if (error.hasOwnProperty('email')) {
                            $('#er-email').html(error.email);
                            $('#email').addClass('is-invalid');
                        }
                        if (error.hasOwnProperty('password')) {
                            $('#er-password').html(error.password);
                            $('#password').addClass('is-invalid');
                        }
                        if (error.hasOwnProperty('confirm_password')) {
                            $('#er-cpassword').html(error.confirm_password);
                            $('#confirm_password').addClass('is-invalid');
                        }
                    }
                    if (response.status == true) {
                        window.location.href='{{ route ("account.login")}}'
                    }
                }
            });
        });
    });
</script>

@endsection

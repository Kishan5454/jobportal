@extends('front.layout.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.account.message')
                    <div class="card border-0 shadow mb-4">
                        <form action="" id="updateUser" method="POST" name="updateUser">
                            @method('POST')
                            @csrf
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                               
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" id="name" name="name" placeholder="Enter Name"
                                        class="form-control" value="{{ $user->name }}">
                                    <small id="er-name"></small>

                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Email"
                                        class="form-control" value="{{ $user->email }}">
                                    <small id="er-email"></small>

                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation"
                                        class="form-control" value="{{ $user->designation }}">
                                    {{-- <small id="er-designation"></small> --}}

                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="text" name="mobile" placeholder="Mobile" id="mobile"
                                        class="form-control" value="{{ $user->mobile }}">
                                    {{-- <small id="er-mobile"></small> --}}

                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" placeholder="Old Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" placeholder="New Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" placeholder="Confirm Password" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="button" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('comanJs')
    <script>
        $('#updateUser').submit(function(e) {
            e.preventDefault();

            $('.form-control').removeClass('is-invalid');
            $('small[id^="er-"]').html('');
            
            $.ajax({
                url: '{{ route("account.updateUser") }}',
                type: 'POST',
                data: $('#updateUser').serializeArray(), // Remove the semicolon here
                dataType: 'json',
                success: function(data) {
                    if (data.status == false) {
                        var error = data.error;

                        // Display error messages and apply red border to input fields
                        if (error.hasOwnProperty('name')) {
                            $('#er-name').html(error.name);
                            $('#name').addClass('is-invalid');
                        }
                        if (error.hasOwnProperty('email')) {
                            $('#er-email').html(error.email);
                            $('#email').addClass('is-invalid');
                        }

                    }
                    if (data.status == true) {
                        window.location.href='{{ route ("account.profile")}}'
                    }
                }
            });
        });
    </script>
@endsection

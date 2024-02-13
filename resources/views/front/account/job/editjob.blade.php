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
                    <form action="" method="POST" id="UpdateJobPost" name="UpdateJobPost">
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Detail Upadte</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control" value="{{$job->title}}">
                                        <small class="text-danger" id="e-title"></small>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a catagory</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $catagory)
                                                    <option {{($job->catagory_id == $catagory->catagory_id)? 'selected' : ''}} value="{{ $catagory->catagory_id }}">{{ $catagory->cat_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger" id="e-category"></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="jobtype" id="jobtype">
                                            <option value="">Select a catagory</option>
                                            @if ($jobtypes->isNotEmpty())
                                                @foreach ($jobtypes as $jobtype)
                                                    <option {{($job->jobtype_id == $jobtype->jobtype_id)? 'selected' : ''}} value="{{ $jobtype->jobtype_id }}">{{ $jobtype->jobtype_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger" id="e-jobtype"></small>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            name="vacancy" class="form-control" value="{{$job->vacancy}}">
                                        <small class="text-danger" id="e-Vacancy"></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control" value="{{$job->salary}}">

                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control" value="{{$job->location}}">
                                        <small class="text-danger" id="e-location"></small>

                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description">{{$job->description}}"</textarea>
                                    <small class="text-danger" id="e-description"></small>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5"
                                        placeholder="Benefits" >{{$job->benifits}}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility" >{{$job->responsibility}}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualification" id="qualification" cols="5" rows="5"
                                        placeholder="Qualifications">{{$job->qualification}}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Experience <span class="req">*</span>
                                    </label>
                                    <select name="experience" id="experience" class="form-control">
                                        <option value="1"  {{ $job->experience == '1' ? 'selected' : '' }}>1 Year</option>
                                        <option value="2" {{ $job->experience == '2' ? 'selected' : '' }}>2 Year</option>
                                        <option value="3" {{ $job->experience == '3' ? 'selected' : '' }}>3 Year</option>
                                        <option value="4" {{ $job->experience == '4' ? 'selected' : '' }}>4 Year</option>
                                        <option value="5" {{ $job->experience == '5' ? 'selected' : '' }}>5 Year</option>
                                        <option value="6" {{ $job->experience == '6' ? 'selected' : '' }}>6 Year</option>
                                        <option value="7" {{ $job->experience == '7' ? 'selected' : '' }}>7 Year</option>
                                        <option value="8" {{ $job->experience == '8' ? 'selected' : '' }}>8 Year</option>
                                        <option value="9" {{ $job->experience == '9' ? 'selected' : '' }}>9 Year</option>
                                        <option value="10" {{ $job->experience == '10' ? 'selected' : '' }}>10 Year</option>
                                        <option value="10_plus" {{ $job->experience == '10_plus' ? 'selected' : '' }}>10+ Year</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keyword" id="keyword" name="keyword"
                                        class="form-control" value="{{$job->keyword}}">
                                </div>

                                <h3 class="fs-4 mb-1 mt-2 border-top pt-2">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            name="company_name" class="form-control" value="{{$job->company_name}}">
                                        <small class="text-danger" id="e-company_name"></small>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Company Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control" value="{{$job->company_location}}">

                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="company_website"
                                        name="company_website" class="form-control" value="{{$job->company_website}}">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('comanJs')
    <script>
        $('#UpdateJobPost').submit(function(e) {
            e.preventDefault();
            $('.text-danger').empty();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: '{{ route("account.UpdateJobPost",$job->id) }}',
                type: 'POST',
                data: $('#UpdateJobPost').serialize(),
                dataType: 'json',
                success: function(data) {
                    $("button[type='submit']").prop('disabled',false);

                    if (data.status == true) {
                        window.location.href = '{{ route("account.my_job") }}'
                    }

                    if (data.status == false) {
                        if (data.status == false) {
                            var error = data.error;
                            $.each(error, function(field, message) {
                                $('#e-' + field).html(message);
                            });
                        }
                    }
                }
            });
        });
    </script>
@endsection

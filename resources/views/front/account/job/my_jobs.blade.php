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
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('account.createjob') }}" class="btn btn-primary">Post a Job</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">

                                        @foreach ($jobs as $job)
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $job->title }}</div>
                                                    <div class="info1"> {{ $job->jobtype_name }} | {{ $job->location }}
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                                <td>130 Applications</td>
                                                <td>
                                                    @if ($job->status == 1)
                                                        <div class="job-status text-capitalize">active</div>
                                                    @else
                                                        <div class="job-status text-capitalize">Inactive</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="icon-link" href="job-detail.html">
                                                        <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <a class="icon-link" href="{{ route('account.editjob', $job->id) }}">
                                                        <i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    <a class="icon-link" onclick="deletejob({{ $job->id }})">
                                                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('comanJs')
    <script>
        //---------->  Delete Button Popup 
        function deletejob(jobid) {
            if (confirm('Are you sure want to delete!!')) {
                $.ajax({
                    url: "{{ route('account.deletejob') }}",
                    type: "POST",
                    data: {
                        jobid: jobid
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == true) {
                            window.location.href = '{{ route('account.my_job') }}';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while processing your request. Please try again later.');
                    }
                });
            }
        }
    </script>
@endsection

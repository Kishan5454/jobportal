@if (Session::has('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label='close'></button>
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label='close'></button>
    </div>
@endif


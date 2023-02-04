@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show my-5" role="alert">
        <div class="flex">
            {{ session()->get('success') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            &times;
        </button>
    </div>
@elseif(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show my-5" role="alert">
        <div class="flex">
            {{ session()->get('error') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            &times;
        </button>
    </div>
@endif

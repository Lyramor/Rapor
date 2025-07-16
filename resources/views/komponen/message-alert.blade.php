@if (session('message'))
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}

                    {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, assumenda. --}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

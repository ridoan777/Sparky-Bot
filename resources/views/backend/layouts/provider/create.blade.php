@extends('backend.app')

@section('title', 'Fintech Create')

@push('styles')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Fintech Create Form</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('provider.index')}}">Categories</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Fintech Create</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="" method="POST" action="{{ route('provider.store') }}"
                              enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label for="name" class="form-label">Fintech :</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter your fintech" name="name" id="name"
                                       value="{{old('name')}}">
                                @error('name')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <a href="{{route('provider.index')}}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div> <!-- container-fluid -->
@endsection

@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#content1'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });


        $('.dropify').dropify();



        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush


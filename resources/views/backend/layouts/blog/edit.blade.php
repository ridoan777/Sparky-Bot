@extends('backend.app')

@section('title', 'Blog Edit Page')

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Blog Update Form</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('blog.index')}}">Categories</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Blog Edit</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="" method="POST" action="{{ route('blog.update', ['id' => $data->id]) }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Blog Title :</label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Title" name="title" id="title"
                                       value="{{ $data->title ?? '' }}">
                                @error('title')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description :</label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Type your description here..." name="description" id="description">{{ $data->description ?? '' }}</textarea>
                                @error('description')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image :</label>
                                <input class="form-control dropify @error('image') is-invalid @enderror"
                                       type="file" data-default-file="{{ asset($data->image ?? "") }}"
                                       name="image">

                                @error('image')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Publish Date and Time :</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                       name="published_at" id="published_at" value="{{ $data->published_at ?? '' }}">
                                @error('published_at')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{route('blog.edit',['id' => $data->id])}}" class="btn btn-warning">Cancel</a>
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


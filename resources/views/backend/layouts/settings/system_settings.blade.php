@extends('backend.app')

@section('title','System Settings')

@push('styles')
    <style>

        .dropify-wrapper .dropify-message p {
            font-size: 26px;
            margin: 5px 0 0;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">System Settings</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">System Settings</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">System Settings</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="row" method="POST" action="{{ route('settings.system.update') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">Email Address :</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Email" id="email" name="email"
                                       value="{{ $setting->email ?? 'admin@gmail.com' }}">
                                @error('email')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title :</label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Title" name="title" id="title"
                                       value="{{ $setting->title ?? 'Title' }}">
                                @error('title')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label f-w-500" for="system_name">System Name :</label>
                                <input type="text"
                                       class="form-control @error('system_name') is-invalid @enderror"
                                       placeholder="System Name" id="system_name" name="system_name"
                                       value="{{ $setting->system_name ?? 'System Name' }}">
                                @error('system_name')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label f-w-500" for="copyright_text">Copy Rights Test :</label>
                                <input type="text"
                                       class="form-control @error('copyright_text') is-invalid @enderror"
                                       placeholder="Copy Rights" name="copyright_text" id="copyright_text"
                                       value="{{ $setting->copyright_text ?? 'Text' }}">
                                @error('copyright_text')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="logo">Logo :</label>
                                <input type="file"
                                       class="form-control dropify @error('logo') is-invalid @enderror"
                                       id="logo" name="logo"
                                       data-default-file="@isset($setting){{ asset($setting->logo ?? 'backend/images/logo/logo.png') }}@endisset">
                                @error('logo')
                                <div style="color: red">{{$message}}</div>
                                @enderror

                                    @isset($setting->logo)
                                        <div class="form-check" style="margin-top: 8px;">
                                            <input class="form-check-input" type="checkbox" name="delete_logo" id="delete_logo">
                                            <label class="form-check-label" for="delete_logo">
                                                Delete current logo
                                            </label>
                                        </div>
                                    @endisset

                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="logo">Favicon :</label>
                                <input type="file"
                                       class="form-control dropify @error('favicon') is-invalid @enderror"
                                       name="favicon" id="favicon"
                                       data-default-file="@isset($setting){{ asset($setting->favicon ?? 'backend/images/favicon/favicon.png') }}@endisset">
                                @error('favicon')
                                <div style="color: red">{{$message}}</div>
                                @enderror

                                @isset($setting->favicon)
                                    <div class="form-check" style="margin-top: 8px;">
                                        <input class="form-check-input" type="checkbox" name="delete_favicon" id="delete_favicon">
                                        <label class="form-check-label" for="delete_favicon">
                                            Delete current favicon
                                        </label>
                                    </div>
                                @endisset

                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">About System :</label>
                                <textarea placeholder="Type Here..." id="description" class="form-control" name="description">{{ $setting->description ?? '' }}</textarea>
                                @error('description')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{route('settings.system.index')}}" class="btn btn-warning">Cancel</a>
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
            .create(document.querySelector('#description1'), {
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

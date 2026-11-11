@extends('backend.app')

@section('title', 'Profile settings')

@push('styles')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 18px;
            margin: 5px 0 0 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Profile Settings</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">Profile Settings</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">My Profile</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="" method="POST" action="{{ route('settings.update-profile') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="avatar">User Avatar:</label>
                                <input type="file" name="avatar" data-default-file="@isset($users){{ asset($users->avatar ?? '') }}@endisset" id="avatar" class="form-control dropify w-50 @error('avatar') border-danger @enderror" data-height="100" />
                                @error('avatar')
                                <div style="color: red">{{$message}}</div>
                                @enderror

                                @isset($users->avatar)
                                    <div class="form-check" style="margin-top: 8px;">
                                        <input class="form-check-input" type="checkbox" name="delete_avatar" id="">
                                        <label class="form-check-label" for="">
                                            Delete current avatar
                                        </label>
                                    </div>
                                @endisset
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleInputEmail1">User Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ Auth::user()->name ?? ''}}" type="text" aria-describedby="emailHelp" placeholder="Enter your name">
                                @error('name')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleInputEmail1">Email Address</label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ Auth::user()->email ?? ''}}" type="email" aria-describedby="emailHelp" placeholder="Enter email" readonly>
                                @error('email')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary">Submit</button>
                                <a href="{{route('settings.profile')}}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Update Your Password</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="" method="POST" action="{{ route('settings.update-password') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="old_password">Current Password :</label>
                                <input type="password"
                                       class="form-control @error('old_password') is-invalid @enderror"
                                       placeholder="Current Password" id="old_password" name="old_password"
                                       value="{{old('old_password')}}">
                                @error('old_password')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">New Password :</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="New Password" id="password" name="password"
                                       value="{{old('password')}}">
                                @error('password')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">

                                <label class="form-label" for="password_confirmation">Confirm Password :</label>
                                <input type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="Confirm Password" id="password_confirmation" name="password_confirmation"
                                       value="">
                                @error('password_confirmation')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary">Submit</button>
                                <a href="{{route('settings.profile')}}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div> <!-- container-fluid -->
@endsection




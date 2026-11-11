@extends('backend.app')

@section('title','Mail Settings')

@section('content1')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Mail Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> Mail Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-12 col-lg-7">
                    <form class="card" method="POST" action="{{ route('settings.mail-update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">Mail Settings</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_mailer">Mail Mailer :</label>
                                        <input type="text"
                                               class="form-control  @error('mail_mailer') is-invalid @enderror"
                                               placeholder="mail mailer" id="mail_mailer" name="mail_mailer"
                                               required
                                               value="{{ env('MAIL_MAILER') }}">
                                        @error('mail_mailer')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="mail_host" class="form-label f-w-500">Mail Host :</label>
                                        <input type="text"
                                               required
                                               class="form-control @error('mail_host') is-invalid @enderror"
                                               placeholder="mail host" name="mail_host" id="mail_host"
                                               value="{{ env('MAIL_HOST') }}">
                                        @error('mail_host')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_port">Mail Port :</label>
                                        <input type="text"
                                               required
                                               class="form-control @error('mail_port') is-invalid @enderror"
                                               placeholder="mail port" id="mail_port" name="mail_port"
                                               value="{{ env('MAIL_PORT') }}">
                                        @error('mail_port')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_username">Mail Username :</label>
                                        <input type="text"
                                               required
                                               class="form-control @error('mail_username') is-invalid @enderror"
                                               placeholder="" name="mail_username" id="mail_username"
                                               value="{{ env('MAIL_USERNAME') }}">
                                        @error('mail_username')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_password">Mail Password :</label>
                                        <input type="text"
                                               required
                                               class="form-control @error('mail_password') is-invalid @enderror"
                                               placeholder="mail password" id="mail_password" name="mail_password" value="{{ env('MAIL_PASSWORD') }}">
                                        @error('mail_password')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_encryption">Mail Encryption :</label>
                                        <input type="text"
                                               required
                                               class="form-control @error('mail_encryption') is-invalid @enderror"
                                               name="mail_encryption" placeholder="mail encryption" id="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}">
                                        @error('mail_encryption')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="mail_from_address">Mail From Address :</label>
                                        <input type="text" required placeholder="mail from address" id="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}">
                                        @error('mail_from_address')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{route('settings.mail')}}" class="btn btn-warning">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Mail Settings</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">Mail Settings</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Mail Settings</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="row" method="POST" action="{{ route('settings.mail-update') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_mailer">Mail Mailer :</label>
                                <input type="text"
                                       class="form-control  @error('mail_mailer') is-invalid @enderror"
                                       placeholder="mail mailer" id="mail_mailer" name="mail_mailer"
                                       required
                                       value="{{ env('MAIL_MAILER') }}">
                                @error('mail_mailer')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mail_host" class="form-label">Mail Host :</label>
                                <input type="text"
                                       required
                                       class="form-control @error('mail_host') is-invalid @enderror"
                                       placeholder="mail host" name="mail_host" id="mail_host"
                                       value="{{ env('MAIL_HOST') }}">
                                @error('mail_host')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_port">Mail Port :</label>
                                <input type="text"
                                       required
                                       class="form-control @error('mail_port') is-invalid @enderror"
                                       placeholder="mail port" id="mail_port" name="mail_port"
                                       value="{{ env('MAIL_PORT') }}">
                                @error('mail_port')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_username">Mail Username :</label>
                                <input type="text"
                                       required
                                       class="form-control @error('mail_username') is-invalid @enderror"
                                       placeholder="" name="mail_username" id="mail_username"
                                       value="{{ env('MAIL_USERNAME') }}">
                                @error('mail_username')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_password">Mail Password :</label>
                                <input type="text"
                                       required
                                       class="form-control @error('mail_password') is-invalid @enderror"
                                       placeholder="mail password" id="mail_password" name="mail_password" value="{{ env('MAIL_PASSWORD') }}">
                                @error('mail_password')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_encryption">Mail Encryption :</label>
                                <input type="text"
                                       required
                                       class="form-control @error('mail_encryption') is-invalid @enderror"
                                       name="mail_encryption" placeholder="mail encryption" id="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}">
                                @error('mail_encryption')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="mail_from_address">Mail From Address :</label>
                                <input type="text" required placeholder="mail from address" id="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}">
                                @error('mail_from_address')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{route('settings.mail')}}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>


        </div>

    </div> <!-- container-fluid -->
@endsection

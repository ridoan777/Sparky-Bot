@php

    $system =\App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title','Forget Password')

@section('content')
    <div class="col-xl-5 m-auto">
    <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-0 p-0 p-lg-3">
                            <div class="mb-0 border-0 p-md-4 p-lg-0">
                                <div class="mb-4 p-0 text-lg-start text-center">
                                    <div class="auth-brand">
                                        <a href="{{route('login')}}" class="logo logo-light">
                                            <span class="logo-lg">
                                                @if (!empty($system->logo))
                                                    <img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}" alt="logo" />
                                                @else
                                                    <img src="{{asset('backend/images/logo/sparkybot_logo.png')}}" alt="" height="48">
                                                @endif
                                            </span>
                                        </a>
                                        <a href="{{route('login')}}" class="logo logo-dark">
                                            <span class="logo-lg">
                                                @if (!empty($system->logo))
                                                    <img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}" alt="logo" />
                                                @else
                                                    <img src="{{asset('backend/images/logo/sparkybot_logo.png')}}" alt="" height="48">
                                                @endif
                                            </span>
                                        </a>

                                    </div>
                                </div>

                                <div class="auth-title-section mb-4 text-lg-start text-center">
                                    <h4 class="text-center">Forgot Password? 🔒</h4>
                                    <p class="text-center">Enter your email and we'll send you instructions to reset your password</p>
                                </div>


                                <div class="pt-0">
                                    <!-- Session Status -->
                                    <h6 class="text-center text-success">{{session('status')}}</h6>

                                    <form class="theme-form my-4" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group mb-3">

                                            <label for="email" class="form-label">Email</label>
                                            <input
                                                type="email"
                                                class="form-control @error('email') border-danger @enderror"
                                                id="email"
                                                name="email"
                                                placeholder="Enter email"
                                                autofocus />
                                            @error('email')
                                            <div style="color: red;">{{$message}}</div>
                                            @enderror

                                        </div>

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary fw-semibold" type="submit"> Send Password Reset Link </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

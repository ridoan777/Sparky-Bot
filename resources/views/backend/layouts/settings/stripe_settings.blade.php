@extends('backend.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Stripe Settings</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">Stripe</a></li>
                </ol>
            </div>
        </div>

        <div class="row">


            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Stripe Settings</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form class="" method="POST" action="{{route('settings.stripe.update')}}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="stripe_key">STRIPE KEY :</label>
                                <input type="text"
                                       id="stripe_key"
                                       class="form-control @error('stripe_key') is-invalid @enderror"
                                       placeholder="ENTER STRIPE KEY" name="stripe_key" value="{{ env('STRIPE_KEY') }}" required>
                                @error('stripe_key')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">STRIPE SECRET :</label>
                                <input type="text"
                                       id="stripe_secret"
                                       class="form-control @error('stripe_secret') is-invalid @enderror"
                                       placeholder="ENTER STRIPE SECRET" name="stripe_secret" value="{{ env('STRIPE_SECRET') }}"
                                       required>
                                @error('stripe_secret')
                                <div style="color: red">{{$message}}</div>
                                @enderror
                            </div>
                            {{-- <div class="card-footer text-end">
                                <button class="btn btn-primary">Submit</button>
                                <a href="{{ route('settings.stripe.index') }}" class="btn btn-warning">Cancel</a>
                            </div> --}}

                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div> <!-- container-fluid -->
@endsection

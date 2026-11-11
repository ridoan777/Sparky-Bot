@php
    $users = null;
    if (auth()->check()) {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // Query the users table to get the user with the given ID
        $users = \App\Models\User::where('id', $userId)->first();
    }
@endphp

@push('styles')
    <style>
        #waveIcon {
            animation: wave 2s infinite;
            transform-origin: 70% 70%;
        }

        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(14deg);
            }

            20% {
                transform: rotate(-8deg);
            }

            30% {
                transform: rotate(14deg);
            }

            40% {
                transform: rotate(-4deg);
            }

            50% {
                transform: rotate(10deg);
            }

            60% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }
    </style>
@endpush

@extends('backend.app')

@section('title', 'Dashboard Page')

@section('content')
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
            </div>
        </div>

        <!-- Start Main Widgets -->

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 rounded-4 shadow"
                    style="background: linear-gradient(135deg, #3b82f6, #1e3a8a); box-shadow: 0 12px 30px rgba(0,0,0,0.25);">
                    <div class="card-body d-flex flex-column align-items-center text-center p-5">

                        <!-- Animated SVG -->
                        <div class="mb-4">
                            <svg id="waveIcon" width="80" height="80" viewBox="0 0 64 64"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="30" fill="#ffffff22" />
                                <path fill="#ffffff" d="M27 20h4v24h-4V20zm6 4h4v20h-4V24zm6 4h4v16h-4V28z" />
                            </svg>
                        </div>

                        <!-- Welcome Text -->
                        <h2 class="fw-bold text-white mb-2" style="font-size: 2rem;">
                            Welcome back, <span class="text-warning">{{ $users->name }}</span>
                        </h2>
                        <p class="text-light mb-0" style="font-size: 1.1rem;">
                            Wishing you a successful and productive day ahead!
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Widgets -->


        <!-- Start Main Widgets -->
        {{-- <div class="row">
            <div class="col-md-6 col-lg-4 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">

                            <div class="d-flex align-items-center mb-2">
                                <div class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-2 me-2">
                                    <div class="bg-primary rounded-circle widget-size text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Total Users</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-dark me-3">{{ $total_user }}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- End Main Widgets -->

    </div>
@endsection

@php

	$system = \App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title', 'Login Page')

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
													<img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}"
														alt="logo" />
												@else
													<img src="{{asset('backend/images/logo/sparkybot_logo.png')}}" alt="" height="48">
												@endif
											</span>
										</a>
										<a href="{{route('login')}}" class="logo logo-dark">
											<span class="logo-lg">
												@if (!empty($system->logo))
													<img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}"
														alt="logo" />
												@else
													<img src="{{asset('backend/images/logo/sparkybot_logo.png')}}" alt="" height="48">
												@endif
											</span>
										</a>

									</div>
								</div>

								<div class="auth-title-section mb-4 text-lg-start text-center">
									<h3 class="text-dark fw-semibold mb-3">Welcome back! Please Sign in to continue.</h3>
								</div>


								<div class="pt-0">
									<form class="theme-form my-4" method="POST" action="{{ route('login') }}">
										@csrf
										<div class="form-group mb-3">

											<label for="email" class="col-form-label">Email</label>
											<input type="email" class="form-control @error('email') border-danger @enderror"
												id="email" name="email" placeholder="Enter email" autofocus />
											@error('email')
												<div style="color: red;">{{$message}}</div>
											@enderror

										</div>

										<div class="form-group mb-3">

											<label class="form-label" for="password">Password</label>
											<div class="form-input position-relative">

												<input type="password" id="password"
													class="form-control @error('password') border-danger @enderror" name="password"
													placeholder="*********" aria-describedby="password" />

												<div class="show-hide"><span class="show"></span></div>
											</div>
											@error('password')
												<div style="color: red;">{{$message}}</div>
											@enderror


										</div>

										<div class="form-group d-flex mb-3">
											<div class="col-sm-6">
												<div class="form-check">
													<input type="checkbox" class="form-check-input" id="remember-me" checked>
													<label class="form-check-label" for="remember-me">Remember me</label>
												</div>
											</div>
											<div class="col-sm-6 text-end">
												<a class='text-muted fs-14' href='{{ route('password.request') }}'>Forgot password?</a>
											</div>
										</div>

										<div class="form-group mb-0 row">
											<div class="col-12">
												<div class="d-grid">
													<button class="btn btn-primary fw-semibold" type="submit"> Log In </button>
												</div>
											</div>
										</div>
									</form>

									{{-- <div class="text-center text-muted">
										<p class="mb-0">Don't have an account ?<a class='text-primary ms-2 fw-medium'
												href='{{ route(' register') }}'>Sign up</a></p>
									</div> --}}

								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

@endsection


@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const togglePassword = document.querySelectorAll('.show-hide');

			togglePassword.forEach(function (element) {
				element.addEventListener('click', function () {
					const input = this.previousElementSibling;
					const span = this.querySelector('span');

					if (input.type === 'password') {
						input.type = 'text';
						//span.textContent = 'Hide'; // Change text to 'Hide'
					} else {
						input.type = 'password';
						//span.textContent = 'Show'; // Change text to 'Show'
					}
				});
			});
		});
	</script>
@endpush
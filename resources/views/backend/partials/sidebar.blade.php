@php

	$system = \App\Models\SystemSetting::first();

@endphp

<div class="app-sidebar-menu">

	<div class="h-100 " data-simplebar>
		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul id="side-menu" class="mt-4">
				<!-- Sidebar Logo -->
				<li class="logo-box menu-title">

					<a href="{{ route('dashboard') }}" class="logo logo-dark">
						<span class="logo-lg">
							@if (!empty($system->logo))
								{{-- <img class="mb-3" width="100px" height="30px" src="{{ asset($system->logo ?? "") }}"
									alt="logo" />
								--}}
								<!-- <img height="40" src="{{ asset($system->logo ?? '') }}" alt="logo" /> -->
							@else
								<!-- <img src="{{ asset('backend/images/logo-dark.png') }}" alt="" height="24"> -->
								<img src="{{ asset('backend/images/logo/sparkybot_logo.png') }}" alt="" height="80" class="p-1">
							@endif
						</span>
					</a>

				</li>
				<!-- Sidebar Logo -->

				<li class="menu-title">Menu</li>

				<li>
					<a href="{{ route('admin.reference.index') }}">
						<i data-feather="home"></i>
						<span> Dashboard </span>
					</a>
				</li>

				<li class="menu-title">Modules</li>

				<li>
					<a href="{{ route('admin.reference.index') }}">
						<i data-feather="home"></i>
						<span> Quick Reference </span>
					</a>
				</li>


				<li class="menu-title mt-2">Management</li>


				<li>
					<a class="{{ Request::routeIs('settings.*') ? 'active open' : ' ' }}" href="#sidebarManagement"
						data-bs-toggle="collapse">
						<i data-feather="settings"></i>
						<span> Management </span>
						<span class="menu-arrow"></span>
					</a>
					<div class="collapse" id="sidebarManagement">
						<ul class="nav-second-level">
							<li>
								<a href="{{ route('manage.users') }}"
									class="tp-link {{ Request::routeIs('manage.users') ? 'active' : ' ' }}">User Management</a>
							</li>
							<li>
								<a href="{{ route('manage.about_help') }}"
									class="tp-link {{ Request::routeIs('manage.about_help') ? 'active' : ' ' }}">About Us/Help</a>
							</li>
							<li>
								<a href="{{ route('manage.this_profile') }}"
									class="tp-link {{ Request::routeIs('manage.this_profile') ? 'active' : ' ' }}">Profile</a>
							</li>

						</ul>
					</div>
				</li>

				<li class="d-none">
					<a class="{{ Request::routeIs('settings.*') ? 'active open' : ' ' }}" href="#sidebarSettings"
						data-bs-toggle="collapse">
						<i data-feather="settings"></i>
						<span> Settings </span>
						<span class="menu-arrow"></span>
					</a>
					<div class="collapse" id="sidebarSettings">
						<ul class="nav-second-level">
							<li>
								<a href="{{ route('settings.profile') }}"
									class="tp-link {{ Request::routeIs('settings.profile') ? 'active' : ' ' }}">Profile
									Settings</a>
							</li>
							<li>
								<a href="{{ route('settings.system.index') }}"
									class="tp-link {{ Request::routeIs('settings.system.index') ? 'active' : ' ' }}">System
									Settings</a>
							</li>
							<li>
								<a href="{{ route('settings.mail') }}"
									class="tp-link {{ Request::routeIs('settings.mail') ? 'active' : ' ' }}">Mail
									Settings</a>
							</li>

						</ul>
					</div>
				</li>

			</ul>

		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
</div>
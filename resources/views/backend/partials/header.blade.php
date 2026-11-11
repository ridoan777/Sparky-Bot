@php
   $users = null;
   if (auth()->check()) {
       $userId = \Illuminate\Support\Facades\Auth::id();

       // Query the users table to get the user with the given ID
       $users = \App\Models\User::where('id', $userId)->first();
   }
@endphp





<div class="topbar-custom">
   <div class="container-fluid">
      <div class="d-flex justify-content-between">
         <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
            <li>
               <button class="button-toggle-menu nav-link">
                  <i data-feather="menu" class="noti-icon"></i>
               </button>
            </li>
         </ul>

         <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
            <!-- Button Trigger Customizer Offcanvas -->
            <li class="d-none d-sm-flex">
               <button type="button" class="btn nav-link" data-toggle="fullscreen">
                  <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
               </button>
            </li>

            <!-- Light/Dark Mode Button Themes -->
            <li class="d-none d-sm-flex">
               <button type="button" class="btn nav-link" id="light-dark-mode">
                  <i data-feather="moon" class="align-middle dark-mode"></i>
                  <i data-feather="sun" class="align-middle light-mode"></i>
               </button>
            </li>

            <!-- User Dropdown -->
            <li class="dropdown notification-list topbar-dropdown">
               <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button"
                  aria-haspopup="false" aria-expanded="false">

                  @isset($users)
                     @if ($users->avatar)
                        <img id="avatar" src="{{ asset('storage/' . $users->avatar) }}" alt="Avatar"
                           class="rounded-circle"
                           height="50" width="50">
                     @else
                        <img src="{{ asset('backend/images/no-user.jpg') }}" alt="user-image" class="rounded-circle" />
                     @endif
                  @else
                     <img src="{{ asset('backend/images/no-user.jpg') }}" alt="user-image" class="rounded-circle" />
                  @endisset

                  {{-- <span class="pro-user-name ms-1">{{ Auth::user()->name ?? '' }} <i
                                class="mdi mdi-chevron-down"></i></span> --}}
               </a>
               <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                  <!-- item-->
                  <div class="dropdown-header noti-title">
                     @php
                        $name = Auth::user()->name ?? '';
                        $firstWord = strtok($name, ' '); // first word
                        $shortName = strlen($firstWord) < 15 ? $firstWord : substr($firstWord, 0, 15);
                        // First word of first 15 characters, whichever is smaller
                     @endphp

                     <h6 class="text-overflow m-0">Welcome ! {{ $shortName }}</h6>

                  </div>
                  <div class="dropdown-header noti-title">

                     <span class="text-overflow m-0">{{ Auth::user()->email }}</span>

                  </div>

                  {{-- <!-- item-->
                        <a href="{{route('settings.profile')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="{{route('settings.system.index')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-settings-outline fs-16 align-middle"></i>
                            <span>System Settings</span>
                        </a> --}}

                  <div class="dropdown-divider"></div>

                  <!-- <a class="dropdown-item notify-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">
                            <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                            <span>Logouts</span>
                        </a> -->
                  <form action="{{ route('web.logout') }}" method="post" id="logoutForm"
                     class="dropdown-item notify-item">
                     @csrf
                     <button type="submit" class="btn">
                        <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                        <span>Logout</span>
                     </button>
                  </form>

               </div>
            </li>
         </ul>
      </div>
   </div>
</div>

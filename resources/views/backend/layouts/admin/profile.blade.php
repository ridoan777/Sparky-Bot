<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
   <title>@yield('title')</title>

   {!! ToastMagic::styles() !!}


   @include('backend.partials.styles')

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

   <!-- Begin page -->
   <div id="app-layout">


      @include('backend.partials.header')

      @include('backend.partials.sidebar')

      <!-- Left Sidebar End -->

      <!-- ============================================================== -->
      <!-- Start Page Content here -->
      <!-- ============================================================== -->


      <div class="content-page">

         <!-- alert -->
         <x-alert />
         <!-- alert -->

         <div class="content container">
            @yield('content')
            <!-- content -->
            <!-- ---------------- APP AREA Starts ---------------- -->

            <div class="p-4">
               <h1 class="h4 mb-4">Current Admin Users</h1>

               <div>
                  <form action="{{ route('manage.this_profile_update', $userData?->id) }}" method="POST"
                     enctype="multipart/form-data">
                     @csrf

                     <!-- Category Fields -->
                     <div class="mb-3">
                        <label for="name" class="form-label">Admin Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                           value="{{ $userData?->name ?? "N/A" }}" required>
                     </div>
                     <!--  -->
                     <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control"
                           value="{{ $userData?->email ?? "N/A" }}" required>
                     </div>
                     <!--  -->
                     <div class="mb-3">
                        <label for="email" class="form-label">Password</label>
                        <input type="password" name="password" class="my-2 form-control" placeholder="New password">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype new password">

                     </div>
                     <!--  -->
                     <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                           value="{{ $userData?->phone ?? "N/A" }}">
                     </div>
                     <!--  -->
                     <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control"
                           value="{{ $userData?->address ?? "N/A" }}">
                     </div>
                     <!--  -->
                     @if($userData?->avatar)
                        <div id="avatar-container" class="w-50 mb-3">
                           <img src="{{ asset('storage/' . $userData->avatar) }}" class="img-thumbnail mb-2" width="150">
                           <button type="button" id="removeAvatarBtn" class="btn btn-danger btn-sm">Remove Avatar</button>
                        </div>
                     @endif

                     <!-- Upload new avatar -->
                     <div class="mb-3">
                        <label class="form-label">Change Avatar</label>
                        <input type="file" name="avatar" class="form-control">
                     </div>

                     <!-- Hidden field to signal removal -->
                     <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">

                     <!--  -->

                     <button type="submit" class="btn btn-primary">Save/Update</button>
                  </form>
               </div>

            </div>



            <!-- content -->
         </div>

         <!-- Footer Start -->
         @include('backend.partials.footer')
         <!-- end Footer -->

      </div>
      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
      {{-- Remove Avatar --}}
      <script>
         document.addEventListener("DOMContentLoaded", function () {
            const removeBtn = document.getElementById("removeAvatarBtn");
            const hiddenInput = document.getElementById("remove_avatar");
            const container = document.getElementById("avatar-container");

            if (removeBtn) {
               removeBtn.addEventListener("click", function () {
                  // mark removal in hidden input
                  hiddenInput.value = "1";

                  // hide the avatar preview instantly
                  container.style.display = "none";
               });
            }
         });
      </script>
      {{-- Remove Avatar --}}

   </div>
   <!-- END wrapper -->

   @include('backend.partials.scripts')

   {!! ToastMagic::scripts() !!}

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
   <title>@yield('title')</title>

   {!! ToastMagic::styles() !!}


   @include('backend.partials.styles')

   <style>
      li {
         list-style: none;
      }
   </style>

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

   <!-- Begin page -->
   <div id="app-layout">

      <!-- Header Start -->

      @include('backend.partials.header')

      <!-- End Header -->

      <!-- Left Sidebar Start -->

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

            <form action="{{ route('manage.help_about_store') }}" method="POST">
               @csrf
               <input type="hidden" name="type" value="help_about_us">

               <!-- Category Fields -->
               <div class="mb-3">
                  <label class="form-label">About Us Content</label>
                  <textarea type="text" name="about_us" class="form-control" rows="10">{{ $help_about_us?->about_us ?? null }}</textarea>
               </div>
               <div class="mb-3">
                  <label class="form-label">Help Content</label>
                  <textarea type="text" name="help" class="form-control" rows="10">{{ $help_about_us?->help ?? null }}</textarea>
               </div>
               <div class="mb-3">
                  <label class="form-label">Terms & Condition</label>
                  <textarea type="text" name="terms" class="form-control" rows="10">{{ $help_about_us?->terms ?? null }}</textarea>
               </div>
               <div class="mb-3">
                  <label class="form-label">Privacy Policy</label>
                  <textarea type="text" name="privacy" class="form-control" rows="10">{{ $help_about_us?->privacy ?? null }}</textarea>
               </div>

               <button type="submit" class="btn btn-primary">Save</button>
            </form>

            <!-- content -->
         </div>

         <!-- Footer Start -->
         @include('backend.partials.footer')
         <!-- end Footer -->

      </div>
      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->

   </div>
   <!-- END wrapper -->

   @include('backend.partials.scripts')

   {!! ToastMagic::scripts() !!}

</body>

</html>

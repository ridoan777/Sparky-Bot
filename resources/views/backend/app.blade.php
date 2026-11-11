<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
   <title>@yield('title')</title>

   {!! ToastMagic::styles() !!}

   <!-- Datatables -->
   {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
   {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
   <!-- Datatables -->

   @include('backend.partials.styles')




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
         <div class="content">
            @yield('content')
         </div> <!-- content -->

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

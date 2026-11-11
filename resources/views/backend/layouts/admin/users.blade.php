<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
   <title>@yield('title')</title>

   {!! ToastMagic::styles() !!}


   @include('backend.partials.styles')

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- DataTables CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   <!-- DataTables JS -->
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

   <style>
      li {
         list-style: none;
      }

      /* Fix DataTables dropdown arrow overlap */
      .dataTables_wrapper .dataTables_length select {
         padding: 4px 30px 4px 8px !important;
         background: white url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23666' d='m2 0-2 2h4zm0 5 2-2h-4z'/%3E%3C/svg%3E") no-repeat right 8px center !important;
         background-size: 8px 10px !important;
         appearance: none;
         -webkit-appearance: none;
         -moz-appearance: none;
         min-width: 60px;
      }

      .dataTables_length label {
         display: flex;
         align-items: center;
         gap: 8px;
      }
   </style>


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
               <h1 class="h4 mb-4">All Users</h1>

               <div class="table-responsive">
                  <table id="dataTableDisplay" class="table table-bordered table-striped table-hover">
                     <thead class="table-light text-uppercase">
                        <tr>
                           <th>SN</th>
                           <th>User ID</th>
                           <th>DP</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Address</th>
                           <th>Bio</th>
                           <th>Created At</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
            </div>

         </div>


         {{-- Old Script --}}
         <script>
            $(document).ready(function() {
               $('#dataTableDisplay').DataTable({
                  processing: true,
                  serverSide: true,
                  responsive: true,
                  ajax: {
                     url: '{{ route('backend.dataTable_all_users') }}',
                     type: 'POST',
                     headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     }
                  },
                  columns: [{
                        data: 'SN',
                        className: 'align-middle'
                     },
                     {
                        data: 'id',
                        className: 'align-middle'
                     },
                     {
                        data: 'avatar',
                        className: 'align-middle'
                     },
                     {
                        data: 'name',
                        className: 'align-middle'
                     },
                     {
                        data: 'email',
                        className: 'align-middle'
                     },
                     {
                        data: 'phone',
                        className: 'align-middle'
                     },
                     {
                        data: 'address',
                        className: 'align-middle'
                     },
                     {
                        data: 'bio',
                        className: 'align-middle'
                     },
                     {
                        data: 'created_at',
                        className: 'align-middle'
                     },
                     {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                     }
                  ],
                  pageLength: 25
               });
            });
         </script>
         {{-- Old Script --}}

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

@extends('backend.app')

@section('title','Blog Information')

@push('styles')
    <link href="{{asset('backend/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
@endpush


@section('content')
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Blog Information</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Data Tables</li>
                </ol>
            </div>
        </div>

        <!-- Datatables  -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Blog Information</h5>
                        <a href="{{ route('blog.create') }}" class="btn btn-primary">
                            Add New
                        </a>
                    </div>


                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Blog Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Published At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            if (!$.fn.DataTable.isDataTable('#datatable')) {
                let dTable = $('#datatable').DataTable({
                    // DataTable options
                    order: [],
                    // lengthMenu: [
                    //     [25, 50, 100, 200, 500, -1],
                    //     [25, 50, 100, 200, 500, "All"]
                    // ],
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    language: {
                        processing: `Loading data...`
                    },
                    pagingType: "full_numbers",
                    // dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('blog.index') }}",
                        type: "GET"
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                        {
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'description',
                            name: 'description',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'published_at',
                            name: 'published_at',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }
        });

        // Status Change Confirm Alert
        function showStatusChangeAlert(id) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to update the status?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    statusChange(id);
                }
            });
        }
        // Status Change
        function statusChange(id) {
            let url = '{{ route('blog.status', ':id') }}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                success: function(resp) {
                    console.log(resp);
                    // Reloade DataTable
                    $('#datatable').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // show toast message
                        //toastr.success(resp.message);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Published Successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (resp.errors) {
                        //toastr.error(resp.errors[0]);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: `${resp.errors[0]}`
                        });
                    } else {
                        //toastr.error(resp.message);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Unpublished Successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(error) {
                    // location.reload();
                }
            });
        }

        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }
        // Delete Button
        function deleteItem(id) {
            let url = '{{ route('blog.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    console.log(resp);
                    // Reloade DataTable
                    $('#datatable').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // show toast message
                        // toastr.success(resp.message);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Deleted Successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else if (resp.errors) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: `${resp.errors[0]}`
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: `${resp.message}`
                        });
                        // toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    // location.reload();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        }
    </script>

    <!-- Datatables js -->
    <script src="{{asset('backend/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>

    <!-- dataTables.bootstrap5 -->
    <script src="{{asset('backend/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>

{{--    <!-- buttons.colVis -->--}}
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>

    <!-- buttons.bootstrap5 -->
    <script src="{{asset('backend/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>

    <!-- dataTables.keyTable -->
    <script src="{{asset('backend/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js')}}"></script>

    <!-- dataTable.responsive -->
    <script src="{{asset('backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>

    <!-- dataTables.select -->
    <script src="{{asset('backend/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('backend/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js')}}"></script>

    <!-- Datatable Demo App Js -->
    <script src="{{asset('backend/js/pages/datatable.init.js')}}"></script>


@endpush

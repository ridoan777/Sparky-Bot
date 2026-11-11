
<!-- Vendor -->
<script src="{{asset('backend/js/head.js')}}"></script>
{{-- <script src="{{asset('backend/libs/jquery/jquery.min.js')}}"></script> --}}
<script src="{{asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>




<script src="{{asset('backend/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('backend/libs/node-waves/waves.min.js')}}"></script>
{{-- <script src="{{asset('backend/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script> --}}
{{-- <script src="{{asset('backend/libs/jquery.counterup/jquery.counterup.min.js')}}"></script> --}}
<script src="{{asset('backend/libs/feather-icons/feather.min.js')}}"></script>



<!-- Apexcharts JS -->
<script src="{{asset('backend/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Widgets Init Js -->
<script src="{{asset('backend/js/pages/crm-dashboard.init.js')}}"></script>

<!-- App js-->
<script src="{{asset('backend/js/app.js')}}"></script>



{{-- dropify start--}}

<script src="{{ asset('backend/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{-- dropify end--}}


{{-- sweetalert--}}
<script src="{{ asset('backend/cdn/js/sweetalert2@11.js') }}"></script>


<script src="{{ asset('backend/js/ckeditor.js') }}"></script>


<!-- Template js-->
<script src="{{asset('backend/js/script.js')}}"></script>


@stack('scripts')

<!-- login js-->

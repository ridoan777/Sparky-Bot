
@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp


<link rel="shortcut icon" type="image/x-icon" href="{{ $systemSetting->favicon ?? asset('backend/images/favicon.ico') }}" />

<!-- App css -->
<link href="{{asset('backend/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons -->
<link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />


{{-- dropify --}}
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">


{{-- dropify and ck-editor start --}}
<style>
    .ck-editor__editable[role="textbox"] {
        min-height: 150px;
    }

    .dropify-wrapper .dropify-render {
        display: unset !important;
    }
</style>
{{-- dropify and ck-editor end --}}

<style>
    /* Apply dark mode styles if the html tag has data-bs-theme="dark" */
    body.dark-only .ck-editor__editable,html[data-bs-theme="dark"] {
        /* CKEditor Dark Mode Custom Styling */
        .ck-editor__editable {
            background-color: #10101C !important;
            color: #e0e0e0 !important;
        }

        .ck-editor__editable[role="textbox"] {
            border: 1px solid #444 !important;
        }

        .ck-editor__editable.ck-rounded-corners {
            border-radius: 5px !important;
        }

        .ck-editor__editable:focus {
            border-color: #1e90ff !important;
            box-shadow: 0 0 5px rgba(30, 144, 255, 0.5) !important;
        }

        .ck-editor__editable .ck-placeholder {
            color: #777 !important;
        }

        /* Dropify Dark Mode Custom Styling */
        .dropify-wrapper {
            background-color: #10101C !important;
            border: 2px solid #555 !important;
            color: #ddd !important;
        }

        .dropify-message {
            color: #bbb !important;
        }

        .dropify-wrapper .dropify-render img {
            background-color: #444 !important;
        }

        .dropify-wrapper:hover {
            background-color: white !important;
            color: #bbb !important;
        }

        .dropify-wrapper:hover .dropify-message {
            color: #bbb !important;
        }

        .dropify-clear {
            color: white !important;
        }
    }

</style>

{{--<!-- App css-->--}}
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('backend/css/color-1.css')}}" media="screen">

<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/responsive.css')}}">
@stack('styles')

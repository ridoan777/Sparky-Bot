@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp

<!-- App favicon -->
<link rel="shortcut icon" href="{{ $systemSetting->favicon ?? asset('backend/images/favicon.ico') }}" />

<!-- App css -->
<link href="{{asset('backend/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons -->
<link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

@stack('styles')

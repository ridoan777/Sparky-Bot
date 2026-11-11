<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>

    @include('auth.partials.styles')

</head>

<body>
<!-- Begin page -->
<div class="account-page">
    <div class="container-fluid p-0">
        <div class="row align-items-center g-0 px-3 py-3 vh-100">

           @yield('content')

        </div>
    </div>
</div>

<!-- END wrapper -->

@include('auth.partials.scripts')

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
   <title>@yield('title')</title>

   @include('backend.partials.styles')

</head>

<body>
   <div class="p-4">
      <h1 class="text-center">Terms & Condition</h1>
      <p>{{ $publicData?->terms ?? null }}</p>
   </div>
</body>

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('auth.layouts.head')
  </head>

  <body>
    @yield('content')
    @include('auth.layouts.js')
  </body>
</html>

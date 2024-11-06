<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('public/css/custom.css') }}">

        @yield('style')
        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Page Heading -->

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        <script src="{{ url('public/js/jquery-3.5.1.slim.min.js') }}"></script>
        <script src="{{ url('public/js/popper.min.js') }}"></script>
        <script src="{{ url('public/js/bootstrap.min.js') }}"></script>
        @yield('script')
    </body>
</html>

<html>

<head>
    <title>We teach finance</title>
    @yield('styles');
    @include('layouts.header');
</head>

<body>
    @include('layouts.navbar');
    @include('layouts.sidebar');
    @yield('contents');
    @include('layouts.footer');

    @yield('scripts');
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>


</html>

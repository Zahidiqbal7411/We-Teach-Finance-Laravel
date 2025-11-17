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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 
    @yield('scripts');
    

    
   
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>


</html>
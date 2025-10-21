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
</body>


</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    
    <!-- Metronic CSS -->
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
</head>
<body>

    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Metronic JS -->
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
</body>
</html>

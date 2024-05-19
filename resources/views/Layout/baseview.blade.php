<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager | @yield('title')</title>
    <!-- Uncomment the line below to include jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include CSS files -->
    @include('layout.css')
    
    <!-- Yielded styles for specific pages -->
    @yield('style')
</head>

<body>
    <!-- Content for specific pages will be inserted here -->
    @yield('content')
    
    <!-- Include JavaScript files -->
    @include('layout.js')
    
    <!-- Yielded custom JavaScript for specific pages -->
    @yield('customjs')
</body>

</html>

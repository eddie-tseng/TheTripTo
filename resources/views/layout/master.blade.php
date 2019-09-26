<!DOCTYPE html >
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - THE TRIP TO [ ]</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="/css/site.css">
    @yield('custom-css')

</head>

<body>
    @yield('header')
    @yield('banner')
    @yield('modal')
    @yield('content')
    @include('component.footer')

    <!-- Base JavaScript-->
        <script src="/js/jquery-2.2.4.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/holder.min.js"></script>
    <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/search-bar.js"></script>
    @yield('custom-js')
</body>

</html>

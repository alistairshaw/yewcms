<!DOCTYPE html>
<head>
    @include('yewcms::common.head')
</head>
<html>
<body class="@yield('body-class')">
<header id="header" class="clearfix cl-header">
    @include('yewcms::common.header')
</header>
@include('yewcms::common.alerts')
<div id="fb-root"></div>
<section id="main" role="main" class="clearfix">
    @yield('content')
    <footer id="footer">
        @include('yewcms::common.footer')
    </footer>
</section>
<script src="{{ asset('vendor/yewcms/js/production.js') }}"></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
</script>
</body>

</html>
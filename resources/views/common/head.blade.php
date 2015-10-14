<title>@yield('title')</title>

<meta charset="utf-8">
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">
<meta name="robots" content="follow,index">
<meta name="author" content="Vendirun">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:url"           content="{{ Request::fullUrl() }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="Yew CMS" />
<meta property="og:description"   content="@yield('description')" />
<meta property="og:image"         content="@yield('image', '')" />

<link rel="stylesheet" href="{{ asset('vendor/yewcms/css/production.css') }}">
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset(config('constants.admin_path')) }}/" data-template="vertical-menu-template">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>@yield('title')</title>
<meta name="description" content="" />
@include('admin.partials.css')
@yield('custom_style')
</head>
<body>
@yield('contents')
@include('admin.partials.script')
@yield('custom_script')
</body>
</html>
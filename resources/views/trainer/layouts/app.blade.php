<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="GYM Admin Dashboard Template" />
    <meta name="keywords" content="GYM Admin Dashboard Template" />
    <meta name="author" content="GYM Admin Dashboard Template" />
  @include('trainer.partials.css')
  @yield('custom_style')
</head>
 <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track"><div class="loader-fill"></div></div>
    </div>
    @include('trainer.partials.sidebar')
    @include('trainer.partials.header')
    @yield('contents')
    @include('trainer.partials.script')
    @yield('custom_script')
</body>
</html>

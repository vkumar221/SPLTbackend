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
  @include('vendor.partials.css')
</head>
 <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
   <div class="auth-main">
    <div class="auth-wrapper v2">
      <div class="auth-sidecontent">
        <img src="{{ asset(config('constants.admin_path').'images/authentication/img-auth-sideimg.jpg') }}" alt="images" class="img-fluid img-auth-side" />
      </div>
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <a href="{{url('vendor')}}"><img src="{{ asset(config('constants.admin_path').'images/logo.png') }}" alt="img" /></a>
            </div>

            <div class="saprator my-3"></div>
            <h4 class="text-center f-w-500 mb-3 text-white">Vendor Login </h4>
            <form action="{{route('vendor.authenticate-login')}}" method="POST">
                @csrf
              <div class="mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required />
                @if($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
              </div>

              <div class="mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                @if($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
                @endif
              </div>

              {{-- <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="remember" name="remember" />
                  <label class="form-check-label text-white" for="remember">Remember me?</label>
                </div>
                <h6 class="text-secondary f-w-400 mb-0">
                  <a href="{{url('vendor/forgot_password')}}" class="text-white">Forgot Password?</a>
                </h6>
              </div> --}}

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
 @include('vendor.partials.script')
</body>
</html>

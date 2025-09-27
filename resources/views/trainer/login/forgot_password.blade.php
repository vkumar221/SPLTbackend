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
</head>
 <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
   <div class="auth-main">
    <div class="auth-wrapper v2">
      <div class="auth-sidecontent">
        <img src="{{ asset(config('constants.trainer_path').'images/authentication/img-auth-sideimg.jpg') }}" alt="images" class="img-fluid img-auth-side" />
      </div>
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <a href="{{url('trainer')}}"><img src="{{ asset(config('constants.trainer_path').'images/logo.png') }}" alt="img" /></a>
            </div>

            <div class="saprator my-3"></div>
            <h4 class="text-center f-w-500 mb-3 text-white">Login with your email</h4>

            <form action="{{route('trainer.authenticate-login')}}" method="POST">
                @csrf
              <div class="mb-3">
                <input type="email" class="form-control" name="trainer_email" id="trainer_email" placeholder="Email Address" required />
                @if($errors->has('trainer_email'))
                <div class="text-danger">{{ $errors->first('trainer_email') }}</div>
                @endif
              </div>

              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">

                </div>
                <h6 class="text-secondary f-w-400 mb-0">
                  <a href="{{url('trainer')}}" class="text-white">Remember Password ?</a>
                </h6>
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
 @include('trainer.partials.script')
</body>
</html>

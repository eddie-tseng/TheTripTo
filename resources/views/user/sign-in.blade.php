<!doctype html>
<html lang="en">
  <head>
    <!-- 放分頁的icon -->
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Floating labels example for Bootstrap</title>



    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/floating-labels.css" rel="stylesheet">
  </head>

  <body>
    {{-- 錯誤訊息模板元件 --}}
    @include('validationfail')
    <form class="form-signin" action="/sign-in" method="post">
      <div class="text-center mb-4">
        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Floating labels</h1>
        <p>Build form controls with floating labels via the <code>:placeholder-shown</code> pseudo-element. <a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a></p>
      </div>

      <div class="form-label-group">
        <input type="email" id="account" name="account" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
        <label for="account">Email address</label>
      </div>

      <div class="form-label-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <label for="password">Password</label>
      </div>

      {{-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> --}}
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
      {{ csrf_field() }}
    </form>
    @include('component.footer')
  </body>
</html>

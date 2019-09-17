<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Checkout example for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>title</h2>
        {{-- 錯誤訊息模板元件 --}}
        @include('validationfail')
        <div class="row">
            <div class="col-md-8 order-md-1">
          <h4 class="mb-3">註冊</h4>
            <form action="/user/sign-up" method="post">
              <div class="from-group">
                <div class="mb-3">
                    <label for="account">Account</label>
                        <input  type="email"
                                class="form-control"
                                id="account"
                                name="account"
                                placeholder="Username"
                                value="{{ old('account') }}"
                        required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password">密碼</label>
                        <input  type="text"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="password"
                        required>
                </div>

                  <div class="col-md-6 mb-3">
                        <label for="password_confirmation">確認密碼</label>
                        <input  type="text"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="password confirmation"
                        required>

                </div>
                <div class="mb-3">
                    <label for="phone">聯絡電話</label>
                    <input  type="test"
                            class="form-control"
                            id="phone"
                            name="phone"
                            placeholder="Username"
                            value="{{ old('phone') }}"
                    required>
                </div>
                </div>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name">名</label>
                        <input  type="text"
                                class="form-control"
                                id="first_name"
                                name="first_name"
                                placeholder=""
                                value="{{ old('first_name') }}"
                        required>

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name">姓</label>
                        <input  type="text"
                                class="form-control"
                                id="lastName"
                                name="last_name"
                                placeholder=""
                                value="{{ old('last_name') }}"
                        required>
                  </div>
                </div>

              </div>
              <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit">註冊</button>
                {{ csrf_field() }}
            </form>
            </div>
        </div>


    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Company Name</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/js/holder.min.js"></script>
    {{-- <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script> --}}
  </body>
</html>

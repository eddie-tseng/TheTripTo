<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/album.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">defer </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
{{--
    @php
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $myip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
    $myip= $_SERVER['REMOTE_ADDR'];
    }
    echo $myip;
    echo '<br>';
    echo session()->get('user_id');
    //$d=old('booking.1')['birth_date'];
    //session()->reflash();
    //print_r($d);
    @endphp --}}
</head>

<body>
    {{-- <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="mr-2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                        </path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <strong>Album</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    @if(session()->has('admin')|session()->has('tourist'))
                    <span>
                        <img src="{{session()->get('photo')}}" alt="" class="avatar">
                    </span>
                    @else
                    <span class="navbar-toggler-icon"></span>
                    @endif
                </button>
            </div>
        </div>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="col-md-4 offset-md-11 py-4">
                <ul class="nav navbar-nav navbar-right">
                    @if($myip == "192.168.100.1")
                    @if(session()->has('admin'))
                    <li><a href="/admin/sign-out" class="text-white">登出</a></li>
                    @else
                    <li><a href="/admin/sign-in" class="text-white">登入</a></li>
                    <li><a href="/admin/sign-up" class="text-white">註冊</a></li>
                    @endif
                    @else
                    @if(session()->has('user'))
                    <li><a href="/user/{{session()->get('user')}}" class="text-white">編輯個人檔案</a></li>
                    <li><a href="/user/sign-out" class="text-white">登出</a></li>
                    @else
                    <li><a href="/user/sign-in" class="text-white">登入</a></li>
                    <li><a href="/user/sign-up" class="text-white">註冊</a></li>
                    @endif
                    @endif
                    <li><a href="/tour/1" class="text-white">測試</a></li>
                </ul>
            </div>
        </div>
    </header> --}}
    @include('component.header-search')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div id="booking-informaiton">
<!--訂購人資訊-->
{{-- <div class="card"> --}}
        {{-- <div class="card-header">
            <a class="card-link collapsed" data-toggle="collapse" data-parent="#booking-informaiton"
                href="#user-infotmation">訂購人資訊</a>
        </div>
        <div id="user-infotmation" class="collapse">
            <div class="card-body">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="from-group">
                                    <label for="user-first-name">名</label>
                                    <input type="text" class="form-control" id="user-first-name"
                                        name="first_name" placeholder=""
                                        value="{{ old('first_name', $User->first_name) }}" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="from-group">

                                    <label for="user-last-name">姓</label>
                                    <input type="text" class="form-control" id="lastName"
                                        name="user-last-name" placeholder=""
                                        value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="from-group">

                                    <label for="user-mail">電子郵件</label>
                                    <input type="email" class="form-control" id="user-mail"
                                        name="mail" placeholder=""
                                        value="{{ old('account') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="from-group">

                                    <label for="user-phone">聯絡電話</label>
                                    <input type="text" class="form-control" id="user-phone"
                                        name="phone" placeholder=""
                                        value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div> --}}
<!--旅客資料-->
                    @include('validationfail')
                    <form action="/transaction" method="post">
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" data-parent="#booking-informaiton"
                                href="#tourists-infotmation">旅客資訊</a>
                        </div>
                        <div id="tourists-infotmation" class="collapse show">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="tabs">
                                    @for ($i = 1; $i <= session()->get('booking.quantity'); $i++)
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tourist{{$i}}">旅客{{$i}}</a>
                                    </li>
                                    @endfor
                                </ul>

                                <div class="tab-content">
                                    @for ($i = 1; $i <= session()->get('booking.quantity'); $i++)
                                    <div id="tourist{{$i}}" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="from-group">

                                                    <label for="tourist-first-name">名</label>
                                                    <input type="text" class="form-control" id="tourist-first-name"
                                                        name="booking[{{$i}}][first_name]" placeholder=""
                                                        value="{{ old('booking.'.$i)['first_name'] }}" required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="from-group">

                                                    <label for="tourist-last-name">姓</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                        name="booking[{{$i}}][last_name]" placeholder=""
                                                        value="{{ old('booking.'.$i)['last_name'] }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="from-group">

                                                    <label for="tourist-mail">電子郵件</label>
                                                    <input type="email" class="form-control" id="tourist-mail"
                                                        name="booking[{{$i}}][mail]" placeholder=""
                                                        value="{{ old('booking.'.$i)['mail'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="from-group">
                                                    <label for="tourist-phone">聯絡電話</label>
                                                    <input type="text" class="form-control" id="tourist-phone"
                                                        name="booking[{{$i}}][phone]" placeholder=""
                                                        value="{{ old('booking.'.$i)['phone'] }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="from-group">
                                                    <label for="gender">性別</label>
                                                    <select type="text" class="form-control" id="gender"
                                                        name="booking[{{$i}}][gender]" value="{{ old('booking.'.$i)['gender'] }}">
                                                        <option value="m"
                                                            @if(old('booking.'.$i)['gender']=='m') selected @endif>
                                                            男
                                                        </option>
                                                        <option value="f"
                                                            @if(old('booking.'.$i)['gender']=='f') selected @endif>
                                                            女
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="from-group">
                                                <label for="tourist-birthday">生日</label>
                                                        <div class="input-group date">

                                                    <input type="text" class="form-control" id="tourist-birthday"
                                                        name="booking[{{$i}}][birth_date]" placeholder=""
                                                        value="{{ old('booking.'.$i)['birth_date'] }}" required>
                                                    <div class="input-group-append">
                                                            <span class="input-group-text fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="from-group">

                                                    <label for="tourist-country">國家/地區</label>
                                                    <input type="text" class="form-control" id="tourist-country"
                                                        name="booking[{{$i}}][country]" placeholder=""
                                                        value="{{ old('booking.'.$i)['country'] }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
<!--付款方式-->
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" data-parent="#booking-informaiton"
                                href="#payment">付款方式</a>
                        </div>
                        <div id="payment" class="collapse">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="credit-card"
                                        value="cc" checked>
                                    <label class="form-check-label" for="credit-card">
                                        信用卡
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment"
                                        id="wire-transfer" value="wt">
                                    <label class="form-check-label" for="wire-transfer">
                                        轉帳
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-dark mt-3" type="submit">完成訂購</button>
                </div>
            </div>

            {{ csrf_field() }}
        </form>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            Card content
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('component.footer')

    <script type="text/javascript">
        //console.log(datesEnabled);
        $('.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        //startDate: "today",
        });
        $('.date').datepicker('setDates');
     </script>
    <script  type="text/javascript">
        $(function () {
            $('#tabs li:eq(0) a').tab('show');
        });

    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>

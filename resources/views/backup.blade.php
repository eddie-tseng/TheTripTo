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
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/product.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
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
    echo session()->get('photo')

    @endphp --}}
</head>

<body>
        @include('component.header-search')
    {{-- <header>
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-dark bg-dark box-shadow">
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
                        @if(session()->has('admin')|session()->has('id'))
                        <span>
                            <img src="{{session()->get('photo')}}" alt="http://test_shop.test/img/about.jpg"
                                class="avatar">
                        </span>
                        @else
                        <span class="navbar-toggler-icon"></span>
                        @endif
                    </button>
                </nav>
                <div class="collapse bg-dark" id="navbarHeader">
                    <div class="col-md-4 offset-md-11 py-4">
                        <ul class="nav navbar-nav navbar-right">
                            @if($_SERVER['REMOTE_ADDR'] == "192.168.10.1")
                            @if(session()->has('admin'))
                            <li><a href="/admin/sign-out" class="text-white">登出</a></li>
                            @else
                            <li><a href="/admin/sign-in" class="text-white">登入</a></li>
                            <li><a href="/admin/sign-up" class="text-white">註冊</a></li>
                            @endif
                            @else
                            @if(session()->has('user'))
                            <li><a href="/user/{{session()->get('user_id')}}" class="text-white">編輯個人檔案</a></li>
                            <li><a href="/user/sign-out" class="text-white">登出</a></li>
                            @else
                            <li><a href="/user/sign-in" class="text-white">登入</a></li>
                            <li><a href="/user/sign-up" class="text-white">註冊</a></li>
                            @endif
                            @endif
                            <li><a href="/test" class="text-white">測試</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header> --}}

    <div class="container-fluid py-4">
        @include('validationfail')
        <form action="/user/{{session()->get('user_id')}}" method="post" enctype="multipart/form-data">
            {{method_field('PUT')}}
            <div class="row">
                <div class="col-md-2 offset-1">
                        <div class="ml-5">
                    <label for="photo">
                        <img src="{{session()->get('photo')}}" alt="" class="rounded-circle" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="align-bottom">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                    </label>
                        </div>
                    <div class="image-upload">
                        {{-- <label for="photo position-top:2px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="update">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </label> --}}
                        <input type="file" id="photo" name="photo">
                    </div>

                    <ul class="list-group py-4" style="line-height: 3em; font-size:1.5em;">
                            <a href="/user/{{session()->get('user_id')}}" class="list-group-item list-group-item-action list-group-item-secondary active">編輯個人檔案</a>
                            <a href="/user/{{session()->get('user_id')}}/booking-list" class="list-group-item list-group-item-action list-group-item-secondary"><span>我的旅程</span></a>
                            <a href="/user/{{session()->get('user_id')}}/wish-list" class="list-group-item list-group-item-action list-group-item-secondary"><span>我的收藏</span></a>

                    </ul>
                </div>
                <div class="col-md-8 ml-5 form-group" style="background-color:gainsboro">
                    <div class="row mt-4">
                        <div class="col-md-4 ">
                            <label for="first_name">名</label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="" value="{{ old('first_name', $User->first_name) }}" required>

                        </div>
                        <div class="col-md-4 ">
                            <label for="last_name">姓</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" placeholder=""
                                value="{{ old('last_name', $User->last_name) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="gender">性別</label>
                            <select type="text" class="form-control" id="gender" name="gender"
                                value="{{ old('gender') }}">
                                <option value="m" @if(old('gender')=='m' ) selected @endif>
                                    男
                                </option>
                                <option value="f" @if(old('gender')=='f' ) selected @endif>
                                    女
                                </option>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="birth_date">生日</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date"
                                placeholder="" value="{{ old('birth_date', $User->birth_date) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="country">國家</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder=""
                                value="{{ old('country', $User->country) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="phone">電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                                value="{{ old('phone', $User->phone) }}" required>

                        </div>
                        <div class="col-md-4">
                            <label for="mail">電子郵件</label>
                            <input type="text/html" class="form-control" id="lastName" name="mail" placeholder=""
                                value="{{ old('mail', $User->mail) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="password">密碼</label>
                            <input type="text" class="form-control" id="password" name="password"
                                placeholder="password">
                        </div>
                        <div class="col-md-4">
                            <label for="password_confirmation">確認密碼</label>
                            <input type="text" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="password confirmation">
                        </div>
                    </div>
                    <div class="py-4">
                        <button type="submit" class="btn btn-primary">
                            儲存
                        </button>
                    </div>
                </div>

            </div>
            {{ csrf_field() }}
        </form>
    </div>
    </div>
@include('component.footer')
</body>

</html>

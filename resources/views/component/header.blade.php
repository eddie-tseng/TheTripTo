<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-dark box-shadow" style="background-color:#232931;">
        <a href="/" class="navbar-brand ml-2">
            <img src={{url("/img/site/logo-o.svg")}} width="105px" height="51px">
        </a>

        <div class="navbar-nav mr-auto">
            @yield('search')
        </div>

        <div class="navbar-nav ml-auto mr-2" style="display: inline-block;">
            <ul class="navbar-nav float-right text-right">
                @if(session()->has('user_id'))
                <li class="nav-item"><a href="/users/{{session()->get('user_id')}}" class="nav-link text-white">會員</a></li>
                <li class="nav-item"><a href="/sign-out" class="nav-link text-white">登出</a></li>
                @else
                <li class="nav-item"><a class="nav-link text-white" data-toggle="modal" data-target="#account-modal">註冊&nbsp;&nbsp;|&nbsp;&nbsp;登入</a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>

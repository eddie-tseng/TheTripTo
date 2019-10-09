<nav class="navbar navbar-expand-lg navbar-dark box-shadow" style="background-color:#232931;">
    <a href="/" class="navbar-brand ml-2" id="logo">
        <img src={{url("/img/site/logo-o.svg")}}>
    </a>

    @yield('search')

    <div class="navbar-nav mr-2" style="display: inline-block;">
        <ul class="navbar-nav float-right text-right">
            @if(session()->has('user_id'))
            <div class="row">
                <li class="nav-item"><a href="/users/{{session()->get('user_id')}}" class="nav-link sub-title text-white">會員</a></li>
                &nbsp;&nbsp;
                <li class="nav-item"><a href="/sign-out" class="nav-link sub-title text-white">登出</a></li>
            </div>
            @else
            <li class="nav-item"><a href="#account-modal" class="nav-link sub-title text-white" data-toggle="modal" data-target="#account-modal">註冊&nbsp;&nbsp;|&nbsp;&nbsp;登入</a>
            </li>
            @endif
        </ul>
    </div>
</nav>

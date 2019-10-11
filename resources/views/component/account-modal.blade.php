<div class="modal fade" id="account-modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-bady">
                <button type="button" class="close float-right mr-2 mt-2" data-dismiss="modal" aria-label="Close">
                    <img src={{url("/img/site/close.svg")}} alt="" width="30px" height="30px">
                </button>
                <div class="container">
                    <div class="header align-center text-center mt-5 mb-2">
                        <a href="/" class="logo">
                            <img src={{url("/img/site/logo.svg")}} alt="" width="170px" height="80px">
                        </a>
                    </div>
                    <hr style="height:1px; background-color:#23293132;">
                    <div class="log-in row justify-content-center mb-4">
                        <form action="/sign-in" method="post">
                            <input type="text" name="is_default_user" value="false" hidden>
                            <div class="col-12">
                                <p class="sub-title">THE TRIP TO [&nbsp;&nbsp;&nbsp;&nbsp;] 會員登入</p>
                                <div class="form-group row">
                                    <label for="account" class="col-4 pr-0">電子郵件</label>
                                    <div class="col-8 pl-0">
                                        <input type="email" id="account" name="account" class="form-control"
                                            placeholder="電子郵件" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-4 pr-0">密碼</label>
                                    <div class="col-8 pl-0">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="密碼" required>
                                    </div>
                                </div>
                                <div class="row justify-content-around mt-4">
                                    <button onclick="javascript:location.href='{{url('/sign-up')}}'" type="button" class="px-4 btn button-dark">註冊</a>
                                    <button id="sign-in" type="submit" class="px-4 btn button-dark">登入</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <hr>
                    <div class="fast-log-in row justify-content-center text-center mb-5">
                                <div class="col-12">
                                    <p class="sub-title">快速登入</p>
                                    <div class="row justify-content-around mt-4">
                                        <a href="/google-sign-in">
                                            <img src={{url("/img/site/google.png")}} alt="" width="80px" height="80px">
                                        </a>
                                    </div>
                                </div>
                        </div>
                        <hr style="height:1px; background-color:#23293132;" hidden>
                        <div class="default-account row justify-content-center text-lg-center mb-4" hidden>
                            <form  action="/sign-in" method="post">
                                <input type="text" name="is_default_user" value="true" hidden>
                                {{-- <input type="text" name="search" value="{{$page['search']}}" hidden> --}}
                                <div class="col-lg-12 text-center mx-auto">
                                    <p class="sub-title">預設帳號</p>
                                    <button type="submit" class="btn button-dark text-white px-4 py-4 my-2">TEST</button>
                                    <p>預設帳號 - 還剩 1 個</p>
                                </div>
                                {{ csrf_field() }}
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

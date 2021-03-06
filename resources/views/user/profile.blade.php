@extends('layout.master')

@section('title', $title)
@section('custom-css')
<link rel="stylesheet" href="/css/bootstrap-datepicker.css">
@endsection

@section('modal')
@include('component.account-modal')
@endsection

@section('header')
@include('component.header-search')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-around mx-auto mt-5" style="width: 85%;">
        <form id="profile" action="/users/{{session()->get('user_id')}}" method="post" enctype="multipart/form-data">
            {{method_field('PUT')}}
            <div class="row justify-content-around">
                <div class="col-lg-3 text-center">
                    <label for="photo" style="cursor: pointer">
                        <div class="row">
                            <img id="current-photo" src="{{session()->get('photo')}}" alt="user photo" class="rounded-circle mx-auto" />
                        </div>
                        <div class="row mt-2">
                            <i class="fa fa-camera mx-auto"></i>
                        </div>
                    </label>
                    <input type="file" id="photo" name="photo" hidden>

                    <ul class="list-group mx-auto sub-title my-4 py-2" id="user-control-items"
                        style="line-height: 2em;">
                        <a href="/users/{{session()->get('user_id')}}" class="active">個人檔案</a>
                        <a href="/users/{{session()->get('user_id')}}/orders"><span>我的旅程</span></a>
                        <a href="/users/{{session()->get('user_id')}}/favorite-tours"><span>我的收藏</span></a>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <p class="sub-title">個人資料</p>
                    <hr style="height:1px; background-color:#23293132;">
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <label for="last_name">姓</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" placeholder=""
                                value="{{old('last_name', $user->last_name) }}" required>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="first_name">名</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder=""
                                value="{{ old('first_name', $user->first_name) }}" required>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="gender">性別</label>
                            <select type="text" class="form-control" id="gender" name="gender" value="{{ old('gender') }}">
                                <option value="m" @if(old('gender', $user->gender) =='m' ) selected @endif>
                                    男
                                </option>
                                <option value="f" @if(old('gender', $user->gender)=='f' ) selected @endif>
                                    女
                                </option>
                            </select>

                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="birth_date">生日</label>
                            <div class="input-group date" style="cursor: pointer">
                            <input type="text" class="form-control" id="birth_date" name="birth_date" placeholder=""
                                value="{{ old('birth_date', $user->birth_date) }}">
                                <div class="input-group-append">
                                        <span class="input-group-text fa fa-calendar"></span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="country">國家</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder=""
                                value="{{old('country', $user->country) }}">
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="phone">電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                                value="{{old('phone', $user->phone) }}">
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="mail">電子郵件</label>
                            <input type="email" class="form-control" id="lastName" name="mail" placeholder=""
                                value="{{old('mail', $user->mail) }}" required>
                        </div>

                    </div>
                    @if(!session()->has('is_google_account'))
                    <p class="sub-title">密碼管理</p>
                    <hr style="height:1px; background-color:#23293132;">
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label for="password">新密碼</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="">
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="password_confirmation">確認密碼</label>
                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation"
                                placeholder="">
                        </div>
                    </div>
                    @endif
                    <div class="col-12 text-center mb-4">
                        <button type="submit" class="btn-lg button-light sub-title">
                            儲存
                        </button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection

@section('custom-js')
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script>
$('.date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
});
</script>
<script>
$('#photo').on('change', function(){
    $('button').click();
});
</script>
@endsection

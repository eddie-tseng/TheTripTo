@extends('layout.master')

@section('title', $title)
@section('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
    rel="stylesheet">
<style>
    .datepicker,
    .table-condensed {
        width: 450px;
        height: 300px;
        font-size: 100%
    }
</style>
@php

// print_r($comment_list);
@endphp
@endsection

@section('modal')
@include('component.account-modal')
@endsection

@section('header')
@include('component.header-search')
@endsection

@section('content')
@include('validationfail')
<div class="container-fluid w-75">
    <form action="/user/{{session()->get('user_id')}}" method="post" enctype="multipart/form-data">
        {{method_field('PUT')}}
        <div class="row justify-content-around mt-5">
            <div class="col-sm-3 text-center">
                <label for="photo" style="cursor: pointer">
                    <div class="row">
                        <img src="{{session()->get('photo')}}" alt="user photo" class="rounded-circle mx-auto" />
                    </div>
                    <div class="row mt-2">
                        <img src={{url("/img/site/star-o.svg")}} class="rounded-circle mx-auto"
                            style="background-color:#ffb400" alt="camera" width="30px" height="30px">
                    </div>
                </label>
                <input type="file" id="photo" name="photo" hidden>

                <ul class="list-group w-75 mx-auto sub-title my-4 py-2" id="user-control-items"
                    style="line-height: 2em;">
                    <a href="/user/{{session()->get('user_id')}}"" class="active">個人檔案</a>
                    <a href="/user/{{session()->get('user_id')}}/booking-list"><span>我的旅程</span></a>
                    <a href="/user/{{session()->get('user_id')}}/wish-list"><span>我的收藏</span></a>
                </ul>
            </div>
            <div class="col-sm-9">
                <p class="sub-title">個人資料</p>
                <hr style="height:1px; background-color:#23293132;">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-4">
                        <label for="last_name">姓</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder=""
                            value="{{old('last_name', $user->last_name) }}" required>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label for="first_name">名</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder=""
                            value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="col-sm-6 mb-4">
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
                    <div class="col-sm-6 mb-4">
                        <label for="birth_date">生日</label>
                        <div class="input-group date" style="cursor: pointer">
                        <input type="text" class="form-control" id="birth_date" name="birth_date" placeholder=""
                            value="{{ old('birth_date', $user->birth_date) }}">
                            <div class="input-group-append">
                                    <span class="input-group-text fa fa-calendar"></span>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label for="country">國家</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder=""
                            value="{{old('country', $user->country) }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label for="phone">電話</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                            value="{{old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label for="mail">電子郵件</label>
                        <input type="text/html" class="form-control" id="lastName" name="mail" placeholder=""
                            value="{{old('mail', $user->mail) }}" required>
                    </div>

                </div>
                <p class="sub-title">密碼管理</p>
                <hr style="height:1px; background-color:#23293132;">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-4">
                        <label for="password">密碼</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label for="password_confirmation">確認密碼</label>
                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="">
                    </div>
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn-lg button-light w-25">
                            儲存
                        </button>
                    </div>
                </div>

            </div>
        </div>
        {{ csrf_field() }}
    </form>
</div>
</div>
@endsection

@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script>
$('.date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
});
</script>
@endsection

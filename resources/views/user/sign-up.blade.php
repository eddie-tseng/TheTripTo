@extends('layout.master')

@section('title', $title)
@section('custom-css')
@php

// print_r($comment_list);
@endphp
@endsection

@section('modal')
@include('component.account-modal')
@endsection

@section('header')
{{-- @include('component.header-search') --}}
@endsection

@section('content')

<div class="container-fluid" style="width: 80%">
    <form action="/sign-up" method="post">
        <div class="row my-5">
            <div class="col-12">
                <div class="header align-center text-center mt-5 mb-2">
                    <a href="/" class="logo">
                        <img src={{url("/img/site/logo.svg")}} alt="" width="170px" height="80px">
                    </a>
                </div>
            </div>
            <hr style="height:1px; background-color:#23293132;">
            <div class="col-12">

                <hr style="height:1px; background-color:#23293132;">
                <p class="sub-title text-center">THE TRIP TO [&nbsp;&nbsp;&nbsp;&nbsp;] 會員註冊</p>

                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <label for="account">電子郵件</label>
                        <input type="text/html" class="form-control" id="lastName" name="account" placeholder=""
                            value="{{old('mail') }}" required>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="phone">電話</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                            value="{{old('phone') }}" required>
                    </div>


                    <div class="col-lg-6 mb-4">
                        <label for="password">密碼</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="password_confirmation">確認密碼</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="" required>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label for="last_name">姓</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder=""
                            value="{{old('last_name') }}" required>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="first_name">名</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder=""
                            value="{{ old('first_name') }}" required>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn-lg button-light sub-title">
                            送出
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

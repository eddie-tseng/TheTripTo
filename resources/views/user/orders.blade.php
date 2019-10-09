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
@include('component.header-search')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-around mx-auto mt-5" style="width: 85%;">
        <div class="col-lg-3 text-center">
            <label for="photo">
                <div class="row">
                    <img src="{{session()->get('photo')}}" alt="user photo" class="rounded-circle mx-auto"/>
                </div>
            </label>

            <ul class="list-group mx-auto sub-title my-4 py-2" id="user-control-items" style="line-height: 2em;">
                <a href="/users/{{session()->get('user_id')}}">個人檔案</a>
                <a href="/users/{{session()->get('user_id')}}/orders" class="active"><span>我的旅程</span></a>
                <a href="/users/{{session()->get('user_id')}}/favorite-tours"><span>我的收藏</span></a>
            </ul>
        </div>
        <div class="col-lg-9">
            <p class="sub-title">我的旅程</p>
            <hr style="height:1px; background-color:#23293132; ">

            @if(!$order_list->isEmpty())
            @foreach($order_list as $order)
            <div class="row mb-4 border mx-0">
                <div class="col-lg-4 pl-lg-0 p-0">
                    <img style="width:100%; height:100%" src={{url($order->tour->photo)}} alt="暫時沒有圖片">
                </div>
                <div class="col-lg-8 d-flex flex-column justify-content-between pr-3 my-lg-2 mt-4 my-2">
                    <div class="m-0 d-flex flex-column">
                        <p class="m-0 mb-1">訂單編號: {{str_pad($order->id, 5, '0', STR_PAD_LEFT)}}
                            <span class="badge badge-success h-100 my-auto ml-2">已付款</span>
                        </p>
                        <p class="sub-title m-0">{{$order->tour->title}}</p>
                    </div>
                    <div class="row d-flex justify-content-between mx-0 mt-4">
                        <div class="m-0 d-flex flex-column">
                            <p class="mb-1">旅行日期:{{$order->travel_date}}</p>
                            <p class="mb-2">TWD {{$order->price*$order->quantity}}</p>
                        </div>
                        <div class="m-0 pr-2">
                            <span>
                                @if (is_null($order->comment))
                                    <a href="/orders/{{$order->id}}/comment" class="btn button-light pl-2">給予評論</a>
                                @else
                                    <a href="/orders/{{$order->id}}/comment" class="btn button-dark pl-2 disabled" aria-disabled="true">給予評論</a>
                                @endif

                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center">
                <h2>查無訂單!</h2>
            </div>
        @endif
        {{$order_list->render('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

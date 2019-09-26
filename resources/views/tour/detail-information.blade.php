@extends('layout.master')

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

// print_r(session()->getId());
@endphp
@endsection

@section('modal')
@include('component.order-modal')
@include('component.account-modal')
@endsection

@section('header')
@include('component.header-search')
@endsection

@section('banner')
<div class="container-fluid text-center p-0 mb-5">
    <img class="w-100" style="height:500px;" src={{url($tour->photo)}} alt="暫時沒有圖片">
</div>
@endsection

@section('content')
@include('validationfail')
<div class="container-fluid w-75">
    <p id="available-date" style="display:none">{{$tour->AvailableDates->implode('available_date', ',')}}</p>
    <!--標題-->
    <div class="row justify-content-start text-sm-center">
        <div class="information col-sm-12 col-md-8 text-sm-left">
            <div class="row justify-content-satrt">
                <p class="title ml-3 mr-0 my-auto">{{str_replace("]", "] ", $tour->title)}}</p>
                <button class="favorite-tour ml-2 mb-1" type="button"><img alt="收藏" style="width:1.5vw"></button>
            </div>
            <a href='/tours?country={{$tour->country}}&sort=default' class="info">{{$tour->country}}</a>
            <a href='/tours?city={{$tour->city}}&sort=default' class="info">|&nbsp;&nbsp;{{$tour->city}}</a>
            <div class="row p-0 mx-0 mb-2">
                <div class="location info pr-4">
                    <img src={{url("/img/site/location.svg")}} alt="" width="10px" height="15px">
                    <span class="pl-1">{{$tour->country}}，{{$tour->city}}</span>
                </div>
                <div class="rating info pr-4">
                    <img src={{url("/img/site/star.svg")}} class="pb-1" alt="" width="15px" height="15px">
                    <span class="pl-1">{{$tour->rating}}</span>
                </div>
                <div class="sold info">
                    <img src={{url("/img/site/plus.svg")}} alt="" width=" 15px" height="15px">
                    <span class="pl-1">已有<span>0</span>人參加</span>
                </div>
            </div>
            <div class="row p-0 mx-0 mb-2">
                <div class="location info pr-4">
                    <img src={{url("/img/site/location.svg")}} alt="" width="10px" height="15px">
                    <span class="pl-1">包含來回接送</span>
                </div>
                <div class="rating info pr-4">
                    <img src={{url("/img/site/star.svg")}} class="pb-1" alt="" width="15px" height="15px">
                    <span class="pl-1">中文導覽</span>
                </div>
            </div>
        </div>
    </div>
    <!--內容-->
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <hr class="mx-0">
            <div class="intorduction row">
                <p class="sub-title">行程簡介</p>
                <p class="introduction">{{$tour->introduction}}</p>
            </div>
            <hr class="mx-0">
            <div class="map row">
                <p class="sub-title">地圖</p>
                <iframe src={{$gps}} width="100%" height="320" frameborder="0" style="border:0"
                    allowfullscreen=true></iframe>
            </div>
            <hr class="mx-0">
            <div class="comment row">
                <p class="sub-title">旅客評論</p>
                @if(!is_null($comment_list))
                @foreach($comment_list as $comment)
                <div class="single-comment col-sm-12">
                    <img class="d-flex mr-3 rounded-circle" width="50" height="50"
                        src={{url($comment->order->user->photo)}} alt="">
                    <div class="">
                        <p class="sub-title mt-0">
                            @for($s=1; $s<=5; $s++) @if ($s<=$comment->rating)
                                <img src={{url("/img/site/star.svg")}} alt="" width="21px" height="18px">
                                @else
                                <img src={{url("/img/site/star-o.svg")}} alt="" width="21px" height="18px">
                                @endif
                                @endfor
                                {{$comment->order->user->first_name}}
                        </P>
                        <p>使用日期: {{$comment->order->travel_date}}</p>
                        <div style="white-space:pre-wrap;">{{$comment->content}}</div>
                        <p class="text-muted">評論日期: {{$comment->created_at}}</p>
                    </div>
                    <hr>
                </div>
                @endforeach
                @endif
            </div>
            {{$comment_list->render('vendor.pagination.bootstrap-4')}}
        </div>

        <!--訂購卡-->
        <div class="order-card col-sm-12 col-md-4 justify-content-center mt-3" id="order-card">
            <div class="border text-center py-4">
                <p class="title">{{$tour->sub_title}}</p>
                <div class="text-left pl-5">
                    <div class="info mb-2">
                        <img src={{url("/img/site/location.svg")}} alt="" width="15px" height="15px">
                        <span class="pl-1">包含來回接送</span>
                    </div>
                    <div class="info mb-2">
                        <img src={{url("/img/site/star.svg")}} class="pb-1" alt="" width="15px" height="15px">
                        <span class="pl-1">中文導覽</span>
                    </div>
                    <div class="info mb-2">
                        <img src={{url("/img/site/star.svg")}} class="pb-1" alt="" width="15px" height="15px">
                        <span class="pl-1">可用電子票券</span>
                    </div>
                </div>
                <p class="title text-left pl-5">TWD {{$tour->price}}</p>
                <button class="btn button-light" data-toggle="modal" data-target="#order-modal">立即預訂</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<!-- initial calendar -->
<script>
    var datesEnabled = $('#available-date').text().split(',');

$('.date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    // startDate: "today",
    beforeShowDay: function (date) {
        var allDates = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
        if (datesEnabled.indexOf(allDates) != -1)
            return true;
        else
            return false;
    }
});
</script>
<!--sticky object-->
<script>
    window.onscroll = function() {myFunction()};
    var orderCard = document.getElementById("order-card");
    var sticky = orderCard.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            orderCard.classList.add("sticky")
        } else {
            orderCard.classList.remove("sticky");
        }
    }
</script>

<script>
    $('select').on('change', function(){
      $('#price').text(this.value*{{$tour->price}});
    });
</script>
<script>
    var userId = {{session()->get('user_id') ? session()->get('user_id') : 0}};
    if (userId === 0) {
        $('.favorite-tour img').attr('src', "/img/site/heart-o.svg");
    } else {
        if ({{$tour->favoriteTours->where('id', session()->get('user_id'))->count()}} != 0) {
                $('.favorite-tour  img').attr('src', "/img/site/heart.svg");
            }else{
                $('.favorite-tour  img').attr('src', "/img/site/heart-o.svg");
            }
        }

    $('.favorite-tour').on('click', function () {
        if (userId === 0) {
            $('#account-modal').modal('show');
        }
        else{
        $.ajax({
                type:'post',
                url:'/users/'+userId+'/favorite-tours',
                data:{
                    '_token': '{{csrf_token()}}',
                    'user_id': userId,
                    'tour_id': {{$tour->id}}
                },
                success:function(data){
                   if (data.isEnable === true) {
                    $('.favorite-tour  img').attr('src', "/img/site/heart.svg");
                   } else {
                    $('.favorite-tour  img').attr('src', "/img/site/heart-o.svg");
                   }
                },
                error:function(data){
                   alert("系統錯誤，請聯絡 THE TRIP TO [ ]");
                }
            });
        }
     });
</script>
@endsection

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

print_r(session()->getId());
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
    <div class="row justify-content-center text-sm-center">
        <div class="information col-sm-8 text-sm-left">
            <p class="title mx-auto">{{str_replace("]", "] ", $tour->title)}}</p>
            <p class="info">{{$tour->country}} | {{$tour->city}}</p>
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
        <div class="col-sm-8">
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
                    <img class="d-flex mr-3 rounded-circle" width="50" height="50" src={{url($comment->order->user->photo)}}
                        alt="">
                    <div class="">
                        <p class="sub-title mt-0">
                            @for($s=1; $s<=5; $s++)
                                @if ($s<=$comment->rating)
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
        <div class="order-card col-sm-4 justify-content-center mt-3" id="order-card">
            <div class="border text-center ml-4 py-4">
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
                <button class="btn button-light" data-toggle="modal"
                    data-target="#order-modal">立即預訂</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
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
<!-- initial HTML -->
<script type="text/javascript">
    // $(document).on('ready', function(){

    //     $('.carousel').carousel({interval: 5000});

    //     $('#favorite>img').attr('src', "");
    //     // $('#account-modal').modal('show');
    //     if (!{{empty(session()->has('user_id'))}}) {

    //     return;
    //     }

    });
    $(document).on('ready', function(){
            if (!{{empty(session()->has('id'))}}) {
                if ({{$tour->favoriteTours->where('id', session()->get('user_id'))->count()}} != 0) {
                    $('#wishlist').html("<i class='fa fa-heart' aria-hidden='true'></i>");
                    return;
                }
            }
            $('#pop-order-modal').prop('disabled', true );
            $('#wishlist').html("<i class='fa fa-heart-o' aria-hidden='true'></i>");
            $('#account-modal').modal('show');
            if (!{{empty(session()->has('url.intended'))}})
            {
                alert('ssse');
                if ({{session()->get('url.intended')}}) {
                    alert('sss');
                    $('#account-modal').modal('show');
                    return;
                }
            }
        });
</script>
<!--sticky object-->
<script type="text/javascript">
    window.onscroll = function() {myFunction()};
    var navbar = document.getElementById("order-card");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
        } else {
        navbar.classList.remove("sticky");
        }
    }
</script>

<script type="text/javascript">
    $('select').on('change', function(e){
      $('#price').text(this.value*{{$tour->price}});
    });
</script>
<script>
    $(document).on('ready', function(){
    $('#wishlist').click(function () {
        $.ajax({
               type:'post',
               url:'/user/{{session()->get('user_id')}}/wish-list',
               data:{
                    '_token': '{{csrf_token()}}',
                    'user_id': {{session()->get('user_id')}},
                    'tour_id': {{$tour->id}}
                },
               success:function(data){
                   if (data.isEnable === true) {
                        $('#wishlist').html("<i class='fa fa-heart' aria-hidden='true'></i>");
                   } else {
                        $('#wishlist').html("<i class='fa fa-heart-o aria-hidden='true'></i>");
                   }

               }
            });
     });
});
</script>
@endsection

@extends('layout.master')

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
<div class="container-fluid w-75">
    <div class="row justify-content-around mt-5">
        <div class="col-sm-3 text-center">
            <label for="photo">
                <div class="row">
                    <img src="{{session()->get('photo')}}" alt="user photo" class="rounded-circle mx-auto" />
                </div>
            </label>

            <ul class="list-group w-75 mx-auto sub-title my-4 py-2" id="user-control-items" style="line-height: 2em;">
                <a href="/users/{{session()->get('user_id')}}">個人檔案</a>
                <a href="/users/{{session()->get('user_id')}}/orders"><span>我的旅程</span></a>
                <a href="/users/{{session()->get('user_id')}}/favorite-tours" class="active"><span>我的收藏</span></a>
            </ul>
        </div>
        <div class="col-sm-9">
            <p class="sub-title">我的收藏</p>
            <hr style="height:1px; background-color:#23293132;">

            @if(!$favorite_tours->isEmpty())
            @foreach($favorite_tours as $tour)
            <a class="tour-link" href="/tours/{{$tour->id}}">
                <div class="row mb-4 border mx-0">
                    <div class="col-sm-4 pl-0">
                        <img style="width:100%; height:100%" src={{url($tour->photo)}} alt="暫時沒有圖片">
                    </div>
                    <div class="col-sm-8 d-flex flex-column justify-content-between pr-2 my-4">
                        <div class="row ml-0 mb-2">
                            <div class="tour-id" hidden>{{$tour->id}}</div>
                            <p class="sub-title m-0">{{$tour->title}}</p>
                            <button class="favorite-tour ml-2 mb-1"><img alt="收藏" style="width:1.5vw"></button>
                        </div>
                        <div class="m-0 d-flex flex-column">
                            <p class="introduction">{{$tour->introduction}}</p>
                        </div>
                        <div class="row d-flex justify-content-between mx-0">

                            <div class="d-flex flex-column">
                                <div class="info mb-1">
                                    <img src={{url("/img/site/location.svg")}} alt="" width="15px" height="15px">
                                    <span class="pl-1">包含來回接送</span>
                                </div>
                                <div class="info mb-1">
                                    <img src={{url("/img/site/star.svg")}} class="pb-1" alt="" width="15px"
                                        height="15px">
                                    <span class="pl-1">中文導覽</span>
                                </div>
                                <div class="rating info pr-2">
                                    @for($s=1; $s<=5; $s++) @if ($s<=$tour->rating)
                                        <img src={{url("/img/site/star.svg")}} alt="" width="15px" height="15px">
                                        @else
                                        <img src={{url("/img/site/star-o.svg")}} alt="" width="15px" height="15px">
                                        @endif
                                        @endfor
                                </div>
                            </div>
                            <div class="m-0 pr-2">
                                <p class="title">TWD {{$tour->price}}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
            @endforeach
            @else
            <div class="text-center">
                <h2>目前沒有收藏的行程!</h2>
            </div>
            @endif
            {{$favorite_tours->render('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    $(function(){
    var len = 50;
    $(".introduction").each(function(i){
        if($(this).text().length>len){
            // $(this).attr("title",$(this).text());
            var text=$(this).text().substring(0,len-1)+"...";
            $(this).text(text);
        }
    });
});
</script>
<script>
    var hasFavoriteTour = {{!$favorite_tours->isEmpty() ? 1 : 0}};
    if (hasFavoriteTour === 1) {
        $('.favorite-tour  img').attr('src', "/img/site/heart.svg");
    }
    $('.favorite-tour').on('click', function() {
        if (hasFavoriteTour === 1) {
            $.ajax({
                type: 'post',
                url: '/users/'+{{session()->get('user_id')}}+'/favorite-tours',
                data: {
                    '_token': '{{csrf_token()}}',
                    'user_id': {{session()->get('user_id')}},
                    'tour_id': $(this).parent().children().first().text()
                },
                success: function(data) {
                    location.reload();
                },
                error: function(data) {
                    alert("系統錯誤，請聯絡 THE TRIP TO [ ]");
                }
            });
        }
    });
</script>
@endsection

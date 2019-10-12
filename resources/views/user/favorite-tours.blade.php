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
<div class="container-fluid mt-5">
    <div class="row justify-content-around mx-auto mt-5" style="width: 85%;">
        <div class="col-lg-3 text-center">
            <label for="photo">
                <div class="row">
                    <img src="{{session()->get('photo')}}" alt="user photo" class="rounded-circle mx-auto" />
                </div>
            </label>

            <ul class="list-group mx-auto sub-title my-4 py-2" id="user-control-items" style="line-height: 2em;">
                <a href="/users/{{session()->get('user_id')}}">個人檔案</a>
                <a href="/users/{{session()->get('user_id')}}/orders"><span>我的旅程</span></a>
                <a href="/users/{{session()->get('user_id')}}/favorite-tours" class="active"><span>我的收藏</span></a>
            </ul>
        </div>
        <div class="col-lg-9">
            <p class="sub-title">我的收藏</p>
            <hr style="height:1px; background-color:#23293132;">

            @if(!$favorite_tours->isEmpty())
            @foreach($favorite_tours as $tour)

                <div class="row mb-4 border mx-0">
                    <a class="col-lg-4 pl-lg-0 p-0" href="/tours/{{$tour->id}}">
                        <img style="width:100%; height:100%;" src={{url($tour->photo)}} alt="暫時沒有圖片">
                    </a>
                    <div class="col-lg-8 d-flex flex-column justify-content-between pr-3 my-lg-2 mt-4">
                        <div class="row ml-0 my-2">
                            <div class="tour-id" hidden>{{$tour->id}}</div>
                            <a class="sub-title m-0" href="/tours/{{$tour->id}}">{{$tour->title}}</a>
                            <a class="favorite-tour btn-favorite ml-1 my-auto"><img alt="收藏"></a>
                        </div>
                        <div class="m-0 d-flex flex-column">
                            <p class="introduction">{{$tour->introduction}}</p>
                        </div>
                        <div class="row d-flex justify-content-between mx-0">
                            <div class="d-flex flex-column col-12">
                                <div class="info mb-1">
                                    <img src={{url("/img/site/bus.svg")}} alt="" width="15px" height="15px">
                                    <span class="pl-1">包含來回接送</span>
                                </div>
                                <div class="info mb-1">
                                    <img src={{url("/img/site/guide.svg")}} class="pb-1" alt="" width="16px"
                                        height="25px">
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
                            <div class="m-0 pt-2 pr-2 col-12">
                                <p class="title">TWD {{$tour->price}}</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                error: function(xhr, status, error) {
                    location.reload();
                    // alert("系統錯誤，請聯絡 THE TRIP TO [ ]");
                }
            });
        }
    });
</script>
@endsection

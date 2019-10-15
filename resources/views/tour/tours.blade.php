@extends('layout.master')

@section('title', $title)
@section('custom-css')
<link href="/css/bootstrap-slider.min.css" rel="stylesheet">
@php
// var_dump(isset($selected_options['price']));

@endphp
@endsection

@section('modal')
@include('component.account-modal')
@endsection

@section('header')
@include('component.header-search')
@endsection

@section('content')
<div class="container-fluid" style="width: 85%">
    <form action="/tours" method="get" class="filter">
        @switch (array_key_first($page))
            @case('search')
                <p class="title my-2">您搜尋的關鍵字 : {{$page['search']}}</p>
                <input type="text" name="search" value="{{$page['search']}}" hidden>
                @break
            @case('country')
                <p class="title my-2">{{$page['country']}} </p>
                <input type="text" name="country" value="{{$page['country']}}" hidden>
                <p class="info my-2"><a href="/" class="font-weight-bold">首頁</a>&nbsp;|&nbsp;{{$page['country']}}</p>
                @break
            @case('city')
                <p class="title my-2">{{$page['city']}} </p>
                <input type="text" name="city" value="{{$page['city']}}" hidden>
                <p class="info mb-2"><a href="/" class="font-weight-bold">首頁</a>&nbsp;|&nbsp;
                    <a href="/tours/?country={{$page['country']}}&sort=default" class="font-weight-bold">{{$page['country']}}</a>&nbsp;|&nbsp;
                    {{$page['city']}}</p>
                @break
            @default
                <p class="title my-2">系統錯誤，請重新搜尋</p>
                @break
        @endswitch
        <p class="font-weight-bold">找到 {{$tour_list->total()}} 個經典行程</p>
        <hr style="height:1px; background-color:#23293132;">
        <div class="row justify-content-end m-0">
            <div class="form-group float-right">
                <label for="sort">排序 :&nbsp;</label>
                <select class="form-control-sm" id="sort" name="sort">
                    <option value="default">關聯性</option>
                    <option value="price_asc" @if("price_asc"==$sort) selected @endif>
                        價格:低->高</option>
                    <option value="price_desc" @if("price_desc"==$sort) selected @endif>
                        價格:高->低</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-around mx-0">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12 mb-4 py-4 border">
                        <p class="pl-4 font-weight-bold">已選擇</h5>
                            <div class="row ml-5 mr-1">
                            @if(isset($selected_options))
                                @foreach($selected_options as $filter => $options)
                                    @if ($filter == 'price')
                                        <button type="button" class="condition btn button-dark float-left p-0 m-1" id="price">
                                            <span class="badge badge-lg">{{explode(',', $selected_options['price'])[0]}} ~ {{explode(',', $selected_options['price'])[1]}} <i class="fa fa-times"></i></span>
                                        </button>
                                        @continue
                                    @endif
                                    @foreach ( $options as $option)
                                        <button type="button" class="condition btn button-dark float-left p-0 m-1" id="{{$option}}">
                                            <span class="badge badge-lg">{{$option}} <i
                                                    class="fa fa-times"></i></span>
                                        </button>
                                    @endforeach
                                @endforeach
                            @endif
                            </div>
                            @if(isset($initial_options))
                            @foreach($initial_options as $filter => $options)
                                @if ($filter == 'price')
                                    <hr style="height:1px; left:0; background-color:#23293132;">
                                    <p class="pl-4 font-weight-bold">價格 (TWD)</h5>
                                        <div class="row mx-4">
                                        @if (isset($selected_options['price']))
                                        <p id="price-interval" class="col-12 pl-0">{{explode(',', $selected_options['price'])[0]}} ~ {{explode(',', $selected_options['price'])[1]}}</p>
                                        <input
                                            type="text"
                                            id="price-bar"
                                            name="price"
                                            class="span2 s2"
                                            data-provide="slider"
                                            data-slider-min="{{$initial_options['price']['min']}}"
                                            data-slider-max="{{$initial_options['price']['max']}}"
                                            data-slider-step="100"
                                            data-slider-value="[{{explode(',', $selected_options['price'])[0]}},{{explode(',', $selected_options['price'])[1]}}]"
                                        >
                                        @else
                                        <p id="price-interval" class="col-12 pl-0">{{$initial_options['price']['min']}} ~ {{$initial_options['price']['max']}}</p>
                                        <input
                                            type="text"
                                            id="price-bar"
                                            name="price"
                                            class="span2 s2"
                                            data-provide="slider"
                                            data-slider-min="{{$initial_options['price']['min']}}"
                                            data-slider-max="{{$initial_options['price']['max']}}"
                                            data-slider-step="100"
                                            data-slider-value="[{{$initial_options['price']['min']}},{{$initial_options['price']['max']}}]"
                                        >
                                        @endif
                                    </div>
                                    @continue
                                @endif
                            <hr style="height:1px; left:0; background-color:#23293132;">
                            <p class="pl-4 font-weight-bold">@if($filter == "country") 國家 @else 城市 @endif</h5>
                                @foreach ( $options as $option)
                                <div class="form-check pl-5">
                                    <input type="checkbox" class="form-check-input" name="m_{{$filter}}[]"
                                        value="{{$option}}"  @if(isset($selected_options['m_'.$filter]) && in_array($option, $selected_options['m_'.$filter])) checked @endif>
                                    <label class="" for="exampleCheck1">{{$option}}</label>
                                </div>
                                @endforeach
                            @endforeach
                            @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row ml-lg-0">
                    @if(!$tour_list->isEmpty())
                    @foreach($tour_list as $tour)
                    <a href="/tours/{{$tour->id}}">
                        <div class="row mb-4 border mx-0">
                            <div class="col-lg-4 pl-lg-0 p-0">
                                <img style="width:100%; height:100%" src={{url($tour->photo)}} alt="暫時沒有圖片">
                            </div>
                            <div class="col-lg-8 col-12 d-flex flex-column justify-content-between pr-2">
                                <div class="m-0 d-flex flex-column">
                                    <p class="sub-title m-0 pt-2">{{$tour->title}}</p>
                                </div>
                                <div class="m-0 d-flex flex-column">
                                    <p class="introduction pt-2">{{$tour->introduction}}</p>
                                </div>
                                <div class="row d-flex justify-content-between mx-0 pb-2">

                                    <div class="d-flex flex-column">
                                        <div class="info mb-1">
                                            <img src={{url("/img/site/bus.svg")}} alt="交通方式" width="20px"
                                                height="15px">
                                            <span class="pl-1">包含來回接送</span>
                                        </div>
                                        <div class="info mb-1">
                                            <img src={{url("/img/site/guide.svg")}} class="pb-1" alt="導覽" width="20px"
                                                height="20px">
                                            <span class="pl-1">中文導覽</span>
                                        </div>
                                        <div class="rating info pr-2">
                                            @for($s=1; $s<=5; $s++) @if ($s<=$tour->rating)
                                                <img src={{url("/img/site/star.svg")}} alt="" width="15px"
                                                    height="15px">
                                                @else
                                                <img src={{url("/img/site/star-o.svg")}} alt="" width="15px"
                                                    height="15px">
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
                        <h2>目前沒有相關的行程!</h2>
                    </div>
                    @endif
                </div>
                {{$tour_list->appends([array_key_first($page) => reset($page)])
                ->appends(['sort' => $sort])
                ->appends($selected_options)
                ->render('vendor.pagination.bootstrap-4')}}
            </div>
        </div>
    </form>
</div>
@endsection

@section('custom-js')
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/bootstrap-slider.min.js"></script>
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
var hasSelectedPrice = {{isset($selected_options['price']) ? 1 : 0}};
$(function() {
//filter
$(".filter input").on('click', function(){
    if(!hasSelectedPrice){
        $("#price-bar").prop("disabled", true);
    }
    $('.filter').submit();
});
//sorter
$("#sort").on('change', function(){
    if(!hasSelectedPrice){
        $("#price-bar").prop("disabled", true);
    }
    $('.filter').submit();
});
//badges
$(".condition").on('click', function(){
var id = this.id;
if (id == "price") {
    $("#price-bar").prop("disabled", true);
} else {
    $(":checked").each( function(index,element) {
        if (id == $(element).prop("value")) {
            $(element).prop("checked", false);
        }
    });
    if(!hasSelectedPrice){
        $("#price-bar").prop("disabled", true);
    }
}
$('.filter').submit();
});
//price bar
$('.s2').on({
    change: function (e) {
        $('#price-interval').text($("#price-bar").val().replace(',', ' ~ '));
    },
    slideStop: function (e) {
        $('.filter').submit();
    }
});

});

</script>
@endsection

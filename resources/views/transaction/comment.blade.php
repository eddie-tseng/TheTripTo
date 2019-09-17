@extends('layout.master')

@section('custom-css')
<link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
@php
// print_r($tour);
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
    <div class="row justify-content-between">
        <div class="col-sm-4 pl-4 pt-4" style="background-color: #ffb400bf">
            <div class="text-center my-4">
                <img src="{{url($tour->photo)}}" class="w-100" alt="">
            </div>

            <p class="sub-title text-left ml-2">{{$tour->title}}</p>
            <hr class="w-100" style="height:1px; background-color:#23293132;">

            <p class="sub-title text-left ml-2">行程日期 : {{$order->travel_date}}</p>
        </div>
        <div class="col-sm-8 pl-5 pr-4 my-5">
            @include('validationfail')
            <form action="/transaction/{{$order->id}}/comment" method="post">
                <div class="form-group">
                    <p class="sub-title text-left">旅遊評論</p>
                    <hr class="" style="height:1px; background-color:#23293132;">
                    <label for="recommend-value" class="">請給這次的旅行打個分數吧</label>
                    <input id="recommend-value" name="rating" class="rating-loading" data-size="xs" value="{{old('rating')}}" required>
                </div>
                <div class="form-group">
                    <label for="comment-context" class="my-4">旅行心得</label>
                    <textarea class="form-control" name="content" id="comment-context"
                        style="width:400;height:300px;max-width:400;max-height:300px;" maxlength="500"
                        placeholder="您覺得這次的旅行如何呢?" required>{{old('content')}}</textarea>
                </div>
                <div class="row justify-content-center my-5">
                    <button type="submit" class="btn-lg button-light w-25 mx-auto">送出</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="/js/star-rating.js" type="text/javascript"></script>
<script src="/js/bootstrap-maxlength.js" type="text/javascript"></script>
<script>
    $(document).on('ready', function(){
        $('#recommend-value').rating({
            step:1,
            hoverEnabled: false,
            showCaption: false,
            showClear: false,
            // data-size="md"
        });
        $('#comment-context').maxlength({
            alwaysShow: true,
            warningClass: "form-text text-muted mt-1",
            limitReachedClass: "form-text text-danger mt-1",
            showMaxLength: true,
            showCharsTyped: true,
            placement: 'bottom-left-inside',
        });
    });
</script>
@endsection

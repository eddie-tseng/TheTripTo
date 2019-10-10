@extends('layout.master')

@section('title', $title)
@section('custom-css')

@endsection

@section('modal')
@include('component.account-modal')
@endsection

@section('header')

@extends('component.header')
@section('search-link')
<a id="search-link" class="navbar-nav ml-auto mr-4" data-toggle="modal" data-target="#search-modal">
    <img src={{url("/img/site/search.svg")}} alt="search" width="18" height="18">
</a>
<form action="/tours" method="get">
    @include('component.search-modal')
</form>
@endsection

@endsection


@section('banner')
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block" src={{url("/img/site/IMG_9264.jpg")}} alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block" src={{url("/img/site/IMG_1652.jpg")}} alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block" src={{url("/img/site/IMG_1278.jpg")}} alt="Third slide">
        </div>
        <div class="carousel-caption">
            <p class="text-white" id="slogan">帶您深入世界的每個角落，體驗在地生活</p>
        </div>
    </div>
    <form action="/tours" method="get">
        <div class="search col-8">
            <div class="input-group col-8 mx-auto p-0">
                <input type="text" class="text-search form-control" id="search" name="search" data-toggle="dropdown"
                    aria-haspopup="false" aria-expanded="false" autocomplete="off" value="" placeholder="輸入關鍵字...">
                <span class="input-group-btn">
                    <button class="btn-search btn btn-block" type="button">
                        <img src={{url("/img/site/search.svg")}} alt="" width="35" height="35">
                    </button>
                </span>
                <ul class="search-result dropdown-menu col-12 pl-2"></ul>
            </div>
            <input type="text" class="form-control" name="sort" value="default" hidden>
        </div>
    </form>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
@endsection

@section('content')

<div class="caption text-center">
    <h1>探索全世界</h1>
</div>

<div class="popular-spot px-4 mb-4">
    <p class="title text-center m-0">熱門景點</p>
    <div class="row mt-4">
        @for ($i = 0; $i < 4; $i++)
            <div class="col-lg-6 mt-4">
                @include('component.tour-2card')
            </div>
        @endfor
    </div>
</div>

<div class="popular-country px-4">
    <p class="title text-center m-0">熱門目的地</p>
    <div class="row d-flex justify-content-between mx-1">
        <a href="/tours?country=日本&sort=default"
            class="country col-lg-4 text-center text-decoration-none text-white">
            日本
        </a>

        <a href="/tours?country=韓國&sort=default"
            class="country col-lg-4 text-center text-decoration-none">
            韓國
        </a>
        <a href="/tours?country=泰國&sort=default"
            class="country col-lg-4 text-center text-decoration-none">
            泰國
        </a>
    </div>
</div>

<div class="classic-tour px-4">
    <p class="title text-center m-0">精選推薦</p>
    <div class="row mt-4">
        @for ($i = 4; $i < 8; $i++)
            <div class="col-lg-6 mt-4">
                @include('component.tour-2card')
            </div>
        @endfor
    </div>
</div>

@endsection

@section('custom-js')
<!-- initial HTML -->
<script type="text/javascript">
    $(document).on('ready', function(){
        $('.carousel').carousel({interval: 5000});
    });

</script>
<script>
        var userId = {{session()->get('user_id') ? session()->get('user_id') : 0}};

        $('.favorite-tour').on('click', function () {
            if (userId === 0) {
                $('#account-modal').modal('show');
            }
            else{
                var btnFavoriteTour = $(this).children();
                $.ajax({
                    type:'post',
                    url:'/users/'+userId+'/favorite-tours',
                    data:{
                        '_token': '{{csrf_token()}}',
                        'user_id': userId,
                        'tour_id': $(this).parent().children().first().text()
                    },
                    success:function(data){
                       if (data.isEnable === true) {
                        btnFavoriteTour.attr('src', "/img/site/heart.svg");
                       } else {
                        btnFavoriteTour.attr('src', "/img/site/heart-o.svg");
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

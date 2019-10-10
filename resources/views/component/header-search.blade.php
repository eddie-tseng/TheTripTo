@extends('component.header')

@section('search')
<div class="search navbar-nav mr-auto">
    <form action="/tours" method="get">
        <div class="col-12 m-auto p-0">
            <div class="input-group col-12 ml-5 p-0">
                <input type="text" class="text-search form-control" name="search" data-toggle="dropdown"
                    data-target="#search-result-lg" aria-haspopup="false" aria-expanded="false" autocomplete="off"
                    value="" placeholder="輸入關鍵字...">
                <span class="input-group-btn">
                    <button class="btn-search btn btn-block" type="button">
                        <img src={{url("/img/site/search.svg")}} alt="search">
                    </button>
                </span>
                <ul class="search-result dropdown-menu col-12 pl-2" id="search-result-lg"></ul>
            </div>
            <input type="text" class="form-control" name="sort" value="default" hidden>
        </div>
    </form>
</div>

<a id="search-link" class="navbar-nav ml-auto mr-4" data-toggle="modal" data-target="#search-modal">
    <img src={{url("/img/site/search.svg")}} alt="search" width="18" height="18">
</a>
<form action="/tours" method="get">
    @include('component.search-modal')
</form>

@endsection

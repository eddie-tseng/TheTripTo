@extends('component.header')

@section('search')

<form action="/tour/tour-list/search/" method="get">
     <div class="search col-sm-12 m-auto p-0 ">
        <div class="input-group col-sm-12 ml-5 p-0">
            <input type="text" class="form-control" id="search" name="search" data-toggle="dropdown" data-target="#search-result"
                aria-haspopup="false" aria-expanded="false" autocomplete="off" value="" placeholder="輸入關鍵字...">
            <span class="input-group-btn">
                <button class="btn btn-block" type="button" id="btn-search">
                    <img src={{url("/img/site/search.svg")}} alt="search" width="25" height="25">
                </button>
            </span>
            <ul class="dropdown-menu col-sm-12" id="search-result"></ul>
        </div>
        <input type="text" class="form-control" name="sort" value="default" hidden>
 </div>
</form>

@endsection

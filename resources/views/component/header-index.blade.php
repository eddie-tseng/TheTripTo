@include('component.header')

@section('search')
<a id="search-link" class="navbar-nav ml-auto mr-4" data-toggle="modal" data-target="#search-modal">
    <img src={{url("/img/site/search.svg")}} alt="search" width="18" height="18">
</a>
<form action="/tours" method="get">
    @include('component.search-modal')
</form>
@endsection

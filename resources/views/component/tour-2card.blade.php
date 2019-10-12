<div class="tour-card h-100" style="border-width:0 0 10px 0;border-style:solid; border-color:#232931;">
    <a href="/tours/{{$tours[$i]->id}}" class="btn btn-card h-60 w-100 p-0">
        <img class="card-img-top h-100" src="{{url($tours[$i]->photo)}}" alt="Card image cap">
    </a>
        <div class="h-40 d-flex justify-content-between flex-column">
            <div class="p-0 h-75 d-flex justify-content-center flex-column">
                <div class="my-1 d-flex justify-content-between">
                    <div class="tour-id" hidden>{{$tours[$i]->id}}</div>
                    <a href="/tours/{{$tours[$i]->id}}" class="card-text title my-auto">
                        {{$tours[$i]->title}}
                    </a>
                    <a class="favorite-tour btn-favorite my-auto">
                        <img src={{$tours[$i]->favoriteTours->where('id', session()->get('user_id'))->count()!= 0 ? "/img/site/heart.svg" : "/img/site/heart-o.svg"}}
                         alt="收藏">
                    </a>
                </div>
                <div class="my-1 d-flex justify-content-between">
                    <div class="row p-0 mx-0">
                        <div class="location pr-4 my-auto">
                            <img src={{url("/img/site/location.svg")}} alt="地點" width="10vw">
                            <span class="pl-1 content">{{$tours[$i]->country}}，{{$tours[$i]->city}}</span>
                        </div>
                        <div class="sold my-auto">
                            <img src={{url("/img/site/plus.svg")}} alt="參加人數" class="mb-1" width="14vw" >
                            <span class="pl-1 content">已有<span class="font-weight-bold">{{$tours[$i]->sold}}</span>人參加</span>
                        </div>
                    </div>

                    <div>
                        @for($s=1; $s<=5; $s++)
                            @if ($s<=$tours[$i]->rating) <img src={{url("/img/site/star.svg")}} alt="評分"
                            width="14vw">
                            @else
                                <img src={{url("/img/site/star-o.svg")}} alt="評分-o" width="14vw">
                            @endif
                        @endfor
                    </div>
                </div>

            </div>
            <hr class="m-0" style="height:2px; border: none; background-color: #232931;">
            <div class="h-25 text-center" style="display: inline-block; line-height:45px" >
                <p class="card-text" style="font-size: 1.5rem; color: #232931; font-weight: 600;">TWD
                    {{$tours[$i]->price}}</p>
            </div>
        </div>

</div>

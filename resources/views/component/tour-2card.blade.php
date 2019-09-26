<div class="tour-card h-100" style="border-width:0 0 10px 0;border-style:solid; border-color:#232931;">
    <a href="/tours/{{$tours[$i]->id}}" class="btn btn-card h-50 w-100">
        <img class="card-img-top h-100" src="{{url($tours[$i]->photo)}}" alt="Card image cap">
    </a>
        <div class="h-50 d-flex justify-content-between" style="flex-direction:column">
            <div class="p-0 h-75 d-flex justify-content-center" style="flex-direction:column">
                <div class="my-1 d-flex justify-content-between">
                    <div class="tour-id" hidden>{{$tours[$i]->id}}</div>
                    <p class="card-text" style="font-size: 1.5rem; color: #232931; font-weight: 600;">
                        {{$tours[$i]->title}}
                    </p>
                    <button class="favorite-tour my-auto">
                        <img src={{$tours[$i]->favoriteTours->where('id', session()->get('user_id'))->count()!= 0 ? "/img/site/heart.svg" : "/img/site/heart-o.svg"}}
                         alt="收藏" width="24px" height="22px">
                    </button>
                </div>
                <div class="my-1 d-flex justify-content-between">
                    <div class="row p-0 mx-0">
                        <div class="location pr-4 my-auto" style="font-size: 1.125rem; color: #232931; ">
                            <img src={{url("/img/site/location.svg")}} alt="" width="18px" height="26px">
                            <span class="pl-1">{{$tours[$i]->country}}，{{$tours[$i]->city}}</span>
                        </div>
                        <div class="sold my-auto" style="font-size: 1.125rem; color: #232931; ">
                            <img src={{url("/img/site/plus.svg")}} alt="" width="25px" height="25px">
                            <span class="pl-1">已有{{$tours[$i]->sold}}人參加</span>
                        </div>
                    </div>

                    <div>
                        @for($s=1; $s<=5; $s++)
                            @if ($s<=$tours[$i]->rating) <img src={{url("/img/site/star.svg")}} alt=""
                                width="21px" height="18px">
                            @else
                                <img src={{url("/img/site/star-o.svg")}} alt="" width="21px" height="18px">
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

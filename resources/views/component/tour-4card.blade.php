<div class="tour-card h-100" style="border-width:0 0 10px 0;border-style:solid; border-color:#232931;">
        <a href="/tour/{{$tours[$i]->id}}" class="btn btn-card">
            <img class="card-img-top" src="{{url($tours[$i]->photo)}}" alt="Card image cap">
            <div class="card-body p-0">
                <div class="mb-4 d-flex justify-content-between">
                    <p class="card-text" style="font-size: 0.9rem; color: #232931; font-weight: 600;">{{$tours[$i]->title}}</p>
                    <a href="/" class="my-auto"  id="favorite">
                        <img src={{url("/img/site/heart-o.svg")}} alt="" width="12px" height="11px">
                    </a>
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <div class="row p-0 mx-0">
                        <div class="location pr-2 mx-0 my-auto" style="font-size: 0.7rem; color: #232931; ">
                            <img src={{url("/img/site/location.svg")}} alt="" width="9px" height="13px">
                            <span class="pl-1">{{$tours[$i]->country}}，{{$tours[$i]->city}}</span>
                        </div>
                        <div class="sold mx-0 my-auto" style="font-size: 0.6rem; color: #232931; ">
                            <img src={{url("/img/site/plus.svg")}} alt="" width="12px" height="12px">
                            <span class="pl-1">已有{{$tours[$i]->sold}}人參加</span>
                        </div>
                    </div>

                    <div>
                        @for($s=1; $s<=5; $s++)
                        @if ($s<=$tours[$i]->rating) <img src={{url("/img/site/star.svg")}} alt=""
                            width="10px" height="9px">
                            @else
                            <img src={{url("/img/site/star-o.svg")}} alt="" width="10px" height="9px">
                            @endif
                            @endfor
                    </div>
                </div>

            </div>
            <hr class="m-0" style="height:2px; border: none; background-color: #232931;">
            <div>
                <p class="card-text text-center py-2" style="font-size: 1.5rem; color: #232931; font-weight: 600;">TWD
                    {{$tours[$i]->price}}</p>
            </div>
        </a>
    </div>

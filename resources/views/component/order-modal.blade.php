<div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/transaction" method="post">
                <div class="modal-header">
                    <p class="sub-title mx-auto">{{str_replace("]", "] ", $tour->title)}}</p>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                        <img src={{url("/img/site/close.svg")}} alt="" width="30px" height="30px">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="tour_id" value="{{$tour->id}}" hidden/>
                    <div class="row text-laft">
                        <div class="form-group col-md-10">
                            <div class="input-group date" style="cursor: pointer">
                                <label for="travel-date" class="my-auto mr-4">請選擇活動日期</label>
                                <input type="text" class="form-control pr-4" id="travel-date" name="travel_date"
                                    autocomplete="off" placeholder="請選擇日期" value="{{old('travel_date')}}" />
                                <div class="input-group-append">
                                    <span class="input-group-text fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-laft">
                        {{-- <div class="col-md-8">
                                {{$tour->sub_title}}
                    </div> --}}
                    <div class="form-group col-md-4 pr-0">
                        <label for="quantity" class="mr-2">數量</label>
                        <select name="quantity" id="quantity">
                            @for($count = 1; $count <= $tour->inventory-$tour->sold; $count++)
                                <option value="{{ $count }}">{{ $count }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="form-group col-md-4 pl-0">
                        <p class="">每人 TWD {{$tour->price}}</p>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <div class="row mr-auto">
                <p>&nbsp;&nbsp;TWD&nbsp;<span>
                        <p id="price">{{$tour->price}}</p>
                    </span></p>
            </div>
            <button type="submit" class="btn btn-primary">送出訂單</button>
        </div>
        {{ csrf_field() }}
        </form>

    </div>
</div>
</div>

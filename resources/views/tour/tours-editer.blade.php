<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- 放分頁的icon -->
        <link href="/docs/4.0/assets/img/favicons/favicon.ico" rel="icon">
        <title>
            Floating labels example for Bootstrap
        </title><!-- Bootstrap core CSS -->

        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

        <!-- Custom styles for this template -->

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                        @php
                        echo $Tour->AvailableDates->implode('available_date', ',');
                        @endphp
                    @include('validationfail')
                    <form action="/tour/{{$Tour->id}}" method="post" enctype="multipart/form-data">
                        {{method_field('PUT')}}
                        <div class="row">
                                <div class="form-group col-md-4">
                                        <label for="title">行程標題</label>
                                        <input class="form-control" id="title" name="title" type="text" value="{{old('title', $Tour->title)}}">
                                    </div>
                            <div class="form-group col-md-2">
                                    <label for="status"></label>
                                    <select class="form-control"
                                            name="status"
                                            id="status"
                                    >
                                        <option value="C"
                                                @if(old('status', $Tour->status)=='C') selected @endif
                                        >
                                            建構中
                                        </option>
                                        <option value="R"
                                                @if(old('status', $Tour->status)=='R') selected @endif
                                        >
                                            已上線
                                        </option>
                                    </select>
                            </div>



                        </div>

                        <div class="form-group col-md-6">
                            <label for="introduction">行程簡介</label>
                        <textarea class="form-control" id="introduction" name="introduction" type="text" rows="10">{{old('introduction', $Tour->introduction)}}</textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="sub_title">套餐名稱</label>
                                <input class="form-control" id="sub_title" name="sub_title" type="text" value="{{old('sub_title', $Tour->sub_title)}}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="price">套餐價格</label>
                                <input class="form-control" id="price" name="price" type="number" min="0" value="{{old('price', $Tour->price)}}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="inventory">套餐限額</label>
                                <input class="form-control" id="inventory" name="inventory" type="number" min="0" value="{{old('inventory', $Tour->inventory)}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                                <label for="available_date">可使用日期</label>
                        <input class="form-control date" id="available_date" name="available_date" type="text" value="{{$Tour->AvailableDates->implode('available_date', ',')}}">
                            </div>
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label for="country">國家</label>
                                <input class="form-control" id="country" name="country" type="text" value="{{old('country', $Tour->country)}}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="city">城市</label>
                                <input class="form-control" id="city" name="city" type="text" value="{{old('city', $Tour->city)}}">
                            </div>
                            <div class="form-group col-md-2">
                                    <label for="latitude">GPS:緯度</label>
                                    <input class="form-control" id="latitude" name="latitude" type="text" value="{{old('latitude', $Tour->latitude)}}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="longitude">經度</label>
                                    <input class="form-control" id="longitude" name="longitude" type="text" value="{{old('longitude', $Tour->longitude)}}">
                                </div>

                        </div>

                                <div class="form-group col-md-4">
                                        <label for="photo">圖片</label>
                                        <input class="form-control-file" id="photo" name="photo" type="file">
                                        <img src="{{ $Tour->photo }}" alt="請放照片" />
                                    </div>




                            <button class="btn btn-dark" type="submit">儲存</button>
                    {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
        <script type="text/javascript">

$('.date').datepicker({
    multidate: true,
    format: "yyyy-mm-dd",
});

// var dateAdded = "{{$Tour->AvailableDates->implode('available_date', ',')}}";
// console.log('$dateAdded');

// var dates = [];
// $.each(dateAdded, function(i, dateStr){
//     var d = new Date();
//     var dateArray = dateStr.split("/");
//     d.setFullYear(parseInt(dateArray[0]));
//     d.setMonth(parseInt(dateArray[1])-1);
//     d.setDate(parseInt(dateArray[2]));
//     dates.push(d);
// });


$('.date').datepicker('setDates')

        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/album.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">defer </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
@php
    $d=$Order->tour->id;
    echo $d;

@endphp
<body>
@include('component.header-search')
<div class="container mt-4">
    <div class="row" style="background-color:gainsboro">
        <div class="col-md-6">
            <h4>
                <span class="badge badge badge-success">已付款</span>
                訂單編號: {{str_pad($Order->id, 5, '0', STR_PAD_LEFT)}}
            </h4>
            <div>
                <p>購買日期: {{$Order->created_date}}</p>
                <p>總金額: TWD {{$Order->price*$Order->quantity}}</p>
            </div>

        </div>
        <div class="col-md-2 offset-3 my-auto">
            {{-- <a name="" id="" class="btn-lg btn-dark" href="#" role="button" >發表評論</a> --}}
            @if (is_null($Order->comment))
            <a href="/transaction/{{$Order->id}}/comment" class="btn btn-dark pl-2">給予評論</a>
            @else
            <a href="/transaction/{{$Order->id}}/comment" class="btn btn-dark pl-2 disabled" aria-disabled="true">給予評論</a>
            @endif
        </div>
    </div>
    <hr>
    <div class="row justify-content-between">
        <div class="col-md-7" style="background-color:gainsboro">
                <img src="{{url($Order->tour->photo)}}" class="img-fluid mt-4" alt="此圖片暫時無法顯示">
                <h4 class="mt-4">{{$Order->tour->title}}</h4>
                <div class="row justify-content-between mt-4">
                    <div class="col-md-8">
                        <p><strong>{{$Order->tour->sub_title}}</strong></p>
                        <p><strong><br>使用日期</strong></p>
                    </div>
                    <div class="col-md-4">
                        <p>{{$Order->quantity}}人</p>
                        <p><br>{{$Order->travel_date}}</p>
                    </div>
                </div>
        </div>
        <div class="col-md-4 ml-5" style="background-color:gainsboro">
                <h4>旅客資料</h4>
                <ul class="nav nav-tabs" id="tabs">
                        @for ($i = 1; $i <=$Order->quantity ; $i++)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tourist{{$i}}">旅客{{$i}}</a>
                        </li>
                        @endfor
                    </ul>

                    <div class="tab-content">
                        @for ($i = 1; $i <= $Order->quantity; $i++)
                        <div id="tourist{{$i}}" class="tab-pane fade">
                            <div class="row justify-content-between mt-4">
                                <div class="col-md-6">
                                    <p><strong>旅客姓名</strong></p>
                                    <p><strong><br>性別</strong></p>
                                    <p><strong><br>連絡電話</strong></p>
                                    <p><strong><br>電子郵件</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$Order->tourists[$i-1]->last_name}}&nbsp;
                                        {{$Order->tourists[$i-1]->first_name}}
                                    </p>
                                    <p><br>{{$Order->tourists[$i-1]->gender}}</p>
                                    <p><br>{{$Order->tourists[$i-1]->phone}}</p>
                                    <p><br>{{$Order->tourists[$i-1]->mail}}</p>
                                </div>
                            </div>
                        </div>
                        @endfor

        </div>
    </div>
</div>
@include('component.footer')
<!--custom JavaScript-->
<script  type="text/javascript">
    $(function () {
        $('#tabs li:eq(0) a').tab('show');
    });
</script>
</body>
</html>

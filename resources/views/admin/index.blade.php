@extends('layouts.master')  @section('mainRows')     @parent
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>

        </ol>
    </div><!--/.row-->
    <script>
        var lineChartData = {
        labels: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", 'Август', 'Сентябрь'
                , 'Октябрь', 'Ноябрь', 'Декабрь'],
                datasets: [
                {
                label: "Users",
                        fillColor: "rgba(48, 164, 255, 0.2)",
                        strokeColor: "rgba(48, 164, 255, 1)",
                        pointColor: "rgba(48, 164, 255, 1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(48, 164, 255, 1)",
                        data: [
                                @foreach($line_users as $line)
                        {{ $line }},
                                @endforeach
                        ]
                }
                ]

        }
        window.onload = function () {
        var chart1 = document.getElementById("line-chart").getContext("2d");
                window.myLine = new Chart(chart1).Line(lineChartData, {
        responsive: true
        });
        };
    </script>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Главная</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked bag"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-bag"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{ $events }}</div>
                        <div class="text-muted">Акции</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked empty-message"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-empty-message"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{ $reviews }}</div>
                        <div class="text-muted">Обзоры</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked male-user"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-male-user"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{ $users }}</div>
                        <div class="text-muted">Пользователи</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked app-window-with-content"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-app-window-with-content"></use></svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{$views/1000}}k</div>
                        <div class="text-muted">Просмотрено</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Пользователи</div>
                <div class="panel-body">
                    <div class="canvas-wrapper">
                        <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div>
            <div class="panel panel-default chat">
                <div class="panel-heading" id="accordion"><svg class="glyph stroked two-messages"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-two-messages"></use></svg> Уведомления</div>
                <div class="panel-body">
                    <ul>
                        @foreach($messages['remain'] as $message)
                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle">
                            </span>
                            <div class="chat-body clearfix">
                                <div cl ass="header">
                                    <strong class="primary-font">System</strong> <small class="text-muted">{{$message['ago']}} {{$message['ago_type']}} осталось</small>
                                </div>
                                <p>
                                    @if($message['type'] == 'shop')
                                        Заведение:
                                    @elseif($message['type'] == 'event')
                                        Акция
                                    @endif
                                    <a href='/admin/{{$message['type']}}/{{$message['id']}}'>{{$message['title']}}</a> скоро будет убрано из показа 
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>


                <!--<div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here...">
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-md" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>-->
            </div>
            <div class="panel panel-default chat">
                <div class="panel-heading" id="accordion"><svg class="glyph stroked two-messages"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-two-messages"></use></svg> Предупреждения</div>
                <div class="panel-body">
                    <ul>
                        
                        @foreach($messages['stoped'] as $message)
                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle">
                            </span>
                            <div class="chat-body clearfix">
                                <div cl ass="header">
                                    <strong class="primary-font">System</strong> <small class="text-muted">{{$message['ago']}} {{$message['ago_type']}} назад</small>
                                </div>
                                <p>
                                    @if($message['type'] == 'shop')
                                        Заведение:
                                    @elseif($message['type'] == 'event')
                                        Акция
                                    @endif
                                    <a href='/admin/{{$message['type']}}/{{$message['id']}}'>{{$message['title']}}</a> было убрано из показа 
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>


                <!--<div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here...">
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-md" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>-->
            </div>

        </div>
    </div>
</div>	<!--/.main-->
@endsection
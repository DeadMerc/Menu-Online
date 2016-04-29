@extends('layouts.master')
@section('mainRows')

    @parent

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg>
                    </a></li>

            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Заведение</h1>
            </div>
        </div><!--/.row-->


        <div class="row mainRow ">
            @if(isset($item->id))
                {!! Form::model($item, ['id'=>'shopTableAdd','method'=>'PUT','route' => array('api.shops.update', $item->id)]) !!}
                {!! Form::hidden('id', $item->id) !!}
            @else
                {!! Form::open(['id'=>'shopTableAdd','method' => 'POST', 'action' => 'ShopsController@store']) !!}
            @endif
            <div class="form-group">
                <label for="sel1">Выберите категорию</label>
                <select name="category_id" class="form-control">
                    <option disabled selected>-- Выберите --</option>
                    <?php
                    //var_dump($categories);
                    ?>
                    @foreach($categories as $category)
                        <optgroup label="{{$category['main']['name']}}">
                            @if(isset($category['childrens']))
                                @foreach($category['childrens'] as $children)
                                    <option value="{{$children['id']}}">{{$children['name']}}</option>
                                @endforeach
                            @endif
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('city_id', 'Город') !!}
                {!! Form::select('city_id',$cities,null,array('class'=>'form-control','placeholder'=>'City_id')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('title', 'Title') !!}
                {!! Form::textarea('title',null,array('class'=>'form-control','placeholder'=>'Title')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description',null,array('class'=>'form-control','placeholder'=>'Description')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('time', 'Время работы заведения') !!}
                {!! Form::text('time',null,array('class'=>'form-control','placeholder'=>'Time work shop')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', 'Телефон') !!}
                {!! Form::text('phone',null,array('class'=>'form-control','placeholder'=>'Phone')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('street', 'Улица') !!}
                {!! Form::text('street',null,array('class'=>'form-control','placeholder'=>'Street')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('lat', 'Широта') !!}
                {!! Form::text('lat',null,array('class'=>'form-control','placeholder'=>'Широта')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('lon', 'Долгота') !!}
                {!! Form::text('lon',null,array('class'=>'form-control','placeholder'=>'Долгота')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('date_start', 'Дата старта показа в приложении') !!}
                {!! Form::date('date_start',null) !!}
            </div>
            <div class="form-group">
                {!! Form::label('date stop event', 'Дата окончания показа в приложении') !!}
                {!! Form::date('date_stop',null) !!}
            </div>
            <div class="files">
                <div onclick="addFile();">
                    <a><i>Добавить больше файлов</i></a>
                </div>
                <div class="form-group">
                    {!! Form::file('images[]',null) !!}
                </div>
            </div>

            @if(isset($item->id))
                {!! Form::submit('Обновить', ['class' => 'btn btn-info']) !!}
            @else
                {!! Form::submit('Добавить', ['class' => 'btn btn-info']) !!}
            @endif

            {!! Form::close() !!}

        </div><!--/.row-->
    </div>    <!--/.main-->
@endsection
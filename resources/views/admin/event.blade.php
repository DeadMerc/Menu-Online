@extends('layouts.master')  @section('mainRows')     @parent
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Icons</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Акция</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">

        @if(isset($item->id))
            {!! Form::model($item, ['id'=>'eventTableAdd','method'=>'PUT','route' => array('api.events.update', $item->id)]) !!}
            {!! Form::hidden('id', $item->id) !!}
        @else
            {!! Form::open(['id'=>'eventTableAdd','method' => 'POST', 'action' => 'EventsController@store']) !!}
        @endif
        <div class="form-group">
            <label for="sel1">Выберите категорию</label>
            <select name="category_id" onchange="getShopsByCategoryToSelect($(this));" class="form-control">
                <option disabled selected>-- Выберите --</option>
                <?php
                //var_dump($categories);
                ?>
                @foreach($categories as $category)
                    <option value="{{$category['main']['id']}}">
                        {{$category['main']['name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Выберите заведение</label>
            <select name="shop_id" class="shops form-control">
                <option>Выберите категорию</option>
            </select>
        </div>

        <!--<div class="form-group"> {-- Form::label('shop_id', 'Заведение') --}
            {{-- Form::select('shop_id',$shops,null,array('class'=>'form-control','placeholder'=>'Shop_id')) --}}
                </div>-->
        <div class="form-group">
            {!! Form::label('city_id', 'Город') !!}
            {!! Form::select('city_id',$cities,null,array('class'=>'form-control','placeholder'=>'City_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title',null,array('class'=>'form-control','placeholder'=>'Title')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description',null,array('class'=>'form-control','placeholder'=>'Description')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('date_start', 'Date start event') !!}
            {!! Form::date('date_start') !!}
        </div>
        <div class="form-group">
            {!! Form::label('date stop event', 'Date stop event') !!}
            {!! Form::date('date_stop') !!}
        </div>
        <div class="form-group">{!! Form::file('image') !!}
        </div>
        @if(isset($item->id))
            <div>
                {!! Form::submit('Обновить', ['class' => 'btn btn-info']) !!}
            </div>
        @else
            <div>
                {!! Form::submit('Добавить', ['class' => 'btn btn-info']) !!}
            </div>
        @endif

        {!! Form::close() !!}

    </div><!--/.row-->
</div>    <!--/.main-->
@endsection
@extends('layouts.master')  @section('mainRows')     @parent
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
            <h1 class="page-header">Промо</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">

        @if(isset($item->id))
            {!! Form::model($item, ['id'=>'promoTableAdd','method'=>'PUT','route' => array('api.promos.update', $item->id)]) !!}
            {!! Form::hidden('id', $item->id) !!}
        @else
            {!! Form::open(['id'=>'promoTableAdd','method' => 'POST', 'action' => 'PromosController@store']) !!}
        @endif
        <div class="form-group">
            {!! Form::label('shop_id', 'Заведение') !!}
            {!! Form::select('shop_id',$shops,null,array('class'=>'form-control','placeholder'=>'Shop_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('city_id', 'Город') !!}
            {!! Form::select('city_id',$cities,null,array('class'=>'form-control','placeholder'=>'City_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('url', 'Url') !!}
            {!! Form::text('url',null,array('class'=>'form-control','placeholder'=>'Url')) !!}
        </div>
        <div class="form-group">
            {!! Form::file('image') !!}
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
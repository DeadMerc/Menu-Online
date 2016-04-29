@extends('layouts.master')  @section('mainRows')     @parent
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Новость</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">

        @if(isset($item->id))
        {!! Form::model($item, ['id'=>'newsTableAdd','method'=>'PUT','route' => array('api.news.update', $item->id)]) !!}
        {!! Form::hidden('id', $item->id) !!}
        @else
        {!! Form::open(['id'=>'newsTableAdd','method' => 'POST', 'action' => 'NewsController@store']) !!}
        @endif
        <div class="form-group">
            {!! Form::label('city_id', 'Город') !!}
            {!! Form::select('city_id',$cities,null,array('class'=>'form-control','placeholder'=>'City_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title',null,array('class'=>'form-control','placeholder'=>'Title')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('date', 'Date') !!}
            {!! Form::dt_local('date',null,array('class'=>'form-control','placeholder'=>'Date')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description',null,array('class'=>'form-control','placeholder'=>'Description')) !!}
        </div>
        <div class="form-group">{!! Form::file('image') !!}
        </div>
        @if(isset($item->id))
        <div >
            {!! Form::submit('Обновить', ['class' => 'btn btn-info']) !!}
        </div>
        @else
        <div >
            {!! Form::submit('Добавить', ['class' => 'btn btn-info']) !!}
        </div>
        @endif

        {!! Form::close() !!}
                     
    </div><!--/.row-->
</div>	<!--/.main-->
@endsection